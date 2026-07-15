import { createContext, useContext, useState } from 'react';

const ConfirmContext = createContext();

export const ConfirmProvider = ({ children }) => {
  const [modalState, setModalState] = useState({
    isOpen: false,
    onConfirm: null,
    onCancel: null,
  });

  const confirmDelete = () => {
    return new Promise((resolve) => {
      setModalState({
        isOpen: true,
        onConfirm: () => {
          setModalState({ isOpen: false, onConfirm: null, onCancel: null });
          resolve(true);
        },
        onCancel: () => {
          setModalState({ isOpen: false, onConfirm: null, onCancel: null });
          resolve(false);
        },
      });
    });
  };

  return (
    <ConfirmContext.Provider value={{ confirmDelete }}>
      {children}
      {modalState.isOpen && (
        <div className="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 dark:bg-black/80 backdrop-blur-sm p-4">
          <div className="bg-white dark:bg-[#13131a] rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-200 dark:border-white/5 animate-in fade-in zoom-in-95 duration-200">
            <h3 className="text-lg font-semibold text-slate-900 dark:text-white text-center">
              Are you sure want to delete?
            </h3>
            <div className="mt-6 flex justify-end gap-3">
              <button
                onClick={modalState.onCancel}
                className="px-4 py-2 rounded-xl text-sm font-semibold border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors"
              >
                Cancel
              </button>
              <button
                onClick={modalState.onConfirm}
                className="px-4 py-2 rounded-xl text-sm font-semibold bg-rose-500 hover:bg-rose-600 text-white shadow-lg shadow-rose-500/20 dark:shadow-rose-500/10 transition-colors"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      )}
    </ConfirmContext.Provider>
  );
};

export const useConfirm = () => useContext(ConfirmContext);
