import { useCallback, useEffect, useState } from 'react';
import { CirclePlus, Edit, LoaderCircle, Percent, Save } from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Button } from '../../components/ui/Button';
import { Input } from '../../components/ui/FormFields';
import { Modal } from '../../components/ui/Modal';
import { DataTable } from '../../components/ui/DataTable';
import { apiRequest } from '../../lib/api';

const MAX_NAME_LENGTH = 100;
const MAX_PERCENTAGE = 100;

const validateName = (value) => {
  const name = String(value ?? '').trim();
  if (!name) return 'Charge name is required.';
  if (name.length > MAX_NAME_LENGTH) return `Charge name must not exceed ${MAX_NAME_LENGTH} characters.`;
  return '';
};

const validatePercentage = (value) => {
  const text = String(value ?? '').trim();
  if (!text) return 'Discount percentage is required.';
  if (!/^\d+(?:\.\d{1,2})?$/.test(text)) {
    return 'Enter a valid percentage with a maximum of 2 decimal places.';
  }

  const percentage = Number(text);
  if (!Number.isFinite(percentage) || percentage <= 0 || percentage > MAX_PERCENTAGE) {
    return `Percentage must be greater than 0 and no more than ${MAX_PERCENTAGE}.`;
  }
  return '';
};

const AdditionalChargesPage = () => {
  const { addToast } = useToast();
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [errors, setErrors] = useState({});
  const [formData, setFormData] = useState({
    additional_charge_name: '',
    additional_charge_percentage: '',
  });

  const loadData = useCallback(async () => {
    try {
      setIsLoading(true);
      const response = await apiRequest('/settings');
      setFormData({
        additional_charge_name: response.data?.additional_charge_name ?? '',
        additional_charge_percentage: response.data?.additional_charge_percentage ?? '',
      });
    } catch (error) {
      addToast(error.message || 'Unable to load additional charge settings.', 'error');
    } finally {
      setIsLoading(false);
    }
  }, [addToast]);

  useEffect(() => {
    loadData();
  }, [loadData]);

  const openModal = () => {
    setErrors({});
    setIsModalOpen(true);
  };

  const closeModal = () => {
    if (isSaving) return;
    setIsModalOpen(false);
    setErrors({});
  };

  const handleChange = (event) => {
    const { name, value } = event.target;
    setFormData((previous) => ({ ...previous, [name]: value }));

    if (errors[name]) {
      const validator = name === 'additional_charge_name' ? validateName : validatePercentage;
      setErrors((previous) => ({ ...previous, [name]: validator(value) }));
    }
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    const validationErrors = {
      additional_charge_name: validateName(formData.additional_charge_name),
      additional_charge_percentage: validatePercentage(formData.additional_charge_percentage),
    };

    if (Object.values(validationErrors).some(Boolean)) {
      setErrors(validationErrors);
      return;
    }

    const payload = {
      additional_charge_name: formData.additional_charge_name.trim(),
      additional_charge_percentage: Number(formData.additional_charge_percentage).toFixed(2),
    };

    try {
      setIsSaving(true);
      await apiRequest('/settings', { method: 'PUT', body: payload });
      setFormData(payload);
      setErrors({});
      setIsModalOpen(false);
      addToast('Additional charge saved successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to save additional charge.', 'error');
    } finally {
      setIsSaving(false);
    }
  };

  const hasCharge = Boolean(formData.additional_charge_name && formData.additional_charge_percentage);
  const columns = [
    { key: 'additional_charge_name', label: 'Charge Name' },
    {
      key: 'additional_charge_percentage',
      label: 'Discount (%)',
      className: 'text-center',
      render: (value) => `${Number(value).toLocaleString('en-IN')}%`,
    },
    {
      key: 'actions',
      label: 'Actions',
      className: 'text-right',
      render: () => (
        <div className="flex justify-end">
          <button
            type="button"
            onClick={openModal}
            className="rounded-lg p-2 text-amber-600 transition-colors hover:bg-amber-50 dark:hover:bg-amber-500/10"
            title="Edit Additional Charge"
            aria-label="Edit Additional Charge"
          >
            <Edit className="h-4 w-4" />
          </button>
        </div>
      ),
    },
  ];

  return (
    <div className="space-y-6 fade-in max-w-6xl">
      <PageHeader
        title="Global Additional Charge"
        icon={Percent}
        action={<Button icon={CirclePlus} onClick={openModal}>Add Charge</Button>}
      />

      {isLoading ? (
        <div className="flex min-h-[400px] items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading settings...</span>
          </div>
        </div>
      ) : (
        <DataTable
          columns={columns}
          data={hasCharge ? [formData] : []}
          noDataComponent={(
            <div className="flex flex-col items-center justify-center p-8 text-slate-500 dark:text-slate-400">
              <Percent className="mb-4 h-12 w-12 opacity-20" />
              <p>No global additional charge configured.</p>
            </div>
          )}
        />
      )}

      <Modal
        isOpen={isModalOpen}
        onClose={closeModal}
        title={hasCharge ? 'Update Charge' : 'Add Charge'}
      >
        <form className="space-y-6" onSubmit={handleSubmit} noValidate>
          <div className="space-y-4 rounded-xl bg-slate-50 p-4 dark:bg-white/5">
            <p className="text-xs text-slate-500 dark:text-slate-400">
              This percentage is calculated from the product subtotal and added to every estimate.
            </p>

            <Input
              label="Charge Name"
              name="additional_charge_name"
              value={formData.additional_charge_name}
              onChange={handleChange}
              placeholder="For example, Handling Charge"
              maxLength={MAX_NAME_LENGTH}
              required
              autoFocus
              aria-invalid={Boolean(errors.additional_charge_name)}
              aria-describedby={errors.additional_charge_name ? 'charge-name-error' : undefined}
            />
            {errors.additional_charge_name && (
              <p id="charge-name-error" className="text-sm font-medium text-rose-600 dark:text-rose-400" role="alert">
                {errors.additional_charge_name}
              </p>
            )}

            <Input
              label="Discount (%)"
              type="number"
              min="0.01"
              max={MAX_PERCENTAGE}
              step="0.01"
              inputMode="decimal"
              name="additional_charge_percentage"
              value={formData.additional_charge_percentage}
              onChange={handleChange}
              onKeyDown={(event) => {
                if (['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();
              }}
              placeholder="0.00"
              required
              aria-invalid={Boolean(errors.additional_charge_percentage)}
              aria-describedby={errors.additional_charge_percentage ? 'charge-percentage-error' : undefined}
            />
            {errors.additional_charge_percentage && (
              <p id="charge-percentage-error" className="text-sm font-medium text-rose-600 dark:text-rose-400" role="alert">
                {errors.additional_charge_percentage}
              </p>
            )}
          </div>

          <div className="flex flex-wrap justify-end gap-3">
            <Button type="button" variant="secondary" onClick={closeModal} disabled={isSaving}>Cancel</Button>
            <Button type="submit" icon={isSaving ? LoaderCircle : Save} disabled={isSaving}>
              {isSaving ? 'Saving...' : 'Save'}
            </Button>
          </div>
        </form>
      </Modal>
    </div>
  );
};

export default AdditionalChargesPage;
