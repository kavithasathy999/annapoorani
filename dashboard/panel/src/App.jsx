import { BrowserRouter as Router, Navigate, Routes, Route } from 'react-router-dom';
import { ThemeProvider } from './context/ThemeContext';
import { ToastProvider } from './context/ToastContext';
import { AuthProvider, useAuth } from './context/AuthContext';
import { ConfirmProvider } from './context/ConfirmContext';
import { AppLayout } from './components/layout/AppLayout';
import LoginPage from './pages/auth/LoginPage';

// Pages
import DashboardPage from './pages/dashboard/DashboardPage';
import BannersPage from './pages/website/BannersPage';
import BannerFormPage from './pages/website/BannerFormPage';
import FestivalOfferPage from './pages/website/FestivalOfferPage';
import CategoriesPage from './pages/website/CategoriesPage';
import CategoryFormPage from './pages/website/CategoryFormPage';
import ProductsPage from './pages/website/ProductsPage';
import ProductFormPage from './pages/website/ProductFormPage';
import CustomersPage from './pages/website/CustomersPage';
import CustomerFormPage from './pages/website/CustomerFormPage';
import OnOffStatusPage from './pages/orders/OnOffStatusPage';
import BillingInvoicesPage from './pages/orders/BillingInvoicesPage';
import BillingInvoiceFormPage from './pages/orders/BillingInvoiceFormPage';
import BillingInvoicePreviewPage from './pages/orders/BillingInvoicePreviewPage';
import OrderStatusPage from './pages/orders/OrderStatusPage';
import OrderStatusFormPage from './pages/orders/OrderStatusFormPage';
import TodayOrdersPage from './pages/orders/TodayOrdersPage';
import AllOrdersPage from './pages/orders/AllOrdersPage';
import AdditionalChargesPage from './pages/orders/AdditionalChargesPage';
import TopCustomersPage from './pages/report/TopCustomersPage';
import EnquiriesPage from './pages/report/EnquiriesPage';
import BrandsPage from './pages/report/BrandsPage';
import BrandFormPage from './pages/report/BrandFormPage';
import SeoHeadingPage from './pages/seo/SeoHeadingPage';
import SeoDetailsPage from './pages/seo/SeoDetailsPage';
import SeoDetailFormPage from './pages/seo/SeoDetailFormPage';
import GlobalSettingsPage from './pages/settings/GlobalSettingsPage';
import TermsConditionsPage from './pages/settings/TermsConditionsPage';
import AboutUsSetupPage from './pages/settings/AboutUsSetupPage';
import ContactUsSetupPage from './pages/settings/ContactUsSetupPage';
import HomePageSetupPage from './pages/settings/HomePageSetupPage';

function AppContent() {
  const { isAuthenticated, validateLogin, completeLogin } = useAuth();

  if (!isAuthenticated) {
    return <LoginPage onValidate={validateLogin} onLoginComplete={completeLogin} />;
  }

  return (
    <Router>
      <AppLayout>
        <Routes>
          <Route path="/" element={<Navigate to="/dashboard" replace />} />
          <Route path="/dashboard" element={<DashboardPage />} />
            
          {/* Website Routes */}
          <Route path="/website/banners" element={<BannersPage />} />
          <Route path="/website/banners/new" element={<BannerFormPage />} />
          <Route path="/website/banners/:bannerId/edit" element={<BannerFormPage />} />
          <Route path="/website/brands" element={<BrandsPage />} />
          <Route path="/website/brands/new" element={<BrandFormPage />} />
          <Route path="/website/brands/:brandId/edit" element={<BrandFormPage />} />
          <Route path="/website/festival-offer" element={<FestivalOfferPage />} />
          <Route path="/website/categories" element={<CategoriesPage />} />
          <Route path="/website/categories/new" element={<CategoryFormPage />} />
          <Route path="/website/categories/:categoryId/edit" element={<CategoryFormPage />} />
          <Route path="/website/products" element={<ProductsPage />} />
          <Route path="/website/products/new" element={<ProductFormPage />} />
          <Route path="/website/products/:productId/edit" element={<ProductFormPage />} />
          <Route path="/website/customers" element={<CustomersPage />} />
          <Route path="/website/customers/new" element={<CustomerFormPage />} />
          <Route path="/website/customers/:customerId/edit" element={<CustomerFormPage />} />
          
          {/* Orders Routes */}
          <Route path="/orders/status-toggle" element={<OnOffStatusPage />} />
          <Route path="/orders/billing" element={<BillingInvoicesPage />} />
          <Route path="/orders/billing/new" element={<BillingInvoiceFormPage />} />
          <Route path="/orders/billing/:invoiceId/edit" element={<BillingInvoiceFormPage />} />
          <Route path="/orders/billing/preview" element={<BillingInvoicePreviewPage />} />
          <Route path="/orders/billing/:invoiceId/preview" element={<BillingInvoicePreviewPage />} />
          <Route path="/orders/status" element={<OrderStatusPage />} />
          <Route path="/orders/status/new" element={<OrderStatusFormPage />} />
          <Route path="/orders/status/:statusId/edit" element={<OrderStatusFormPage />} />
          <Route path="/orders/today" element={<TodayOrdersPage />} />
          <Route path="/orders/all" element={<AllOrdersPage />} />
          <Route path="/orders/charges" element={<AdditionalChargesPage />} />
          
          {/* Report Routes */}
          <Route path="/report/top-customers" element={<TopCustomersPage />} />
          <Route path="/report/enquiries" element={<EnquiriesPage />} />
          
          {/* SEO Routes */}
          <Route path="/seo/heading" element={<SeoHeadingPage />} />
          <Route path="/seo/details" element={<SeoDetailsPage />} />
          <Route path="/seo/details/new" element={<SeoDetailFormPage />} />
          <Route path="/seo/details/:seoDetailId/edit" element={<SeoDetailFormPage />} />
          
          {/* Settings Routes */}
          <Route path="/settings/global" element={<GlobalSettingsPage />} />
          <Route path="/settings/terms" element={<TermsConditionsPage />} />
          <Route path="/settings/about" element={<AboutUsSetupPage />} />
          <Route path="/settings/contact" element={<ContactUsSetupPage />} />
          <Route path="/settings/homepage" element={<HomePageSetupPage />} />
          <Route path="*" element={<Navigate to="/dashboard" replace />} />
        </Routes>
      </AppLayout>
    </Router>
  );
}

export default function App() {
  return (
    <AuthProvider>
      <ThemeProvider>
        <ToastProvider>
          <ConfirmProvider>
            <AppContent />
          </ConfirmProvider>
        </ToastProvider>
      </ThemeProvider>
    </AuthProvider>
  );
}
