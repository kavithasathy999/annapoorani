import { 
  LayoutDashboard, Image as ImageIcon, List, Box, Users, Map, 
  Moon, Receipt, ClipboardEdit, ShoppingBasket, Award, MessageSquare, 
  Star, Type, FileSearch, PenTool, Globe, BookOpen, Info,
  Phone, Monitor, CreditCard, Package, Handshake, ChevronRight, Percent
} from 'lucide-react';

export const MENU_SECTIONS = [
  {
    title: 'Menu',
    items: [
      { path: '/dashboard', icon: LayoutDashboard, label: 'Dashboard' }
    ]
  },
  {
    title: 'Website',
    items: [
      { path: '/website/banners', icon: ImageIcon, label: 'Banner' },
      { path: '/website/brands', icon: Star, label: 'Brands' },
      { path: '/website/festival-offer', icon: Percent, label: 'Festival Offer' },
      { path: '/website/categories', icon: List, label: 'Categories' },
      { path: '/website/products', icon: Package, label: 'Products' },
      { path: '/website/customers', icon: Handshake, label: 'Customers' },
    ]
  },
  {
    title: 'Orders',
    items: [
      { path: '/orders/status-toggle', icon: Moon, label: 'On Off Status' },
      { path: '/orders/all', icon: Box, label: 'Orders' },
      { path: '/orders/charges', icon: Box, label: 'Additional Charges' },
      { path: '/orders/billing', icon: Receipt, label: 'Billing & Invoices' },
      // { path: '/orders/status', icon: ClipboardEdit, label: 'Order Status' },
      // { path: '/orders/today', icon: ShoppingBasket, label: 'Today Orders' },
    ]
  },
  {
    title: 'Report',
    items: [
      // { path: '/report/top-customers', icon: Award, label: 'Top Customers' },
      { path: '/report/enquiries', icon: MessageSquare, label: 'Contact Enquiries' },
    ]
  },
  {
    title: 'SEO',
    items: [
      { path: '/seo/heading', icon: Type, label: 'SEO Heading' },
      { path: '/seo/details', icon: FileSearch, label: 'SEO Details' },
    ]
  },
  {
    title: 'Settings',
    items: [
      { path: '/settings/global', icon: Globe, label: 'Global Settings' },
      { path: '/settings/terms', icon: BookOpen, label: 'Terms & Conditions' },
      { path: '/settings/about', icon: Info, label: 'About Us Setup' },
      { path: '/settings/contact', icon: Phone, label: 'Contact Us Setup' },
      { path: '/settings/homepage', icon: Monitor, label: 'Home Page Setup' },
    ]
  }
];
