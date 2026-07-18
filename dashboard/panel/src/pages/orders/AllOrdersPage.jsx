import { useCallback, useEffect, useMemo, useState } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import {
  Box,
  ChevronLeft,
  ChevronRight,
  Eye,
  FileText,
  LoaderCircle,
  Pencil,
  Printer,
  RefreshCcw,
  Save,
  Search,
  Trash2,
} from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Card } from '../../components/ui/Card';
import { Button } from '../../components/ui/Button';
import { Badge } from '../../components/ui/Badge';
import { Input, Select } from '../../components/ui/FormFields';
import { Modal } from '../../components/ui/Modal';
import { apiRequest } from '../../lib/api';

const FALLBACK_ORDER_STATUSES = ['Pending', 'Dispatch', 'Complete', 'Printed'];
const DEFAULT_FILTERS = { type: 'All', status: 'All', start_date: '', end_date: '', search: '' };
const PAGE_SIZE = 10;

const formatCurrency = (value) =>
  new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR',
    maximumFractionDigits: 2,
  }).format(Number(value || 0));

const formatDate = (value, withTime = false) => {
  if (!value) return '-';
  const date = new Date(value);
  if (Number.isNaN(date.getTime())) return value;
  return new Intl.DateTimeFormat('en-IN', {
    year: 'numeric',
    month: 'short',
    day: '2-digit',
    ...(withTime ? { hour: '2-digit', minute: '2-digit' } : {}),
  }).format(date);
};

const getCustomerAddress = (order) =>
  [order.customer_address, order.customer_city, order.customer_state, order.customer_pincode].filter(Boolean).join(', ');

const AllOrdersPage = () => {
  const location = useLocation();
  const navigate = useNavigate();
  const { addToast } = useToast();
  const locationFilters = useMemo(() => {
    const params = new URLSearchParams(location.search);
    const search = params.get('search')?.trim() || '';
    return search ? { ...DEFAULT_FILTERS, search } : DEFAULT_FILTERS;
  }, [location.search]);
  const [filters, setFilters] = useState(locationFilters);
  const [orders, setOrders] = useState([]);
  const [stats, setStats] = useState({ totalOrders: 0, totalRevenue: 0, completedOrders: 0 });
  const [pagination, setPagination] = useState({ page: 1, limit: PAGE_SIZE, total: 0, totalPages: 1 });
  const [orderStatuses, setOrderStatuses] = useState(FALLBACK_ORDER_STATUSES);
  const [isLoading, setIsLoading] = useState(true);
  const [isRefreshing, setIsRefreshing] = useState(false);
  const [selectedOrder, setSelectedOrder] = useState(null);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isPdfModalOpen, setIsPdfModalOpen] = useState(false);
  const [pdfUrl, setPdfUrl] = useState('');
  const [isStatusModalOpen, setIsStatusModalOpen] = useState(false);
  const [selectedStatus, setSelectedStatus] = useState('Pending');
  const [isSavingStatus, setIsSavingStatus] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const [orderToDelete, setOrderToDelete] = useState(null);
  const [isDeleting, setIsDeleting] = useState(false);

  const FRONTEND_URL = import.meta.env.VITE_FRONTEND_URL || 'http://localhost:8000';
  const getInvoicePdfUrl = (orderNo) => `${FRONTEND_URL}/invoice/${encodeURIComponent(orderNo)}`;

  const loadReferenceData = useCallback(async () => {
    const statusResponse = await apiRequest('/settings/order-statuses');
    setOrderStatuses((statusResponse.data || []).length > 0 ? statusResponse.data.map((status) => status.name.trim()) : FALLBACK_ORDER_STATUSES);
  }, []);

  const buildQueryString = useCallback((nextFilters, nextPage) => {
    const query = new URLSearchParams({ page: String(nextPage), limit: String(PAGE_SIZE) });
    if (nextFilters.type && nextFilters.type !== 'All') query.set('type', nextFilters.type);
    if (nextFilters.status && nextFilters.status !== 'All') query.set('status', nextFilters.status);
    if (nextFilters.start_date) query.set('start_date', nextFilters.start_date);
    if (nextFilters.end_date) query.set('end_date', nextFilters.end_date);
    if (nextFilters.search.trim()) query.set('search', nextFilters.search.trim());
    return query.toString();
  }, []);

  const loadOrders = useCallback(
    async (nextFilters = filters, nextPage = pagination.page, { showLoader = false } = {}) => {
      try {
        if (showLoader) setIsLoading(true);
        else setIsRefreshing(true);

        const queryString = buildQueryString(nextFilters, nextPage);
        const [ordersResponse, statsResponse] = await Promise.all([
          apiRequest(`/orders?${queryString}`),
          apiRequest(`/orders/stats?${queryString}`),
        ]);

        setOrders(ordersResponse.data || []);
        setPagination(ordersResponse.pagination || { page: nextPage, limit: PAGE_SIZE, total: 0, totalPages: 1 });
        setStats(statsResponse.data || {});
      } catch (error) {
        addToast(error.message || 'Unable to load orders.', 'error');
      } finally {
        setIsLoading(false);
        setIsRefreshing(false);
      }
    },
    [addToast, buildQueryString, filters, pagination.page]
  );

  useEffect(() => {
    const loadPage = async () => {
      try {
        setIsLoading(true);
        await Promise.all([loadReferenceData(), loadOrders(locationFilters, 1)]);
      } catch (error) {
        addToast(error.message || 'Unable to load all orders page.', 'error');
        setIsLoading(false);
      }
    };

    loadPage();
  }, [addToast, loadOrders, loadReferenceData, locationFilters]);

  useEffect(() => {
    setFilters(locationFilters);
  }, [locationFilters]);

  const fetchOrderDetail = useCallback(async (orderId) => {
    const response = await apiRequest(`/orders/${orderId}`);
    return response.data;
  }, []);

  const handleFilterChange = (event) => {
    const { name, value } = event.target;
    setFilters((current) => ({ ...current, [name]: value }));
  };

  const handleApplyFilters = () => loadOrders(filters, 1);
  const handleResetFilters = () => {
    setFilters(DEFAULT_FILTERS);
    loadOrders(DEFAULT_FILTERS, 1);
  };
  const handlePageChange = (nextPage) => {
    if (nextPage < 1 || nextPage > Math.max(pagination.totalPages || 1, 1)) return;
    loadOrders(filters, nextPage);
  };

  const openViewModal = async (orderId) => {
    try {
      const order = await fetchOrderDetail(orderId);
      setSelectedOrder(order);
      setIsViewModalOpen(true);
    } catch (error) {
      addToast(error.message || 'Unable to load order details.', 'error');
    }
  };

  const openPdfModal = (orderNo) => {
    setPdfUrl(getInvoicePdfUrl(orderNo));
    setIsPdfModalOpen(true);
  };

  const openStatusModal = (order) => {
    setSelectedOrder(order);
    setSelectedStatus(order.status || 'Pending');
    setIsStatusModalOpen(true);
  };

  const handleUpdateOrderStatus = async () => {
    if (!selectedOrder?.id) return;

    try {
      setIsSavingStatus(true);
      await apiRequest(`/orders/${selectedOrder.id}/status`, { method: 'PUT', body: { status: selectedStatus } });
      addToast('Order status updated successfully.');
      setIsStatusModalOpen(false);
      await loadOrders(filters, pagination.page);

      if (isViewModalOpen && selectedOrder.id) {
        const updatedOrder = await fetchOrderDetail(selectedOrder.id);
        setSelectedOrder(updatedOrder);
      }
    } catch (error) {
      addToast(error.message || 'Unable to update order status.', 'error');
    } finally {
      setIsSavingStatus(false);
    }
  };

  const handlePrintInvoice = (orderNo) => {
    if (!orderNo) {
      addToast('Unable to open invoice PDF because the order number is missing.', 'error');
      return;
    }

    const pdfWindow = window.open(getInvoicePdfUrl(orderNo), '_blank');
    if (!pdfWindow) {
      addToast('Popup blocked. Allow popups to open invoice PDFs.', 'error');
      return;
    }

    pdfWindow.opener = null;
  };

  const openDeleteModal = (orderId) => {
    setOrderToDelete(orderId);
    setIsDeleteModalOpen(true);
  };

  const closeDeleteModal = () => {
    setOrderToDelete(null);
    setIsDeleteModalOpen(false);
  };

  const handleDeleteOrder = async () => {
    if (!orderToDelete) return;
    try {
      setIsDeleting(true);
      await apiRequest(`/orders/${orderToDelete}`, { method: 'DELETE' });
      addToast('Order deleted successfully.');
      closeDeleteModal();
      await loadOrders(filters, pagination.page);
    } catch (error) {
      addToast(error.message || 'Unable to delete order.', 'error');
    } finally {
      setIsDeleting(false);
    }
  };

  const tableRows = useMemo(
    () =>
      orders.map((order, index) => ({
        ...order,
        serial: (pagination.page - 1) * PAGE_SIZE + index + 1,
        customerLabel: order.customer_name || 'Unknown customer',
        orderDateLabel: formatDate(order.order_date),
        createdLabel: formatDate(order.created_at, true),
        productsList: (order.items || []).map(item => `${item.product_name || `Product #${item.product_id}`} (Qty: ${item.quantity})`).join(', ')
      })),
    [orders, pagination.page]
  );

  return (
    <div className="space-y-6 fade-in">
      <PageHeader
        title="All Orders"
        icon={Box}
        subtitle="Track all ONLINE and BILLING orders, inspect details, and update order operations from one place."
        badge={`${pagination.total || orders.length} orders`}
        action={
          <Button variant="secondary" icon={RefreshCcw} onClick={() => loadOrders(filters, pagination.page)} disabled={isRefreshing}>
            {isRefreshing ? 'Refreshing...' : 'Refresh'}
          </Button>
        }
      />

      <div className="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        {[
          {
            title: 'Total Orders',
            value: String(stats.totalOrders || 0),
            color: 'text-white',
            boxClass: 'border-0 bg-gradient-to-br from-amber-500 via-orange-500 to-orange-600 shadow-[0_12px_30px_rgba(245,158,11,0.28)]',
            pillClass: 'bg-white/20 text-white',
            labelClass: 'text-amber-50/90',
          },
          {
            title: 'Total Revenue',
            value: formatCurrency(stats.totalRevenue),
            color: 'text-white',
            boxClass: 'border-0 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 shadow-[0_12px_30px_rgba(16,185,129,0.25)]',
            pillClass: 'bg-white/20 text-white',
            labelClass: 'text-emerald-50/90',
          },
          {
            title: 'Completed Orders',
            value: String(stats.completedOrders || 0),
            color: 'text-white',
            boxClass: 'border-0 bg-gradient-to-br from-sky-500 via-cyan-500 to-blue-600 shadow-[0_12px_30px_rgba(14,165,233,0.25)]',
            pillClass: 'bg-white/20 text-white',
            labelClass: 'text-sky-50/90',
          },
        ].map((card) => (
          <Card key={card.title} className={`relative overflow-hidden ${card.boxClass}`}>
            <div className="absolute -right-6 top-0 h-24 w-24 rounded-full bg-white/15 blur-2xl"></div>
            <div className="absolute bottom-0 left-6 h-16 w-16 rounded-full bg-white/10 blur-xl"></div>
            <span className={`inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ${card.pillClass}`}>Summary</span>
            <p className={`mt-4 text-sm font-medium ${card.labelClass}`}>{card.title}</p>
            <p className={`mt-2 text-2xl font-bold ${card.color}`}>{card.value}</p>
          </Card>
        ))}
      </div>

      <Card className="space-y-4">
        <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-[repeat(5,minmax(0,1fr))_auto] xl:items-end">
          <Select label="Order Type" name="type" value={filters.type} onChange={handleFilterChange} options={['All', 'ONLINE', 'BILLING']} />
          <Select label="Order Status" name="status" value={filters.status} onChange={handleFilterChange} options={['All', ...orderStatuses]} />
          <Input label="Start Date" name="start_date" type="date" value={filters.start_date} onChange={handleFilterChange} />
          <Input label="End Date" name="end_date" type="date" value={filters.end_date} onChange={handleFilterChange} />
          <Input label="Search" name="search" value={filters.search} onChange={handleFilterChange} placeholder="Order no, customer, phone" />
          <div className="flex flex-col gap-3 md:col-span-2 sm:flex-row sm:items-center sm:justify-end xl:col-span-1 xl:flex-nowrap">
            <Button className="w-full whitespace-nowrap sm:w-auto" icon={Search} onClick={handleApplyFilters}>
              Apply Filters
            </Button>
            <Button className="w-full whitespace-nowrap sm:w-auto" variant="secondary" onClick={handleResetFilters}>
              Reset
            </Button>
          </div>
        </div>
      </Card>

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading orders...</span>
          </div>
        </div>
      ) : (
        <Card>
          <div className="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
            <table className="w-full min-w-[1180px] text-left text-sm">
              <thead className="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500 dark:border-white/10 dark:bg-white/[0.02] dark:text-slate-400">
                <tr>
                  {['S.No', 'Order No', 'Name', 'Email', 'Phone', 'Address', 'City', 'State', 'Pincode', 'Order Status', 'Total', 'Actions'].map((label) => (
                    <th key={label} className="px-4 py-3 font-semibold whitespace-nowrap">
                      {label}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {tableRows.length > 0 ? (
                  tableRows.map((row) => (
                    <tr key={row.id} className="border-b border-slate-100 transition-colors hover:bg-slate-50 dark:border-white/5 dark:hover:bg-white/[0.02]">
                      <td className="px-4 py-3 text-slate-700 dark:text-slate-300">{row.serial}</td>
                      <td className="px-4 py-3 font-semibold text-amber-600 dark:text-amber-400 whitespace-nowrap">{row.order_no}</td>
                      <td className="px-4 py-3 text-slate-800 dark:text-white font-medium whitespace-nowrap">{row.customer_name || '-'}</td>
                      <td className="px-4 py-3 text-slate-600 dark:text-slate-300 whitespace-nowrap">{row.customer_email || '-'}</td>
                      <td className="px-4 py-3 text-slate-600 dark:text-slate-300 whitespace-nowrap">{row.customer_phone || '-'}</td>
                      <td className="px-4 py-3 text-slate-600 dark:text-slate-300 min-w-[200px]">{row.customer_address || '-'}</td>
                      <td className="px-4 py-3 text-slate-600 dark:text-slate-300 whitespace-nowrap">{row.customer_city || '-'}</td>
                      <td className="px-4 py-3 text-slate-600 dark:text-slate-300 whitespace-nowrap">{row.customer_state || '-'}</td>
                      <td className="px-4 py-3 text-slate-600 dark:text-slate-300 whitespace-nowrap">{row.customer_pincode || '-'}</td>

                      <td className="px-4 py-3 whitespace-nowrap">
                        <Badge status={row.status || 'Pending'} />
                      </td>
                      <td className="px-4 py-3 font-semibold text-slate-900 dark:text-white whitespace-nowrap">{formatCurrency(row.total)}</td>
                      <td className="px-4 py-3">
                        <div className="flex gap-2">
                          <button
                            onClick={() => openViewModal(row.id)}
                            className="rounded bg-sky-50 p-1.5 text-sky-600 transition-colors hover:bg-sky-100 dark:bg-sky-500/10 dark:text-sky-400 dark:hover:bg-sky-500/20"
                            title="View order"
                          >
                            <Eye className="h-4 w-4" />
                          </button>
                          <button
                            onClick={() => openPdfModal(row.order_no)}
                            className="rounded bg-indigo-50 p-1.5 text-indigo-600 transition-colors hover:bg-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500/20"
                            title="View PDF"
                          >
                            <FileText className="h-4 w-4" />
                          </button>
                          <button
                            onClick={() => openStatusModal(row)}
                            className="rounded bg-emerald-50 p-1.5 text-emerald-600 transition-colors hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-500/20"
                            title="Update order status"
                          >
                            <Save className="h-4 w-4" />
                          </button>
                          {row.order_type === 'BILLING' && (
                            <>
                              <button
                                onClick={() => navigate(`/orders/billing/${row.id}/edit`)}
                                className="rounded bg-cyan-50 p-1.5 text-cyan-600 transition-colors hover:bg-cyan-100 dark:bg-cyan-500/10 dark:text-cyan-400 dark:hover:bg-cyan-500/20"
                                title="Edit invoice"
                              >
                                <Pencil className="h-4 w-4" />
                              </button>
                              <button
                                onClick={() => handlePrintInvoice(row.order_no)}
                                className="rounded bg-amber-50 p-1.5 text-amber-600 transition-colors hover:bg-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:hover:bg-amber-500/20"
                                title="Print invoice"
                              >
                                <Printer className="h-4 w-4" />
                              </button>
                            </>
                          )}
                          <button
                            onClick={() => openDeleteModal(row.id)}
                            className="rounded bg-rose-50 p-1.5 text-rose-600 transition-colors hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20"
                            title="Delete order"
                          >
                            <Trash2 className="h-4 w-4" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan={13} className="px-4 py-10 text-center text-slate-500 dark:text-slate-400">
                      No orders found.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
          <div className="mt-4 flex flex-col gap-3 border-t border-slate-200 pt-4 sm:flex-row sm:items-center sm:justify-between dark:border-white/10">
            <p className="text-sm text-slate-500 dark:text-slate-400">
              Showing {pagination.total === 0 ? 0 : (pagination.page - 1) * pagination.limit + 1} to{' '}
              {Math.min(pagination.page * pagination.limit, pagination.total)} of {pagination.total} entries
            </p>
            <div className="flex items-center gap-1">
              <Button variant="secondary" className="px-3 py-1 text-xs" onClick={() => handlePageChange(pagination.page - 1)} disabled={pagination.page <= 1} icon={ChevronLeft}>
                Prev
              </Button>
              <span className="px-3 py-1 text-sm font-medium text-slate-800 dark:text-white">
                {pagination.page} / {pagination.totalPages || 1}
              </span>
              <Button variant="secondary" className="px-3 py-1 text-xs" onClick={() => handlePageChange(pagination.page + 1)} disabled={pagination.page >= (pagination.totalPages || 1)}>
                Next <ChevronRight className="h-4 w-4" />
              </Button>
            </div>
          </div>
        </Card>
      )}

      <Modal
        isOpen={isViewModalOpen}
        onClose={() => {
          setIsViewModalOpen(false);
          setSelectedOrder(null);
        }}
        title={selectedOrder ? `Order ${selectedOrder.order_no}` : 'Order Details'}
        maxWidthClass="max-w-4xl"
      >
        {!selectedOrder ? (
          <div className="flex min-h-40 items-center justify-center text-slate-500 dark:text-slate-400">Loading order...</div>
        ) : (
          <div className="space-y-6">
            <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
              <Card>
                <p className="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500">Order No</p>
                <p className="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{selectedOrder.order_no}</p>
              </Card>
              <Card>
                <p className="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500">Created</p>
                <p className="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{formatDate(selectedOrder.created_at, true)}</p>
              </Card>
              <Card>
                <p className="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500">Order Status</p>
                <div className="mt-2"><Badge status={selectedOrder.status || 'Pending'} /></div>
              </Card>
            </div>

            <div className="grid gap-6 lg:grid-cols-2">
              <Card title="Customer Details">
                <div className="space-y-2 text-sm text-slate-600 dark:text-slate-300">
                  <p className="font-semibold text-slate-900 dark:text-white">{selectedOrder.customer_name || '-'}</p>
                  <p>{selectedOrder.customer_phone || '-'}</p>
                  <p>{getCustomerAddress(selectedOrder) || '-'}</p>
                </div>
              </Card>
              <Card title="Notes">
                <p className="text-sm text-slate-600 dark:text-slate-300">{selectedOrder.notes || '-'}</p>
              </Card>
            </div>

            <Card title="Order Items">
              <div className="overflow-x-auto">
                <table className="w-full min-w-[600px] text-sm">
                  <thead className="border-b border-slate-200 text-left text-xs uppercase tracking-wide text-slate-500 dark:border-white/10 dark:text-slate-400">
                    <tr>
                      <th className="px-3 py-2">Item</th>
                      <th className="px-3 py-2">Qty</th>
                      <th className="px-3 py-2">Rate</th>
                      <th className="px-3 py-2">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    {(selectedOrder.items || []).map((item) => (
                      <tr key={`${item.product_id}-${item.id}`} className="border-b border-slate-100 dark:border-white/5">
                        <td className="px-3 py-3 font-medium text-slate-800 dark:text-white">{item.product_name || `Product #${item.product_id}`}</td>
                        <td className="px-3 py-3 text-slate-600 dark:text-slate-300">{item.quantity}</td>
                        <td className="px-3 py-3 text-slate-600 dark:text-slate-300">{formatCurrency(item.price)}</td>
                        <td className="px-3 py-3 font-semibold text-slate-900 dark:text-white">{formatCurrency(item.total)}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </Card>

            <div className="ml-auto w-full max-w-sm rounded-xl border border-slate-200 bg-slate-50 p-5 dark:border-white/10 dark:bg-white/[0.02]">
              <div className="space-y-3 text-sm">
                <div className="flex justify-between text-slate-600 dark:text-slate-300"><span>Sub Total</span><strong>{formatCurrency(selectedOrder.sub_total)}</strong></div>
                <div className="flex justify-between text-slate-600 dark:text-slate-300"><span>Shipping</span><strong>{formatCurrency(selectedOrder.shipping)}</strong></div>
                <div className="flex justify-between text-slate-600 dark:text-slate-300"><span>Discount</span><strong>{formatCurrency(selectedOrder.discount)}</strong></div>
                <div className="flex justify-between border-t border-slate-200 pt-3 text-base font-bold text-slate-900 dark:border-white/10 dark:text-white">
                  <span>Grand Total</span>
                  <span>{formatCurrency(selectedOrder.total)}</span>
                </div>
              </div>
            </div>

            <div className="flex flex-wrap justify-end gap-3">
              <Button variant="secondary" onClick={() => openStatusModal(selectedOrder)}>Update Status</Button>
              {selectedOrder.order_type === 'BILLING' && (
                <>
                  <Button variant="secondary" onClick={() => navigate(`/orders/billing/${selectedOrder.id}/edit`)}>Edit Invoice</Button>
                  <Button onClick={() => handlePrintInvoice(selectedOrder.order_no)} icon={Printer}>Print Invoice</Button>
                </>
              )}
            </div>
          </div>
        )}
      </Modal>

      <Modal isOpen={isStatusModalOpen} onClose={() => setIsStatusModalOpen(false)} title={selectedOrder ? `Update Order Status - ${selectedOrder.order_no}` : 'Update Order Status'}>
        <div className="space-y-4">
          <Select label="Order Status" value={selectedStatus} onChange={(event) => setSelectedStatus(event.target.value)} options={orderStatuses.map((status) => ({ label: status, value: status }))} />
          <div className="flex justify-end gap-3">
            <Button variant="secondary" onClick={() => setIsStatusModalOpen(false)} disabled={isSavingStatus}>Cancel</Button>
            <Button onClick={handleUpdateOrderStatus} disabled={isSavingStatus}>{isSavingStatus ? 'Saving...' : 'Update Status'}</Button>
          </div>
        </div>
      </Modal>

      <Modal isOpen={isPdfModalOpen} onClose={() => setIsPdfModalOpen(false)} title="View Order PDF" maxWidthClass="max-w-4xl">
        <div className="flex flex-col space-y-4 h-[70vh]">
          {pdfUrl && (
            <iframe
              src={pdfUrl}
              className="flex-1 w-full rounded-md border border-slate-200 dark:border-white/10"
              title="PDF Viewer"
            ></iframe>
          )}
          <div className="flex justify-end gap-3">
            <Button variant="secondary" onClick={() => setIsPdfModalOpen(false)}>Close</Button>
            <Button onClick={() => window.open(`${pdfUrl}?download=1`, '_blank')} icon={FileText}>Download PDF</Button>
          </div>
        </div>
      </Modal>

      <Modal isOpen={isDeleteModalOpen} onClose={closeDeleteModal} title="Confirm Delete">
        <div className="space-y-4">
          <p className="text-slate-600 dark:text-slate-300">Are you sure want to delete?</p>
          <div className="flex justify-end gap-3">
            <Button variant="secondary" onClick={closeDeleteModal} disabled={isDeleting}>Cancel</Button>
            <Button onClick={handleDeleteOrder} disabled={isDeleting} className="bg-rose-600 hover:bg-rose-700 text-white border-transparent">{isDeleting ? 'Deleting...' : 'Delete'}</Button>
          </div>
        </div>
      </Modal>
    </div>
  );
};

export default AllOrdersPage;
