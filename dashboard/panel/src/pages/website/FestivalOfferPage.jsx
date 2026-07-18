import { useEffect, useState } from 'react';
import { Percent, LoaderCircle, Save } from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Card } from '../../components/ui/Card';
import { Button } from '../../components/ui/Button';
import { Input } from '../../components/ui/FormFields';
import { WebsitePageSelect } from '../../components/ui/WebsitePageSelect';
import { apiRequest } from '../../lib/api';

const initialForm = {
  offer_heading: '',
  offer_subheading: '',
  offer_end_date: '',
  offer_button_text: '',
  offer_button_link: '',
};

const textAreaClassName =
  'w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm transition-all focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-white/10 dark:bg-[#0a0a0f] dark:text-white';

const FestivalOfferPage = () => {
  const { addToast } = useToast();
  const [form, setForm] = useState(initialForm);
  const [errors, setErrors] = useState({});
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);

  const loadSettings = async () => {
    try {
      setIsLoading(true);
      const response = await apiRequest('/settings/festival-offer');
      setForm({
        ...initialForm,
        ...(response.data || {}),
      });
    } catch (error) {
      addToast(error.message || 'Unable to load festival offer settings.', 'error');
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    loadSettings();
  }, []);

  const validateForm = () => {
    const newErrors = {};
    if (!form.offer_heading.trim()) {
      newErrors.offer_heading = 'Offer heading is required.';
    }
    if (!form.offer_subheading.trim()) {
      newErrors.offer_subheading = 'Offer subheading is required.';
    }
    if (!form.offer_end_date.trim()) {
      newErrors.offer_end_date = 'Offer end date & time is required.';
    } else {
      const selectedDate = new Date(form.offer_end_date);
      if (isNaN(selectedDate.getTime())) {
        newErrors.offer_end_date = 'Please enter a valid date and time.';
      }
    }
    if (!form.offer_button_text.trim()) {
      newErrors.offer_button_text = 'Button text is required.';
    }
    if (!form.offer_button_link.trim()) {
      newErrors.offer_button_link = 'Button link URL is required.';
    }
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setForm((prev) => ({
      ...prev,
      [name]: value,
    }));
    if (errors[name]) {
      setErrors((prev) => ({
        ...prev,
        [name]: '',
      }));
    }
  };

  const handleSave = async (e) => {
    e.preventDefault();
    if (!validateForm()) {
      addToast('Please fill all required fields.', 'error');
      return;
    }
    try {
      setIsSaving(true);
      await apiRequest('/settings/festival-offer', {
        method: 'PUT',
        body: form,
      });
      addToast('Festival offer settings saved successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to save settings.', 'error');
    } finally {
      setIsSaving(false);
    }
  };

  return (
    <div className="space-y-6 fade-in">
      <PageHeader
        title="Festival Offer"
        icon={Percent}
        subtitle="Manage the homepage countdown timer, offer banner heading, copy, and shop button."
      />

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading festival offer settings...</span>
          </div>
        </div>
      ) : (
        <form onSubmit={handleSave} className="space-y-6">
          <Card title="Offer Details" icon={Percent}>
            <div className="space-y-6">
              <div className="grid gap-6 md:grid-cols-2">
                <div className="flex flex-col gap-1">
                  <Input
                    label="Offer Heading"
                    name="offer_heading"
                    value={form.offer_heading}
                    onChange={handleInputChange}
                    placeholder="e.g. 🧨 Festival Season Sale<br>Ends Soon!"
                    disabled={isSaving}
                  />
                  {errors.offer_heading && (
                    <span className="text-xs font-medium text-rose-500 mt-1 block">{errors.offer_heading}</span>
                  )}
                </div>
                <div className="flex flex-col gap-1">
                  <Input
                    label="Offer End Date & Time"
                    type="datetime-local"
                    name="offer_end_date"
                    value={form.offer_end_date}
                    onChange={handleInputChange}
                    disabled={isSaving}
                  />
                  {errors.offer_end_date && (
                    <span className="text-xs font-medium text-rose-500 mt-1 block">{errors.offer_end_date}</span>
                  )}
                </div>
              </div>

              <div className="flex flex-col gap-1.5">
                <label className="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Offer Subheading
                </label>
                <textarea
                  name="offer_subheading"
                  rows="4"
                  value={form.offer_subheading}
                  onChange={handleInputChange}
                  placeholder="Don't miss the biggest cracker sale of the year..."
                  className={`${textAreaClassName} ${errors.offer_subheading ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : ''}`}
                  disabled={isSaving}
                />
                {errors.offer_subheading && (
                  <span className="text-xs font-medium text-rose-500 block">{errors.offer_subheading}</span>
                )}
              </div>

              <div className="grid gap-6 md:grid-cols-2">
                <div className="flex flex-col gap-1">
                  <Input
                    label="Button Text"
                    name="offer_button_text"
                    value={form.offer_button_text}
                    onChange={handleInputChange}
                    placeholder="e.g. Shop Now"
                    disabled={isSaving}
                  />
                  {errors.offer_button_text && (
                    <span className="text-xs font-medium text-rose-500 mt-1 block">{errors.offer_button_text}</span>
                  )}
                </div>
                <div className="flex flex-col gap-1">
                  <WebsitePageSelect
                    label="Button Link URL"
                    name="offer_button_link"
                    value={form.offer_button_link}
                    onChange={handleInputChange}
                    disabled={isSaving}
                  />
                  {errors.offer_button_link && (
                    <span className="text-xs font-medium text-rose-500 mt-1 block">{errors.offer_button_link}</span>
                  )}
                </div>
              </div>
            </div>

            <div className="mt-6 flex justify-end">
              <Button type="submit" disabled={isSaving} icon={Save}>
                {isSaving ? 'Saving...' : 'Save Settings'}
              </Button>
            </div>
          </Card>
        </form>
      )}
    </div>
  );
};

export default FestivalOfferPage;
