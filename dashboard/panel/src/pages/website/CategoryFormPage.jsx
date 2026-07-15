import { useEffect, useState } from 'react';
import { ArrowLeft, List, LoaderCircle, Save, UploadCloud } from 'lucide-react';
import { useNavigate, useParams } from 'react-router-dom';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Button } from '../../components/ui/Button';
import { Card } from '../../components/ui/Card';
import { Input, Select } from '../../components/ui/FormFields';
import { apiRequest, getAssetUrl } from '../../lib/api';

const initialForm = {
  data_id: '',
  name: '',
  sort_order: '0',
  is_active: '1',
  image: '',
};

const CategoryFormPage = () => {
  const navigate = useNavigate();
  const { categoryId } = useParams();
  const { addToast } = useToast();
  const isEditMode = Boolean(categoryId);

  const [form, setForm] = useState(initialForm);
  const [selectedFile, setSelectedFile] = useState(null);
  const [previewUrl, setPreviewUrl] = useState('');
  const [isLoading, setIsLoading] = useState(isEditMode);
  const [isSubmitting, setIsSubmitting] = useState(false);

  useEffect(() => {
    return () => {
      if (previewUrl && previewUrl.startsWith('blob:')) {
        URL.revokeObjectURL(previewUrl);
      }
    };
  }, [previewUrl]);

  useEffect(() => {
    if (!isEditMode) {
      return;
    }

    let isMounted = true;

    const loadCategory = async () => {
      try {
        setIsLoading(true);
        const response = await apiRequest(`/categories/${categoryId}`);

        if (!isMounted) {
          return;
        }

        const category = response.data || {};
        setForm({
          data_id: category.data_id || '',
          name: category.name || '',
          sort_order: String(category.sort_order ?? 0),
          is_active: String(Number(category.is_active ?? 1)),
          image: category.image || '',
        });
        if (category.image) {
          setPreviewUrl(getAssetUrl(category.image));
        }
      } catch (error) {
        addToast(error.message || 'Unable to load category.', 'error');
        navigate('/website/categories');
      } finally {
        if (isMounted) {
          setIsLoading(false);
        }
      }
    };

    loadCategory();

    return () => {
      isMounted = false;
    };
  }, [addToast, categoryId, isEditMode, navigate]);

  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setForm((current) => ({ ...current, [name]: value }));
  };

  const handleFileChange = (event) => {
    const file = event.target.files?.[0];
    if (!file) {
      return;
    }

    if (file.size > 3 * 1024 * 1024) {
      addToast('Image size must be less than or equal to 3MB.', 'error');
      event.target.value = '';
      return;
    }

    if (previewUrl && previewUrl.startsWith('blob:')) {
      URL.revokeObjectURL(previewUrl);
    }

    setSelectedFile(file);
    setPreviewUrl(URL.createObjectURL(file));
  };

  const handleSubmit = async () => {
    if (!form.name.trim()) {
      addToast('Category name is required.', 'error');
      return;
    }

    if (isEditMode && !form.data_id.trim()) {
      addToast('Category Data ID is required.', 'error');
      return;
    }

    try {
      setIsSubmitting(true);
      const payload = new FormData();
      payload.append('data_id', form.data_id.trim());
      payload.append('name', form.name.trim());
      payload.append('sort_order', String(Number(form.sort_order || 0)));
      payload.append('is_active', form.is_active);

      if (selectedFile) {
        payload.append('image', selectedFile);
      } else if (form.image === null || form.image === '') {
        payload.append('image', '');
      } else {
        payload.append('image', form.image);
      }

      if (isEditMode) {
        await apiRequest(`/categories/${categoryId}`, {
          method: 'PUT',
          body: payload,
        });
        addToast('Category updated successfully.');
      } else {
        await apiRequest('/categories', {
          method: 'POST',
          body: payload,
        });
        addToast('Category created successfully.');
      }

      navigate('/website/categories');
    } catch (error) {
      addToast(error.message || 'Unable to save category.', 'error');
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="space-y-6 fade-in max-w-4xl">
      <PageHeader
        title={isEditMode ? 'Edit Category' : 'Add Category'}
        icon={List}
        subtitle="Use a dedicated page to manage category details."
        action={
          <div className="flex gap-3">
            <Button variant="secondary" onClick={() => navigate('/website/categories')} icon={ArrowLeft}>
              Back
            </Button>
            <Button onClick={handleSubmit} icon={Save} disabled={isSubmitting || isLoading}>
              {isSubmitting ? 'Saving...' : isEditMode ? 'Update Category' : 'Create Category'}
            </Button>
          </div>
        }
      />

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading category...</span>
          </div>
        </div>
      ) : (
        <Card className="space-y-6">
          <div className="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-8 items-start">
            {/* Left Column: Form Fields */}
            <div className="space-y-6">
              <div className="grid gap-6 md:grid-cols-2">
                <Input
                  label="Category Name"
                  name="name"
                  value={form.name}
                  onChange={handleInputChange}
                  placeholder="Sparklers"
                />
                <Input
                  label="Sort Order"
                  name="sort_order"
                  type="number"
                  min="0"
                  value={form.sort_order}
                  onChange={handleInputChange}
                />
              </div>

              <div className="grid gap-6 md:grid-cols-2">
                <Input
                  label="Data ID"
                  name="data_id"
                  value={form.data_id}
                  onChange={handleInputChange}
                  disabled={!isEditMode}
                  placeholder={isEditMode ? 'CAT-001' : 'Auto-generated when you save'}
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
            </div>

            {/* Right Column: Image Upload */}
            <div className="flex flex-col gap-4">
              <label className="block cursor-pointer">
                <span className="mb-1.5 block text-sm font-medium text-slate-600 dark:text-slate-400">
                  Category Image <span className="text-xs text-slate-400 dark:text-slate-500">(Max 3MB)</span>
                </span>
                <span className="sr-only">Upload Image</span>
                <div className="flex h-[200px] w-full flex-col items-center justify-center rounded-lg border-2 border-dashed border-slate-300 bg-slate-50/50 p-4 text-center transition-colors hover:bg-slate-100/80 dark:border-white/20 dark:bg-[#0a0a0f]/50 dark:hover:bg-white/[0.04]">
                  <input type="file" accept="image/*" className="hidden" onChange={handleFileChange} />
                  {previewUrl ? (
                    <div className="relative h-full w-full group">
                      <img src={previewUrl} alt="Category preview" className="h-full w-full rounded-md object-contain" />
                      <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-md">
                        <p className="text-white text-xs font-semibold">Change Image</p>
                      </div>
                    </div>
                  ) : (
                    <>
                      <UploadCloud className="mb-3 h-8 w-8 text-slate-400 dark:text-slate-500" />
                      <p className="text-sm font-medium text-slate-600 dark:text-slate-300">Click to Upload</p>
                      <p className="mt-1 text-xs text-slate-400 dark:text-slate-500">
                        PNG, JPG, WEBP up to 3MB
                      </p>
                    </>
                  )}
                </div>
              </label>
              {previewUrl && (
                <button
                  type="button"
                  onClick={() => {
                    if (previewUrl && previewUrl.startsWith('blob:')) {
                      URL.revokeObjectURL(previewUrl);
                    }
                    setSelectedFile(null);
                    setPreviewUrl('');
                    setForm((curr) => ({ ...curr, image: '' }));
                  }}
                  className="text-xs text-rose-500 hover:text-rose-600 hover:underline transition-colors text-right"
                >
                  Remove Image
                </button>
              )}
            </div>
          </div>
        </Card>
      )}
    </div>
  );
};

export default CategoryFormPage;
