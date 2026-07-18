import { useCallback, useEffect, useMemo, useState } from 'react';
import { Image as ImageIcon, Edit, Trash, Plus, LoaderCircle } from 'lucide-react';
import { useNavigate } from 'react-router-dom';
import { useToast } from '../../context/ToastContext';
import { useConfirm } from '../../context/ConfirmContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { DataTable } from '../../components/ui/DataTable';
import { Button } from '../../components/ui/Button';
import { Badge } from '../../components/ui/Badge';
import { Card } from '../../components/ui/Card';
import { Input } from '../../components/ui/FormFields';
import { apiRequest, getAssetUrl } from '../../lib/api';
import { Calendar } from 'lucide-react';

const BannersPage = () => {
  const navigate = useNavigate();
  const { addToast } = useToast();
  const { confirmDelete } = useConfirm();
  const [banners, setBanners] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [badgeCount, setBadgeCount] = useState('');
  const [badgeLabel, setBadgeLabel] = useState('');
  const [isBadgeLoading, setIsBadgeLoading] = useState(true);
  const [isBadgeSaving, setIsBadgeSaving] = useState(false);

  const loadBanners = useCallback(async () => {
    try {
      setIsLoading(true);
      const response = await apiRequest('/banners');
      setBanners(response.data || []);
    } catch (error) {
      addToast(error.message || 'Unable to load banners.', 'error');
    } finally {
      setIsLoading(false);
    }
  }, [addToast]);

  const loadWelcomeBadge = useCallback(async () => {
    try {
      setIsBadgeLoading(true);
      const response = await apiRequest('/settings/welcome-badge');
      if (response.success && response.data) {
        setBadgeCount(response.data.welcome_badge_count || '');
        setBadgeLabel(response.data.welcome_badge_label || '');
      }
    } catch (error) {
      addToast(error.message || 'Unable to load welcome badge settings.', 'error');
    } finally {
      setIsBadgeLoading(false);
    }
  }, [addToast]);

  useEffect(() => {
    loadBanners();
    loadWelcomeBadge();
  }, [loadBanners, loadWelcomeBadge]);

  const handleSaveBadge = async (e) => {
    e.preventDefault();
    if (!badgeCount.trim() || !badgeLabel.trim()) {
      addToast('Please fill out both badge count and label.', 'error');
      return;
    }

    try {
      setIsBadgeSaving(true);
      const response = await apiRequest('/settings/welcome-badge', {
        method: 'PUT',
        body: {
          welcome_badge_count: badgeCount,
          welcome_badge_label: badgeLabel,
        },
      });
      if (response.success) {
        addToast('Welcome badge settings updated successfully.');
      }
    } catch (error) {
      addToast(error.message || 'Unable to update welcome badge settings.', 'error');
    } finally {
      setIsBadgeSaving(false);
    }
  };

  const handleDelete = async (banner) => {
    const confirmed = await confirmDelete();
    if (!confirmed) {
      return;
    }

    try {
      await apiRequest(`/banners/${banner.id}`, { method: 'DELETE' });
      addToast('Banner deleted successfully.');
      await loadBanners();
    } catch (error) {
      addToast(error.message || 'Unable to delete banner.', 'error');
    }
  };

  const tableRows = useMemo(
    () =>
      banners.map((banner) => ({
        ...banner,
        imageUrl: getAssetUrl(banner.image),
        statusLabel: Number(banner.is_active) === 1 ? 'Active' : 'Inactive',
      })),
    [banners]
  );

  const columns = [
    { key: 'id', label: 'ID' },
    {
      key: 'imageUrl',
      label: 'Image',
      render: (value, row) => (
        <img
          src={value}
          className="h-14 w-28 rounded-lg border border-slate-200 object-cover shadow-sm dark:border-white/10"
          alt={row.name}
        />
      ),
    },
    {
      key: 'name',
      label: 'Banner Name',
      render: (value) => <span className="font-medium text-slate-800 dark:text-white">{value}</span>,
    },
    { key: 'sort_order', label: 'Order' },
    {
      key: 'statusLabel',
      label: 'Status',
      render: (value) => <Badge status={value} />,
    },
    {
      key: 'actions',
      label: 'Actions',
      render: (_, row) => (
        <div className="flex gap-2">
          <button
            onClick={() => navigate(`/website/banners/${row.id}/edit`)}
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
        title="Home Banners"
        icon={ImageIcon}
        subtitle="Add, update, and reorder home page banners with live database sync."
        badge={`${banners.length} total`}
        action={
          <Button icon={Plus} onClick={() => navigate('/website/banners/new')} className="w-full sm:w-auto">
            Add Banner
          </Button>
        }
      />

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading banners...</span>
          </div>
        </div>
      ) : (
        <DataTable
          columns={columns}
          data={tableRows}
          searchPlaceholder="Search banners..."
          exportable={false}
        />
      )}

      {/* Update Year Component (Welcome Badge) */}
      <Card title="Update Welcome Badge (Years of Experience)" icon={Calendar}>
        {isBadgeLoading ? (
          <div className="flex py-6 items-center justify-center">
            <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
              <LoaderCircle className="h-5 w-5 animate-spin" />
              <span>Loading badge settings...</span>
            </div>
          </div>
        ) : (
          <form onSubmit={handleSaveBadge} className="space-y-4">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <Input
                label="Badge Count (e.g. 26)"
                type="text"
                name="welcome_badge_count"
                value={badgeCount}
                onChange={(e) => setBadgeCount(e.target.value)}
                placeholder="Enter years/count (e.g. 26)"
                disabled={isBadgeSaving}
              />
              <Input
                label="Badge Label (e.g. Years)"
                type="text"
                name="welcome_badge_label"
                value={badgeLabel}
                onChange={(e) => setBadgeLabel(e.target.value)}
                placeholder="Enter label (e.g. Years / Years of Excellence)"
                disabled={isBadgeSaving}
              />
            </div>
            <div className="flex justify-end mt-2">
              <Button
                type="submit"
                disabled={isBadgeSaving}
                className="w-full sm:w-auto"
              >
                {isBadgeSaving ? 'Saving...' : 'Update Badge'}
              </Button>
            </div>
          </form>
        )}
      </Card>
    </div>
  );
};

export default BannersPage;
