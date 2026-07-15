import { createContext, useContext, useState, useEffect } from 'react';
import { apiRequest } from '../lib/api';

const AuthContext = createContext();

const TOKEN_KEY = 'authToken';
const USER_KEY = 'authUser';
const LOGIN_TIME_KEY = 'authLoginTime';
const EXPIRATION_TIME = 2 * 60 * 60 * 1000; // 2 hours

export const AuthProvider = ({ children }) => {
  const isSessionValid = () => {
    const loginTime = sessionStorage.getItem(LOGIN_TIME_KEY);
    if (!loginTime) return false;
    return new Date().getTime() - parseInt(loginTime, 10) <= EXPIRATION_TIME;
  };

  const [token, setToken] = useState(() => {
    return isSessionValid() ? sessionStorage.getItem(TOKEN_KEY) : null;
  });
  
  const [user, setUser] = useState(() => {
    if (isSessionValid()) {
      const rawUser = sessionStorage.getItem(USER_KEY);
      return rawUser ? JSON.parse(rawUser) : null;
    }
    return null;
  });

  const isAuthenticated = Boolean(token);

  useEffect(() => {
    if (token && !isSessionValid()) {
      logout();
    }
    const interval = setInterval(() => {
      if (token && !isSessionValid()) {
        logout();
      }
    }, 60000); // Check every minute
    return () => clearInterval(interval);
  }, [token]);

  const validateLogin = async (email, password) => {
    try {
      const response = await apiRequest('/auth/login', {
        method: 'POST',
        body: { email, password },
      });

      return {
        success: true,
        token: response.token,
        user: response.user,
      };
    } catch (error) {
      return {
        success: false,
        message: error.message || 'Login failed.',
      };
    }
  };

  const completeLogin = (authData) => {
    if (!authData?.token) {
      return;
    }

    const now = new Date().getTime().toString();
    setToken(authData.token);
    setUser(authData.user || null);
    sessionStorage.setItem(TOKEN_KEY, authData.token);
    sessionStorage.setItem(USER_KEY, JSON.stringify(authData.user || null));
    sessionStorage.setItem(LOGIN_TIME_KEY, now);
  };

  const logout = () => {
    setToken(null);
    setUser(null);
    sessionStorage.removeItem(TOKEN_KEY);
    sessionStorage.removeItem(USER_KEY);
    sessionStorage.removeItem(LOGIN_TIME_KEY);
  };

  return (
    <AuthContext.Provider value={{ isAuthenticated, token, user, validateLogin, completeLogin, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
