import { useCallback, useEffect, useMemo, useState } from 'react';
import { Users, Edit, Trash, Plus, LoaderCircle, Eye } from 'lucide-react';
import { useNavigate } from 'react-router-dom';
import { useToast } from '../../context/ToastContext';
import { useConfirm } from '../../context/ConfirmContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { DataTable } from '../../components/ui/DataTable';
import { Button } from '../../components/ui/Button';
import { Modal } from '../../components/ui/Modal';
import { apiRequest } from '../../lib/api';

const CustomersPage = () => {
  const navigate = useNavigate();
  const { addToast } = useToast();
  const { confirmDelete } = useConfirm();
  const [customers, setCustomers] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [viewCustomer, setViewCustomer] = useState(null);

  const loadCustomers = useCallback(async () => {
    try {
      setIsLoading(true);
      const response = await apiRequest('/customers?limit=500');
      setCustomers(response.data || []);
    } catch (error) {
      addToast(error.message || 'Unable to load customers.', 'error');
    } finally {
      setIsLoading(false);
    }
  }, [addToast]);

  useEffect(() => {
    loadCustomers();
  }, [loadCustomers]);

  const handleDelete = async (customer) => {
    const confirmed = await confirmDelete();
    if (!confirmed) {
      return;
    }

    try {
      await apiRequest(`/customers/${customer.id}`, { method: 'DELETE' });
      addToast('Customer deleted successfully.');
      await loadCustomers();
    } catch (error) {
      addToast(error.message || 'Unable to delete customer.', 'error');
    }
  };

  const tableRows = useMemo(
    () =>
      customers.map((customer, index) => ({
        ...customer,
        serial: index + 1,
        addressLabel: [customer.address, customer.city, customer.state, customer.pincode].filter(Boolean).join(', '),
      })),
    [customers]
  );

  const columns = [
    { key: 'serial', label: 'S.No' },
    {
      key: 'name',
      label: 'Name',
      render: (value) => <span className="font-semibold text-slate-800 dark:text-white">{value}</span>,
    },
    {
      key: 'email',
      label: 'Email',
      render: (value) => <span className="text-slate-600 dark:text-slate-400">{value || '-'}</span>,
    },
    {
      key: 'phone',
      label: 'Phone Number',
      render: (value) => <span className="font-medium text-slate-700 dark:text-slate-300">{value}</span>,
    },
    {
      key: 'addressLabel',
      label: 'Address',
      render: (value) => <span className="block max-w-[280px] truncate text-slate-500 dark:text-slate-400">{value || '-'}</span>,
    },
    {
      key: 'city',
      label: 'City',
      render: (value) => <span className="text-slate-600 dark:text-slate-300">{value || '-'}</span>,
    },
    {
      key: 'actions',
      label: 'Actions',
      render: (_, row) => (
        <div className="flex gap-2">
          <button
            onClick={() => setViewCustomer(row)}
            className="rounded bg-indigo-50 p-1.5 text-indigo-600 transition-colors hover:bg-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500/20"
            aria-label={`View ${row.name}`}
          >
            <Eye className="h-4 w-4" />
          </button>
          <button
            onClick={() => navigate(`/website/customers/${row.id}/edit`)}
            className="rounded bg-emerald-50 p-1.5 text-emerald-600 transition-colors hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-500/20"
            aria-label={`Edit ${row.name}`}
          >
            <Edit className="h-4 w-4" />
          </button>
          <button
            onClick={() => handleDelete(row)}
            className="rounded bg-rose-50 p-1.5 text-rose-600 transition-colors hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20"
            aria-label={`Delete ${row.name}`}
          >
            <Trash className="h-4 w-4" />
          </button>
        </div>
      ),
    },
  ];

  return (
    <div className="space-y-6 fade-in">
      <PageHeader
        title="Customers"
        icon={Users}
        subtitle="Manage stored customer records and contact details."
        badge={`${customers.length} total`}
        action={
          <Button icon={Plus} onClick={() => navigate('/website/customers/new')}>
            Add Customer
          </Button>
        }
      />

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading customers...</span>
          </div>
        </div>
      ) : (
        <DataTable
          columns={columns}
          data={tableRows}
          searchPlaceholder="Search customers..."
          exportFileName="customers"
        />
      )}

      {/* View Customer Modal */}
      <Modal isOpen={!!viewCustomer} onClose={() => setViewCustomer(null)} title="Customer Details">
        {viewCustomer && (
          <div className="space-y-4">
            <div className="grid grid-cols-2 gap-4">
              <div>
                <span className="block text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-400">Name</span>
                <span className="mt-1 block text-sm font-medium text-slate-700 dark:text-white">{viewCustomer.name}</span>
              </div>
              <div>
                <span className="block text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-400">Phone</span>
                <span className="mt-1 block text-sm font-medium text-slate-700 dark:text-white">{viewCustomer.phone}</span>
              </div>
              <div className="col-span-2">
                <span className="block text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-400">Email</span>
                <span className="mt-1 block text-sm text-slate-700 dark:text-slate-300">{viewCustomer.email || '-'}</span>
              </div>
              <div className="col-span-2">
                <span className="block text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-400">Address</span>
                <span className="mt-1 block text-sm text-slate-700 dark:text-slate-300">{viewCustomer.address || '-'}</span>
              </div>
              <div>
                <span className="block text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-400">City</span>
                <span className="mt-1 block text-sm text-slate-700 dark:text-slate-300">{viewCustomer.city || '-'}</span>
              </div>
              <div>
                <span className="block text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-400">State</span>
                <span className="mt-1 block text-sm text-slate-700 dark:text-slate-300">{viewCustomer.state || '-'}</span>
              </div>
              <div>
                <span className="block text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-400">Pincode</span>
                <span className="mt-1 block text-sm text-slate-700 dark:text-slate-300">{viewCustomer.pincode || '-'}</span>
              </div>
            </div>
            <div className="mt-6 flex justify-end">
              <Button variant="outline" onClick={() => setViewCustomer(null)}>Close</Button>
            </div>
          </div>
        )}
      </Modal>
    </div>
  );
};

export default CustomersPage;
