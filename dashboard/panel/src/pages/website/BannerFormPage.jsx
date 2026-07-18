import { useEffect, useState } from 'react';
import { ArrowLeft, Image as ImageIcon, LoaderCircle, Save, UploadCloud } from 'lucide-react';
import { useNavigate, useParams } from 'react-router-dom';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Button } from '../../components/ui/Button';
import { Card } from '../../components/ui/Card';
import { Badge } from '../../components/ui/Badge';
import { Input, Select } from '../../components/ui/FormFields';
import { apiRequest, getAssetUrl } from '../../lib/api';

const BANNER_WIDTH = 1080;
const BANNER_HEIGHT = 600;
const BANNER_SIZE_LABEL = `${BANNER_WIDTH} x ${BANNER_HEIGHT} px`;

const initialForm = {
  name: '',
  sort_order: '0',
  is_active: '1',
};

const BannerFormPage = () => {
  const navigate = useNavigate();
  const { bannerId } = useParams();
  const { addToast } = useToast();
  const isEditMode = Boolean(bannerId);

  const [form, setForm] = useState(initialForm);
  const [selectedFile, setSelectedFile] = useState(null);
  const [previewUrl, setPreviewUrl] = useState('');
  const [imageError, setImageError] = useState('');
  const [isValidatingImage, setIsValidatingImage] = useState(false);
  const [isLoading, setIsLoading] = useState(isEditMode);
  const [isSubmitting, setIsSubmitting] = useState(false);

  useEffect(() => {
    return () => {
      if (previewUrl.startsWith('blob:')) {
        URL.revokeObjectURL(previewUrl);
      }
    };
  }, [previewUrl]);

  useEffect(() => {
    if (!isEditMode) {
      return;
    }

    let isMounted = true;

    const loadBanner = async () => {
      try {
        setIsLoading(true);
        const response = await apiRequest('/banners');
        const banner = (response.data || []).find((item) => String(item.id) === String(bannerId));

        if (!banner) {
          throw new Error('Banner not found.');
        }

        if (!isMounted) {
          return;
        }

        setForm({
          name: banner.name || '',
          sort_order: String(banner.sort_order ?? 0),
          is_active: String(Number(banner.is_active ?? 1)),
        });
        setPreviewUrl(getAssetUrl(banner.image));
      } catch (error) {
        addToast(error.message || 'Unable to load banner.', 'error');
        navigate('/website/banners');
      } finally {
        if (isMounted) {
          setIsLoading(false);
        }
      }
    };

    loadBanner();

    return () => {
      isMounted = false;
    };
  }, [addToast, bannerId, isEditMode, navigate]);

  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setForm((current) => ({ ...current, [name]: value }));
  };

  const handleFileChange = async (event) => {
    const file = event.target.files?.[0];
    if (!file) {
      return;
    }

    const fileInput = event.target;
    const candidatePreviewUrl = URL.createObjectURL(file);
    setIsValidatingImage(true);
    setImageError('');

    try {
      const dimensions = await new Promise((resolve, reject) => {
        const image = new Image();
        image.onload = () => resolve({
          width: image.naturalWidth,
          height: image.naturalHeight,
        });
        image.onerror = () => reject(new Error('Unable to read the selected image dimensions.'));
        image.src = candidatePreviewUrl;
      });

      if (dimensions.width !== BANNER_WIDTH || dimensions.height !== BANNER_HEIGHT) {
        throw new Error(`Banner image must be exactly ${BANNER_SIZE_LABEL}.`);
      }

      if (previewUrl.startsWith('blob:')) {
        URL.revokeObjectURL(previewUrl);
      }

      setSelectedFile(file);
      setPreviewUrl(candidatePreviewUrl);
    } catch (error) {
      URL.revokeObjectURL(candidatePreviewUrl);
      fileInput.value = '';
      setImageError(error.message);
      addToast(error.message, 'error');
    } finally {
      setIsValidatingImage(false);
    }
  };

  const handleSubmit = async () => {
    if (!form.name.trim()) {
      addToast('Banner name is required.', 'error');
      return;
    }

    if (!isEditMode && !selectedFile) {
      addToast('Banner image is required.', 'error');
      return;
    }

    try {
      setIsSubmitting(true);
      const payload = new FormData();
      payload.append('name', form.name.trim());
      payload.append('sort_order', String(Number(form.sort_order || 0)));
      payload.append('is_active', form.is_active);

      if (selectedFile) {
        payload.append('image', selectedFile);
      }

      if (isEditMode) {
        await apiRequest(`/banners/${bannerId}`, { method: 'PUT', body: payload });
        addToast('Banner updated successfully.');
      } else {
        await apiRequest('/banners', { method: 'POST', body: payload });
        addToast('Banner created successfully.');
      }

      navigate('/website/banners');
    } catch (error) {
      addToast(error.message || 'Unable to save banner.', 'error');
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="space-y-6 fade-in max-w-5xl">
      <PageHeader
        title={isEditMode ? 'Edit Banner' : 'Add Banner'}
        icon={ImageIcon}
        subtitle={`Required banner image size: ${BANNER_SIZE_LABEL}.`}
        action={
          <div className="flex gap-3">
            <Button variant="secondary" onClick={() => navigate('/website/banners')} icon={ArrowLeft}>
              Back
            </Button>
            <Button onClick={handleSubmit} icon={Save} disabled={isSubmitting || isLoading || isValidatingImage}>
              {isSubmitting ? 'Saving...' : isEditMode ? 'Update Banner' : 'Create Banner'}
            </Button>
          </div>
        }
      />

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading banner...</span>
          </div>
        </div>
      ) : (
        <div className="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
          <Card className="space-y-6">
            <div className="grid gap-6">
              <Input
                label="Banner Name"
                name="name"
                value={form.name}
                onChange={handleInputChange}
                placeholder="Festival Mega Offer"
              />
            </div>

            <div className="grid gap-6 md:grid-cols-2">
              <Input
                label="Sort Order"
                name="sort_order"
                type="number"
                min="0"
                value={form.sort_order}
                onChange={handleInputChange}
              />
              <Select
                label="Status"
                name="is_active"
                value={form.is_active}
                onChange={handleInputChange}
                options={[
                  { label: 'Active', value: '1' },
                  { label: 'Inactive', value: '0' },
                ]}
              />
            </div>

            <label className="block">
              <span className="mb-1.5 block text-sm font-medium text-slate-600 dark:text-slate-400">
                Banner Image ({BANNER_SIZE_LABEL})
              </span>
              <div className="cursor-pointer rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center transition-colors hover:bg-slate-100 dark:border-white/20 dark:bg-white/[0.01] dark:hover:bg-white/[0.03]">
                <input
                  type="file"
                  accept="image/*"
                  className="hidden"
                  onChange={handleFileChange}
                  disabled={isValidatingImage}
                />
                <UploadCloud className="mx-auto mb-3 h-9 w-9 text-slate-400" />
                <p className="text-sm font-medium text-slate-700 dark:text-slate-300">
                  {isValidatingImage ? 'Validating image...' : 'Click to upload PNG, JPG, WEBP or SVG'}
                </p>
                <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">
                  Required size: {BANNER_SIZE_LABEL}
                </p>
                <p className="mt-1 text-xs text-slate-400 dark:text-slate-500">
                  Max file size 10MB
                </p>
              </div>
              {imageError && (
                <span className="mt-1.5 block text-sm font-medium text-rose-600 dark:text-rose-400">
                  {imageError}
                </span>
              )}
            </label>
          </Card>

          <Card className="space-y-4">
            <div className="flex items-center justify-between">
              <p className="text-sm font-medium text-slate-600 dark:text-slate-400">Preview</p>
              <span className="rounded-full border border-slate-200 px-3 py-1 text-xs font-medium text-slate-500 dark:border-white/10 dark:text-slate-400">
                {BANNER_SIZE_LABEL}
              </span>
            </div>

            <div className="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm dark:border-white/10 dark:bg-white/[0.02]">
              {previewUrl ? (
                <img src={previewUrl} alt="Banner preview" className="aspect-[9/5] w-full object-cover" />
              ) : (
                <div className="flex aspect-[9/5] items-center justify-center px-4 text-center text-sm text-slate-400 dark:text-slate-500">
                  Upload a {BANNER_SIZE_LABEL} banner image to preview the output.
                </div>
              )}
              <div className="space-y-2 border-t border-slate-200 p-4 dark:border-white/10">
                <p className="truncate text-sm font-semibold text-slate-800 dark:text-white">
                  {form.name || 'Banner title'}
                </p>
                <Badge status={form.is_active === '1' ? 'Active' : 'Inactive'} />
              </div>
            </div>
          </Card>
        </div>
      )}
    </div>
  );
};

export default BannerFormPage;
