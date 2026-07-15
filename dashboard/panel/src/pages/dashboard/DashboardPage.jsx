import { useCallback, useEffect, useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import {
  Clock,
  LayoutDashboard,
  List,
  LoaderCircle,
  Package,
  Plus,
  ShoppingBag,
  TrendingUp,
  Users,
  Image as ImageIcon,
  Award,
} from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Card } from '../../components/ui/Card';
import { Button } from '../../components/ui/Button';
import { apiRequest } from '../../lib/api';

const formatDate = (value, withTime = false) => {
  if (!value) {
    return '-';
  }

  const date = new Date(value);
  if (Number.isNaN(date.getTime())) {
    return value;
  }

  return new Intl.DateTimeFormat('en-IN', {
    year: 'numeric',
    month: 'short',
    day: '2-digit',
    ...(withTime ? { hour: '2-digit', minute: '2-digit' } : {}),
  }).format(date);
};

const getInitials = (name = '') =>
  name
    .split(' ')
    .filter(Boolean)
    .slice(0, 2)
    .map((word) => word[0]?.toUpperCase() || '')
    .join('') || 'CU';

const DashboardPage = () => {
  const navigate = useNavigate();
  const { addToast } = useToast();
  const [dashboardData, setDashboardData] = useState({
    stats: {
      totalCategories: 0,
      totalBanners: 0,
      globalDiscount: 0,
      totalProducts: 0,
      totalCustomers: 0,
      totalBrands: 0,
      totalEnquiries: 0,
      storeStatus: 1,
    },
    newCustomers: [],
  });
  const [isLoading, setIsLoading] = useState(true);
  const [isRefreshing, setIsRefreshing] = useState(false);

  const loadDashboard = useCallback(
    async ({ showLoader = false } = {}) => {
      try {
        if (showLoader) {
          setIsLoading(true);
        } else {
          setIsRefreshing(true);
        }

        const response = await apiRequest('/dashboard');
        setDashboardData({
          stats: response.data?.stats || {},
          newCustomers: response.data?.newCustomers || [],
        });
      } catch (error) {
        addToast(error.message || 'Unable to load dashboard data.', 'error');
      } finally {
        setIsLoading(false);
        setIsRefreshing(false);
      }
    },
    [addToast]
  );

  useEffect(() => {
    loadDashboard({ showLoader: true });
  }, [loadDashboard]);

  const statsCards = useMemo(
    () => [
      {
        title: 'Banners',
        path: '/website/banners',
        value: dashboardData.stats.totalBanners || 0,
        icon: ImageIcon,
        iconColor: 'text-white',
        valueColor: 'text-white',
        labelColor: 'text-orange-50/90',
        pillClass: 'bg-white/18 text-white',
        iconBg: 'bg-white/16',
        cardClass: 'border-0 bg-gradient-to-r from-[#ff8100] to-[#ff5200] shadow-[0_14px_34px_rgba(255,129,0,0.24)]',
      },
      {
        title: 'Brands',
        path: '/website/brands',
        value: dashboardData.stats.totalBrands || 0,
        icon: Award,
        iconColor: 'text-white',
        valueColor: 'text-white',
        labelColor: 'text-emerald-50/90',
        pillClass: 'bg-white/18 text-white',
        iconBg: 'bg-white/16',
        cardClass: 'border-0 bg-gradient-to-r from-[#21c89f] to-[#04a090] shadow-[0_14px_34px_rgba(33,200,159,0.24)]',
      },
      {
        title: 'Festival Offer',
        path: '/website/festival-offer',
        value: `${dashboardData.stats.globalDiscount || 0}%`,
        icon: TrendingUp,
        iconColor: 'text-white',
        valueColor: 'text-white',
        labelColor: 'text-pink-50/90',
        pillClass: 'bg-white/18 text-white',
        iconBg: 'bg-white/16',
        cardClass: 'border-0 bg-gradient-to-r from-[#fc3d7a] to-[#c604ec] shadow-[0_14px_34px_rgba(252,61,122,0.24)]',
      },
      {
        title: 'Categories',
        path: '/website/categories',
        value: dashboardData.stats.totalCategories || 0,
        icon: List,
        iconColor: 'text-white',
        valueColor: 'text-white',
        labelColor: 'text-sky-50/90',
        pillClass: 'bg-white/18 text-white',
        iconBg: 'bg-white/16',
        cardClass: 'border-0 bg-gradient-to-r from-[#20c8f5] to-[#0563eb] shadow-[0_14px_34px_rgba(32,200,245,0.24)]',
      },
      {
        title: 'Products',
        path: '/website/products',
        value: dashboardData.stats.totalProducts || 0,
        icon: Package,
        iconColor: 'text-white',
        valueColor: 'text-white',
        labelColor: 'text-purple-50/90',
        pillClass: 'bg-white/18 text-white',
        iconBg: 'bg-white/16',
        cardClass: 'border-0 bg-gradient-to-r from-[#a855f7] to-[#7e22ce] shadow-[0_14px_34px_rgba(168,85,247,0.24)]',
      },
      {
        title: 'Customers',
        path: '/website/customers',
        value: dashboardData.stats.totalCustomers || 0,
        icon: Users,
        iconColor: 'text-white',
        valueColor: 'text-white',
        labelColor: 'text-amber-50/90',
        pillClass: 'bg-white/18 text-white',
        iconBg: 'bg-white/16',
        cardClass: 'border-0 bg-gradient-to-r from-[#f59e0b] to-[#d97706] shadow-[0_14px_34px_rgba(245,158,11,0.24)]',
      },
      {
        title: 'On Off Status',
        path: '/orders/status-toggle',
        value: dashboardData.stats.storeStatus === 1 ? 'Open' : 'Closed',
        icon: Clock,
        iconColor: 'text-white',
        valueColor: 'text-white',
        labelColor: 'text-rose-50/90',
        pillClass: 'bg-white/18 text-white',
        iconBg: 'bg-white/16',
        cardClass: 'border-0 bg-gradient-to-r from-[#f43f5e] to-[#be123c] shadow-[0_14px_34px_rgba(244,63,94,0.24)]',
      },
      {
        title: 'Contact Enquiries',
        path: '/report/enquiries',
        value: dashboardData.stats.totalEnquiries || 0,
        icon: ShoppingBag,
        iconColor: 'text-white',
        valueColor: 'text-white',
        labelColor: 'text-teal-50/90',
        pillClass: 'bg-white/18 text-white',
        iconBg: 'bg-white/16',
        cardClass: 'border-0 bg-gradient-to-r from-[#14b8a6] to-[#0f766e] shadow-[0_14px_34px_rgba(20,184,166,0.24)]',
      }
    ],
    [dashboardData.stats]
  );

  if (isLoading) {
    return (
      <div className="space-y-6 fade-in">
        <PageHeader title="Dashboard" icon={LayoutDashboard} subtitle="Loading your live business summary." />
        <div className="flex min-h-96 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading dashboard...</span>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="space-y-6 fade-in">
      <PageHeader
        title="Dashboard"
        icon={LayoutDashboard}
        subtitle="Track catalog, interactions, and recent activity from one live admin overview."
        action={
          <div className="flex flex-wrap gap-3">
            <Button variant="secondary" onClick={() => loadDashboard()} disabled={isRefreshing}>
              {isRefreshing ? 'Refreshing...' : 'Refresh'}
            </Button>
          </div>
        }
      />

      <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {statsCards.map((card) => (
          <div
            key={card.title}
            onClick={() => navigate(card.path)}
            className={`group relative overflow-hidden rounded-2xl p-4 transition-transform duration-300 hover:-translate-y-0.5 cursor-pointer ${card.cardClass}`}
          >
            <div className="absolute -right-5 -top-5 h-20 w-20 rounded-full bg-white/14 blur-2xl"></div>
            <div className="absolute bottom-0 left-6 h-14 w-14 rounded-full bg-black/10 blur-xl"></div>
            <div className="relative flex items-start justify-between gap-3">
              {/* <span className={`inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] ${card.pillClass}`}>
                {card.title}
              </span> */}
              <div className={`flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 ${card.iconBg}`}>
                <card.icon className={`h-5 w-5 ${card.iconColor}`} />
              </div>
            </div>
            <div className="relative mt-8">
              <p className={`text-3xl font-black tracking-tight ${card.valueColor}`}>{card.value}</p>
              <p className={`mt-1 text-xs font-medium uppercase tracking-[0.18em] ${card.labelColor}`}>{card.title}</p>
            </div>
            <div className="relative mt-5 h-1.5 overflow-hidden rounded-full bg-white/12">
              <div className="h-full w-2/3 rounded-full bg-white/70"></div>
            </div>
          </div>
        ))}
      </div>

      <div className="grid gap-6">
        <Card title="New Customers" icon={Users}>
          <div className="space-y-4">
            {dashboardData.newCustomers.length > 0 ? (
              dashboardData.newCustomers.map((customer) => (
                <div
                  key={customer.id}
                  className="flex items-center gap-3 rounded-lg border border-transparent p-2 transition-colors hover:border-slate-100 hover:bg-slate-50 dark:hover:border-white/5 dark:hover:bg-white/[0.02]"
                >
                  <div className="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-sm font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-300">
                    {getInitials(customer.name)}
                  </div>
                  <div className="flex-1">
                    <p className="text-sm font-semibold text-slate-800 dark:text-white">{customer.name}</p>
                    <p className="text-xs text-slate-500 dark:text-slate-400">
                      {[customer.city || 'Unknown city', customer.phone || 'No phone'].join(' • ')}
                    </p>
                    <p className="mt-1 text-xs text-slate-400 dark:text-slate-500">{formatDate(customer.created_at)}</p>
                  </div>
                </div>
              ))
            ) : (
              <div className="flex min-h-48 items-center justify-center rounded-xl border border-dashed border-slate-200 text-sm text-slate-500 dark:border-white/10 dark:text-slate-400">
                No new customers available.
              </div>
            )}
            <Button variant="secondary" className="w-full" onClick={() => navigate('/website/customers')}>
              View All Customers
            </Button>
          </div>
        </Card>
      </div>
    </div>
  );
};

export default DashboardPage;
