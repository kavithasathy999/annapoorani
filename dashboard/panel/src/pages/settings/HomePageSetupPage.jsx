import { useEffect, useMemo, useState } from 'react';
import {
  BadgeCheck,
  Home,
  Image as ImageIcon,
  Info,
  LoaderCircle,
  Save,
  ShoppingBag,
  Star,
  UploadCloud,
} from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Card } from '../../components/ui/Card';
import { Button } from '../../components/ui/Button';
import { Input } from '../../components/ui/FormFields';
import { RichTextEditor } from '../../components/ui/RichTextEditor';
import { WebsitePageSelect } from '../../components/ui/WebsitePageSelect';
import { apiRequest, getAssetUrl } from '../../lib/api';
import { validateImageDimensions } from '../../utils/imageValidation';

const HERO_IMAGE_DIMENSIONS = { width: 1920, height: 686, label: 'Section Image' };

const tabs = [
  { id: 'Welcome Section', label: 'Welcome Section', icon: Home },
  { id: 'Featured Products', label: 'Featured Products', icon: ShoppingBag },
  { id: 'Why Choose Us', label: 'Why Choose Us', icon: Info },
];

const initialForm = {
  hero_eyebrow: '',
  hero_heading_html: '',
  hero_description_html: '',
  hero_badge_1_text: '',
  hero_badge_2_text: '',
  hero_badge_3_text: '',
  hero_badge_4_text: '',
  hero_section_image: '',
  hero_cta_text: '',
  hero_cta_link: '',
  featured_products_eyebrow: '',
  featured_products_heading: '',
  featured_product_ids: [],
  why_choose_eyebrow: '',
  why_choose_title: '',
  why_choose_subtitle: '',
  why_choose_pillar_1_title: '',
  why_choose_pillar_1_text: '',
  why_choose_pillar_2_title: '',
  why_choose_pillar_2_text: '',
  why_choose_pillar_3_title: '',
  why_choose_pillar_3_text: '',
  why_choose_pillar_4_title: '',
  why_choose_pillar_4_text: '',
  why_choose_stat_1_label: '',
  why_choose_stat_1_value: '',
  why_choose_stat_2_label: '',
  why_choose_stat_2_value: '',
  why_choose_stat_3_label: '',
  why_choose_stat_3_value: '',
  why_choose_stat_4_label: '',
  why_choose_stat_4_value: '',
  why_choose_bottom_1_value: '',
  why_choose_bottom_1_label: '',
  why_choose_bottom_2_value: '',
  why_choose_bottom_2_label: '',
  why_choose_bottom_3_value: '',
  why_choose_bottom_3_label: '',
  why_choose_bottom_4_value: '',
  why_choose_bottom_4_label: '',
};

const textAreaClassName =
  'w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm transition-all focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-white/10 dark:bg-[#0a0a0f] dark:text-white';

const SectionHeader = ({ icon: Icon, title, description }) => (
  <div className="space-y-1 border-b border-slate-100 pb-5 dark:border-white/10">
    <div className="flex items-center gap-2 text-slate-800 dark:text-white">
      <Icon className="h-5 w-5 text-amber-500" />
      <h3 className="text-xl font-semibold">{title}</h3>
    </div>
    {description ? <p className="text-sm text-slate-500 dark:text-slate-400">{description}</p> : null}
  </div>
);

const UploadTile = ({ label, note, previewUrl, emptyLabel, onChange, disabled = false }) => (
  <div className="space-y-3">
    <p className="text-sm font-medium text-slate-700 dark:text-slate-300">
      {label} <span className="text-amber-600/80 dark:text-amber-300/80">{note}</span>
    </p>
    <label className="block">
      <input type="file" accept="image/*" className="hidden" onChange={onChange} disabled={disabled} />
      <div className="cursor-pointer rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center transition-colors hover:border-amber-300 hover:bg-amber-50/40 dark:border-white/10 dark:bg-white/[0.02] dark:hover:border-amber-500/20 dark:hover:bg-white/[0.04]">
        <div className="mb-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-[#0f0f15]">
          <div className="flex h-44 items-center justify-center overflow-hidden rounded-lg bg-white p-4 dark:bg-[#0b0b11]">
            {previewUrl ? (
              <img src={previewUrl} alt={label} className="max-h-full max-w-full object-contain" />
            ) : (
              <div className="flex h-full w-full items-center justify-center rounded-lg border border-slate-200 text-xs text-slate-400 dark:border-white/10 dark:text-slate-500">
                {emptyLabel}
              </div>
            )}
          </div>
        </div>
        <div className="mt-4 flex items-center justify-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-300">
          <UploadCloud className="h-4 w-4" />
          <span>{previewUrl ? `Change ${label}` : `Upload ${label}`}</span>
        </div>
      </div>
    </label>
  </div>
);

const ProductSelectionCard = ({ product, isSelected, onToggle }) => (
  <button
    type="button"
    onClick={() => onToggle(product.id)}
    className={`relative overflow-hidden rounded-2xl border p-4 text-left transition-all ${
      isSelected
        ? 'border-amber-400 bg-amber-50/60 shadow-sm dark:border-amber-400/50 dark:bg-amber-500/10'
        : 'border-slate-200 bg-white hover:border-amber-300 hover:bg-amber-50/30 dark:border-white/10 dark:bg-[#13131a] dark:hover:border-amber-500/20'
    }`}
  >
    <div
      className={`absolute right-3 top-3 flex h-7 w-7 items-center justify-center rounded-full border text-xs font-semibold ${
        isSelected
          ? 'border-amber-400 bg-amber-400 text-white'
          : 'border-slate-200 bg-slate-50 text-slate-400 dark:border-white/10 dark:bg-white/[0.03]'
      }`}
    >
      {isSelected ? '✓' : ''}
    </div>

    {product.image ? (
      <img
        src={getAssetUrl(product.image)}
        alt={product.name}
        className="mb-4 h-28 w-full rounded-xl border border-slate-200 object-cover dark:border-white/10"
      />
    ) : (
      <div className="mb-4 flex h-28 w-full items-center justify-center rounded-xl border border-dashed border-slate-200 text-xs text-slate-400 dark:border-white/10 dark:text-slate-500">
        No Image
      </div>
    )}

    <p className="line-clamp-2 text-lg font-semibold text-slate-900 dark:text-white">{product.name}</p>
    <p className="mt-2 text-sm uppercase tracking-wide text-slate-500 dark:text-slate-400">
      {product.category_name || 'Uncategorized'}
    </p>
    <p className="mt-3 text-2xl font-bold text-amber-600 dark:text-amber-400">
      ₹{Number(product.sale_price || product.price || 0).toFixed(2)}
    </p>
  </button>
);

const StatValueField = ({ labelName, labelValue, valueName, valueValue, onChange }) => (
  <div className="space-y-3 rounded-2xl border border-slate-200 bg-slate-50/60 p-4 dark:border-white/10 dark:bg-white/[0.02]">
    <Input label="Label" name={labelName} value={labelValue} onChange={onChange} />
    <Input label="Value" name={valueName} value={valueValue} onChange={onChange} />
  </div>
);

const HomePageSetupPage = () => {
  const { addToast } = useToast();
  const [activeTab, setActiveTab] = useState(tabs[0].id);
  const [form, setForm] = useState(initialForm);
  const [products, setProducts] = useState([]);
  const [selectedFiles, setSelectedFiles] = useState({ hero_section_image: null });
  const [previews, setPreviews] = useState({ hero_section_image: '' });
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);
  const [isValidatingImage, setIsValidatingImage] = useState(false);

  const selectedProductsCount = form.featured_product_ids.length;

  const selectedProductsSet = useMemo(
    () => new Set(form.featured_product_ids.map((item) => Number(item))),
    [form.featured_product_ids]
  );

  useEffect(() => {
    return () => {
      Object.values(previews).forEach((url) => {
        if (url.startsWith('blob:')) {
          URL.revokeObjectURL(url);
        }
      });
    };
  }, [previews]);

  const loadHomePageSetup = async () => {
    try {
      setIsLoading(true);
      const [homepageResponse, productsResponse] = await Promise.all([
        apiRequest('/settings/homepage'),
        apiRequest('/products?limit=500'),
      ]);

      const homepageData = homepageResponse.data || {};
      setForm({
        ...initialForm,
        ...homepageData,
        featured_product_ids: Array.isArray(homepageData.featured_product_ids)
          ? homepageData.featured_product_ids.map((item) => Number(item)).filter(Boolean)
          : [],
      });
      setProducts(productsResponse.data || []);
      setSelectedFiles({ hero_section_image: null });
      setPreviews((current) => {
        Object.values(current).forEach((url) => {
          if (url.startsWith('blob:')) {
            URL.revokeObjectURL(url);
          }
        });

        return {
          hero_section_image: homepageData.hero_section_image
            ? getAssetUrl(homepageData.hero_section_image)
            : '',
        };
      });
    } catch (error) {
      addToast(error.message || 'Unable to load homepage settings.', 'error');
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    loadHomePageSetup();
  }, []);

  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setForm((current) => ({
      ...current,
      [name]: value,
    }));
  };

  const handleFileChange = (fieldName) => async (event) => {
    const file = event.target.files?.[0];
    if (!file) {
      return;
    }

    const fileInput = event.target;
    setIsValidatingImage(true);

    try {
      const { previewUrl } = await validateImageDimensions(file, HERO_IMAGE_DIMENSIONS);

      setSelectedFiles((current) => ({
        ...current,
        [fieldName]: file,
      }));

      setPreviews((current) => {
        if (current[fieldName]?.startsWith('blob:')) {
          URL.revokeObjectURL(current[fieldName]);
        }

        return {
          ...current,
          [fieldName]: previewUrl,
        };
      });
    } catch (error) {
      fileInput.value = '';
      addToast(error.message, 'error');
    } finally {
      setIsValidatingImage(false);
    }
  };

  const handleProductToggle = (productId) => {
    setForm((current) => {
      const normalizedProductId = Number(productId);
      const alreadySelected = current.featured_product_ids.includes(normalizedProductId);

      if (alreadySelected) {
        return {
          ...current,
          featured_product_ids: current.featured_product_ids.filter((item) => item !== normalizedProductId),
        };
      }

      if (current.featured_product_ids.length >= 7) {
        addToast('Exactly 7 featured products are allowed.', 'error');
        return current;
      }

      return {
        ...current,
        featured_product_ids: [...current.featured_product_ids, normalizedProductId],
      };
    });
  };

  const handleSave = async () => {
    if (form.featured_product_ids.length !== 7) {
      addToast('Select exactly 7 featured products before saving.', 'error');
      return;
    }

    try {
      setIsSaving(true);
      const payload = new FormData();

      Object.entries(form).forEach(([key, value]) => {
        if (key === 'featured_product_ids') {
          payload.append(key, JSON.stringify(value));
          return;
        }

        payload.append(key, value ?? '');
      });

      if (selectedFiles.hero_section_image) {
        payload.append('hero_section_image', selectedFiles.hero_section_image);
      }

      const response = await apiRequest('/settings/homepage', {
        method: 'PUT',
        body: payload,
      });

      const responseData = response.data || {};
      setForm({
        ...initialForm,
        ...responseData,
        featured_product_ids: Array.isArray(responseData.featured_product_ids)
          ? responseData.featured_product_ids.map((item) => Number(item)).filter(Boolean)
          : [],
      });
      setSelectedFiles({ hero_section_image: null });
      setPreviews((current) => {
        Object.values(current).forEach((url) => {
          if (url.startsWith('blob:')) {
            URL.revokeObjectURL(url);
          }
        });

        return {
          hero_section_image: responseData.hero_section_image
            ? getAssetUrl(responseData.hero_section_image)
            : '',
        };
      });
      addToast('Homepage settings saved successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to save homepage settings.', 'error');
    } finally {
      setIsSaving(false);
    }
  };

  const renderWelcomeSection = () => (
    <Card className="space-y-8">
      <SectionHeader
        icon={Home}
        title="Welcome Content"
        description="Update the hero section content, badges, image, and CTA for the homepage."
      />

      <div className="grid gap-6 md:grid-cols-2">
        <Input
          label="Hero Eyebrow"
          name="hero_eyebrow"
          value={form.hero_eyebrow}
          onChange={handleInputChange}
          placeholder="Est. 2020 - Sivakasi"
        />

        <RichTextEditor
          label="Main Heading"
          name="hero_heading_html"
          value={form.hero_heading_html}
          onChange={handleInputChange}
          minHeightClass="min-h-[180px]"
          placeholder="Welcome to The Bluvel Crackers!"
        />
      </div>

      <RichTextEditor
        label="Welcome Description (Supports HTML)"
        name="hero_description_html"
        value={form.hero_description_html}
        onChange={handleInputChange}
        minHeightClass="min-h-[260px]"
        placeholder="Describe the homepage welcome section..."
      />

      <div className="space-y-5">
        <SectionHeader
          icon={BadgeCheck}
          title="Feature Badges"
          description="Manage the 4 fixed homepage badges shown beneath the welcome copy."
        />
        <div className="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
          <Input
            label="Badge 1"
            name="hero_badge_1_text"
            value={form.hero_badge_1_text}
            onChange={handleInputChange}
          />
          <Input
            label="Badge 2"
            name="hero_badge_2_text"
            value={form.hero_badge_2_text}
            onChange={handleInputChange}
          />
          <Input
            label="Badge 3"
            name="hero_badge_3_text"
            value={form.hero_badge_3_text}
            onChange={handleInputChange}
          />
          <Input
            label="Badge 4"
            name="hero_badge_4_text"
            value={form.hero_badge_4_text}
            onChange={handleInputChange}
          />
        </div>
      </div>

      <div className="grid gap-6 md:grid-cols-2">
        <UploadTile
          label="Section Image"
          note="(1920 x 686 px)"
          previewUrl={previews.hero_section_image}
          emptyLabel="Homepage Preview"
          onChange={handleFileChange('hero_section_image')}
          disabled={isSaving || isValidatingImage}
        />

        <div className="space-y-6">
          <Input
            label="Button Text"
            name="hero_cta_text"
            value={form.hero_cta_text}
            onChange={handleInputChange}
            placeholder="Read More About Bluvel Crackers"
          />
          <WebsitePageSelect
            label="Button Link URL"
            name="hero_cta_link"
            value={form.hero_cta_link}
            onChange={handleInputChange}
          />
        </div>
      </div>
    </Card>
  );

  const renderFeaturedProducts = () => (
    <Card className="space-y-8">
      <SectionHeader
        icon={Star}
        title="Featured Products Selection"
        description="Pick exactly 7 products to highlight on the homepage."
      />

      <div className="grid gap-6 md:grid-cols-2">
        <Input
          label="Heading Eyebrow"
          name="featured_products_eyebrow"
          value={form.featured_products_eyebrow}
          onChange={handleInputChange}
        />
        <Input
          label="Section Heading"
          name="featured_products_heading"
          value={form.featured_products_heading}
          onChange={handleInputChange}
        />
      </div>

      <div className="space-y-4">
        <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h4 className="text-lg font-semibold text-slate-900 dark:text-white">
              Select Featured Products (Exactly 7 required)
            </h4>
            <p className="text-sm text-slate-500 dark:text-slate-400">
              Click to select. Exactly 7 products must be selected to save.
            </p>
          </div>
          <div className="rounded-full bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-600 dark:bg-sky-500/10 dark:text-sky-300">
            {selectedProductsCount} / 7 Selected
          </div>
        </div>

        <div className="grid max-h-[640px] gap-4 overflow-y-auto rounded-2xl border border-slate-200 p-4 md:grid-cols-2 xl:grid-cols-3 dark:border-white/10">
          {products.map((product) => (
            <ProductSelectionCard
              key={product.id}
              product={product}
              isSelected={selectedProductsSet.has(Number(product.id))}
              onToggle={handleProductToggle}
            />
          ))}
        </div>
      </div>
    </Card>
  );

  const renderWhyChooseUs = () => (
    <Card className="space-y-8">
      <SectionHeader
        icon={Info}
        title="Why Choose Us Layout"
        description="Configure the fixed 4 pillars, percentage stats, and bottom stats for the homepage trust section."
      />

      <div className="grid gap-6 rounded-2xl bg-slate-50/80 p-5 md:grid-cols-3 dark:bg-white/[0.02]">
        <Input
          label="Eyebrow"
          name="why_choose_eyebrow"
          value={form.why_choose_eyebrow}
          onChange={handleInputChange}
        />
        <Input
          label="Title"
          name="why_choose_title"
          value={form.why_choose_title}
          onChange={handleInputChange}
        />
        <Input
          label="Subtitle"
          name="why_choose_subtitle"
          value={form.why_choose_subtitle}
          onChange={handleInputChange}
        />
      </div>

      <div className="space-y-5">
        <SectionHeader icon={Info} title="4 Main Pillars" />
        <div className="grid gap-6 md:grid-cols-2">
          {[1, 2, 3, 4].map((index) => (
            <div
              key={index}
              className="space-y-4 rounded-2xl border border-slate-200 bg-slate-50/60 p-5 dark:border-white/10 dark:bg-white/[0.02]"
            >
              <h4 className="text-lg font-semibold text-slate-900 dark:text-white">Pillar {index}</h4>
              <Input
                label="Title"
                name={`why_choose_pillar_${index}_title`}
                value={form[`why_choose_pillar_${index}_title`]}
                onChange={handleInputChange}
              />
              <textarea
                name={`why_choose_pillar_${index}_text`}
                rows="4"
                value={form[`why_choose_pillar_${index}_text`]}
                onChange={handleInputChange}
                className={textAreaClassName}
              />
            </div>
          ))}
        </div>
      </div>

      <div className="space-y-5">
        <SectionHeader icon={BadgeCheck} title="Stats Dials (%)" />
        <div className="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
          {[1, 2, 3, 4].map((index) => (
            <StatValueField
              key={index}
              labelName={`why_choose_stat_${index}_label`}
              labelValue={form[`why_choose_stat_${index}_label`]}
              valueName={`why_choose_stat_${index}_value`}
              valueValue={form[`why_choose_stat_${index}_value`]}
              onChange={handleInputChange}
            />
          ))}
        </div>
      </div>

      <div className="space-y-5">
        <SectionHeader icon={Star} title="Bottom Stats (Numbers)" />
        <div className="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
          {[1, 2, 3, 4].map((index) => (
            <StatValueField
              key={index}
              labelName={`why_choose_bottom_${index}_label`}
              labelValue={form[`why_choose_bottom_${index}_label`]}
              valueName={`why_choose_bottom_${index}_value`}
              valueValue={form[`why_choose_bottom_${index}_value`]}
              onChange={handleInputChange}
            />
          ))}
        </div>
      </div>
    </Card>
  );

  const renderActiveTab = () => {
    if (activeTab === 'Welcome Section') {
      return renderWelcomeSection();
    }

    if (activeTab === 'Featured Products') {
      return renderFeaturedProducts();
    }

    return renderWhyChooseUs();
  };

  return (
    <div className="space-y-6 fade-in max-w-5xl">
      <PageHeader
        title="Home Page Setup"
        icon={Home}
        subtitle="Manage welcome content, featured products, and the Why Choose Us section for the homepage."
        action={
          <Button onClick={handleSave} icon={Save} disabled={isLoading || isSaving || isValidatingImage}>
            {isSaving ? 'Saving...' : 'Save Settings'}
          </Button>
        }
      />

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading homepage settings...</span>
          </div>
        </div>
      ) : (
        <div className="space-y-6">
          <div className="flex gap-2 overflow-x-auto border-b border-slate-200 pb-px dark:border-white/10 custom-scrollbar">
            {tabs.map((tab) => (
              <button
                key={tab.id}
                type="button"
                onClick={() => setActiveTab(tab.id)}
                className={`whitespace-nowrap border-b-2 px-6 py-3 text-sm font-medium transition-colors ${
                  activeTab === tab.id
                    ? 'border-amber-500 bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400'
                    : 'border-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-800 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white'
                }`}
              >
                {tab.label}
              </button>
            ))}
          </div>

          {renderActiveTab()}
        </div>
      )}
    </div>
  );
};

export default HomePageSetupPage;
