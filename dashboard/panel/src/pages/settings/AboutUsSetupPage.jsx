import { useEffect, useState } from 'react';
import {
  BadgeCheck,
  BookOpen,
  Image as ImageIcon,
  Info,
  LoaderCircle,
  Save,
  Target,
  Type,
  UploadCloud,
} from 'lucide-react';
import { PageHeader } from '../../components/ui/PageHeader';
import { Card } from '../../components/ui/Card';
import { Button } from '../../components/ui/Button';
import { Input } from '../../components/ui/FormFields';
import { RichTextEditor } from '../../components/ui/RichTextEditor';
import { WebsitePageSelect } from '../../components/ui/WebsitePageSelect';
import { useToast } from '../../context/ToastContext';
import { apiRequest, getAssetUrl } from '../../lib/api';
import { validateImageDimensions } from '../../utils/imageValidation';

const IMAGE_DIMENSIONS = {
  story_banner_image: { width: 1224, height: 864, label: 'Top Banner Image' },
  story_main_image: { width: 1224, height: 816, label: 'Main Content Image' },
};

const ABOUT_TABS = [
  { id: 'story', label: 'Story & Visuals', icon: BookOpen },
  { id: 'badges', label: 'Badges & Stats', icon: BadgeCheck },
  { id: 'purpose', label: 'Purpose & CTA', icon: Target },
];

const initialForm = {
  story_banner_image: '',
  story_main_image: '',
  story_eyebrow: '',
  story_heading_html: '',
  story_description_html: '',
  badge_1_text: '',
  badge_2_text: '',
  badge_3_text: '',
  products_count: '',
  customers_count: '',
  success_percentage: '',
  purpose_eyebrow: '',
  purpose_heading: '',
  pillar_1_title: '',
  pillar_1_text: '',
  pillar_2_title: '',
  pillar_2_text: '',
  pillar_3_title: '',
  pillar_3_text: '',
  pillar_4_title: '',
  pillar_4_text: '',
  cta_banner_text: '',
  cta_button_text: '',
  cta_button_link: '',
};

const textAreaClassName =
  'min-h-[140px] w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm transition-all focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-white/10 dark:bg-[#0a0a0f] dark:text-white';

const SectionHeader = ({ icon: Icon, title }) => (
  <div className="space-y-1 border-b border-slate-100 pb-5 dark:border-white/10">
    <div className="flex items-center gap-3 text-slate-800 dark:text-white">
      <Icon className="h-5 w-5 text-amber-500" />
      <h2 className="text-lg font-semibold">{title}</h2>
    </div>
  </div>
);

const TextAreaField = ({ label, name, value, onChange, rows = 5, placeholder = '' }) => (
  <div className="space-y-2">
    <label className="text-sm font-medium text-slate-600 dark:text-slate-400">{label}</label>
    <textarea
      name={name}
      rows={rows}
      value={value}
      onChange={onChange}
      placeholder={placeholder}
      className={textAreaClassName}
    />
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

const AboutUsSetupPage = () => {
  const { addToast } = useToast();
  const [activeTab, setActiveTab] = useState(ABOUT_TABS[0].id);
  const [form, setForm] = useState(initialForm);
  const [selectedFiles, setSelectedFiles] = useState({
    story_banner_image: null,
    story_main_image: null,
  });
  const [previews, setPreviews] = useState({
    story_banner_image: '',
    story_main_image: '',
  });
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);
  const [isValidatingImage, setIsValidatingImage] = useState(false);

  useEffect(() => {
    return () => {
      Object.values(previews).forEach((url) => {
        if (url.startsWith('blob:')) {
          URL.revokeObjectURL(url);
        }
      });
    };
  }, [previews]);

  const loadSettings = async () => {
    try {
      setIsLoading(true);
      const response = await apiRequest('/settings/about');
      const data = response.data || {};

      setForm({
        ...initialForm,
        ...data,
      });
      setSelectedFiles({
        story_banner_image: null,
        story_main_image: null,
      });
      setPreviews((current) => {
        Object.values(current).forEach((url) => {
          if (url.startsWith('blob:')) {
            URL.revokeObjectURL(url);
          }
        });

        return {
          story_banner_image: data.story_banner_image ? getAssetUrl(data.story_banner_image) : '',
          story_main_image: data.story_main_image ? getAssetUrl(data.story_main_image) : '',
        };
      });
    } catch (error) {
      addToast(error.message || 'Unable to load about settings.', 'error');
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    loadSettings();
  }, []);

  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setForm((current) => ({
      ...current,
      [name]: value,
    }));
  };

  const handleRichTextChange = (fieldName) => (event) => {
    setForm((current) => ({
      ...current,
      [fieldName]: event.target.value,
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
      const { previewUrl } = await validateImageDimensions(file, IMAGE_DIMENSIONS[fieldName]);

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

  const handleSave = async () => {
    try {
      setIsSaving(true);
      const payload = new FormData();

      Object.entries(form).forEach(([key, value]) => {
        if (!['story_banner_image', 'story_main_image'].includes(key)) {
          payload.append(key, value ?? '');
        }
      });

      if (selectedFiles.story_banner_image) {
        payload.append('story_banner_image', selectedFiles.story_banner_image);
      }

      if (selectedFiles.story_main_image) {
        payload.append('story_main_image', selectedFiles.story_main_image);
      }

      await apiRequest('/settings/about', {
        method: 'PUT',
        body: payload,
      });

      addToast('About settings saved successfully.');
      await loadSettings();
    } catch (error) {
      addToast(error.message || 'Unable to save about settings.', 'error');
    } finally {
      setIsSaving(false);
    }
  };

  const renderStoryTab = () => (
    <Card className="space-y-8">
      <SectionHeader icon={ImageIcon} title="Visuals" />

      <div className="grid gap-6 md:grid-cols-2">
        <UploadTile
          label="Top Banner Image"
          note="(1224 x 864 px)"
          previewUrl={previews.story_banner_image}
          emptyLabel="Banner Preview"
          onChange={handleFileChange('story_banner_image')}
          disabled={isSaving || isValidatingImage}
        />
        <UploadTile
          label="Main Content Image"
          note="(1224 x 816 px)"
          previewUrl={previews.story_main_image}
          emptyLabel="Main Image Preview"
          onChange={handleFileChange('story_main_image')}
          disabled={isSaving || isValidatingImage}
        />
      </div>

      <div className="space-y-6">
        <SectionHeader icon={Type} title="Hero Content" />

        <div className="grid gap-6 md:grid-cols-2">
          <Input
            label="Eyebrow"
            name="story_eyebrow"
            value={form.story_eyebrow}
            onChange={handleInputChange}
            placeholder="Est. 2020 - Sivakasi"
          />

          <RichTextEditor
            label="Main Heading"
            value={form.story_heading_html}
            onChange={handleRichTextChange('story_heading_html')}
            placeholder="About your brand heading..."
            disabled={isSaving}
            minHeightClass="min-h-[170px]"
          />
        </div>

        <RichTextEditor
          label="Description"
          value={form.story_description_html}
          onChange={handleRichTextChange('story_description_html')}
          placeholder="Tell your story here..."
          disabled={isSaving}
          minHeightClass="min-h-[300px]"
        />
      </div>
    </Card>
  );

  const renderBadgesTab = () => (
    <Card className="space-y-8">
      <div className="space-y-6">
        <SectionHeader icon={BadgeCheck} title="Quality Badges" />
        <div className="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
          <Input
            label="Badge 1 Text"
            name="badge_1_text"
            value={form.badge_1_text}
            onChange={handleInputChange}
            placeholder="Since 2016"
          />
          <Input
            label="Badge 2 Text"
            name="badge_2_text"
            value={form.badge_2_text}
            onChange={handleInputChange}
            placeholder="Sivakasi Based"
          />
          <Input
            label="Badge 3 Text"
            name="badge_3_text"
            value={form.badge_3_text}
            onChange={handleInputChange}
            placeholder="Safety Certified"
          />
        </div>
      </div>

      <div className="space-y-6">
        <SectionHeader icon={Target} title="Success Counters" />
        <div className="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
          <Input
            label="Products Count"
            name="products_count"
            value={form.products_count}
            onChange={handleInputChange}
            placeholder="20"
          />
          <Input
            label="Customers Count"
            name="customers_count"
            value={form.customers_count}
            onChange={handleInputChange}
            placeholder="12586"
          />
          <Input
            label="Success Percentage"
            name="success_percentage"
            value={form.success_percentage}
            onChange={handleInputChange}
            placeholder="79"
          />
        </div>
      </div>
    </Card>
  );

  const renderPurposeTab = () => (
    <Card className="space-y-8">
      <div className="space-y-6">
        <SectionHeader icon={Target} title="Our Purpose & Ethics" />
        <div className="grid gap-6 md:grid-cols-2">
          <Input
            label="Purpose Eyebrow"
            name="purpose_eyebrow"
            value={form.purpose_eyebrow}
            onChange={handleInputChange}
            placeholder="What Drives Us"
          />
          <Input
            label="Purpose Heading"
            name="purpose_heading"
            value={form.purpose_heading}
            onChange={handleInputChange}
            placeholder="Our Purpose & Values"
          />
        </div>

        <div className="grid gap-6 md:grid-cols-2">
          <div className="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5 dark:border-white/10 dark:bg-white/[0.02]">
            <Input
              label="Pillar 1 Title"
              name="pillar_1_title"
              value={form.pillar_1_title}
              onChange={handleInputChange}
              placeholder="Our Purpose"
            />
            <div className="mt-5">
              <TextAreaField
                label="Pillar 1 Text"
                name="pillar_1_text"
                value={form.pillar_1_text}
                onChange={handleInputChange}
              />
            </div>
          </div>

          <div className="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5 dark:border-white/10 dark:bg-white/[0.02]">
            <Input
              label="Pillar 2 Title"
              name="pillar_2_title"
              value={form.pillar_2_title}
              onChange={handleInputChange}
              placeholder="Our Dedication"
            />
            <div className="mt-5">
              <TextAreaField
                label="Pillar 2 Text"
                name="pillar_2_text"
                value={form.pillar_2_text}
                onChange={handleInputChange}
              />
            </div>
          </div>

          <div className="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5 dark:border-white/10 dark:bg-white/[0.02]">
            <Input
              label="Pillar 3 Title"
              name="pillar_3_title"
              value={form.pillar_3_title}
              onChange={handleInputChange}
              placeholder="Our Quality"
            />
            <div className="mt-5">
              <TextAreaField
                label="Pillar 3 Text"
                name="pillar_3_text"
                value={form.pillar_3_text}
                onChange={handleInputChange}
              />
            </div>
          </div>

          <div className="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5 dark:border-white/10 dark:bg-white/[0.02]">
            <Input
              label="Pillar 4 Title"
              name="pillar_4_title"
              value={form.pillar_4_title}
              onChange={handleInputChange}
              placeholder="Our Promise"
            />
            <div className="mt-5">
              <TextAreaField
                label="Pillar 4 Text"
                name="pillar_4_text"
                value={form.pillar_4_text}
                onChange={handleInputChange}
              />
            </div>
          </div>
        </div>
      </div>

      <div className="space-y-6">
        <SectionHeader icon={Type} title="Final CTA (Call to Action)" />
        <Input
          label="Banner Text"
          name="cta_banner_text"
          value={form.cta_banner_text}
          onChange={handleInputChange}
          placeholder="Let's Make a Difference in the Lives of Others"
        />

        <div className="grid gap-6 md:grid-cols-2">
          <Input
            label="Button Text"
            name="cta_button_text"
            value={form.cta_button_text}
            onChange={handleInputChange}
            placeholder="ESTIMATE NOW"
          />
          <WebsitePageSelect
            label="Button Link URL"
            name="cta_button_link"
            value={form.cta_button_link}
            onChange={handleInputChange}
          />
        </div>
      </div>
    </Card>
  );

  const renderActiveTab = () => {
    if (activeTab === 'story') {
      return renderStoryTab();
    }

    if (activeTab === 'badges') {
      return renderBadgesTab();
    }

    return renderPurposeTab();
  };

  return (
    <div className="space-y-6 fade-in max-w-5xl">
      <PageHeader
        title="About Us Settings"
        icon={Info}
        subtitle="Manage About page content, visuals, badges, counters, and CTA content."
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
            <span>Loading about settings...</span>
          </div>
        </div>
      ) : (
        <div className="space-y-6">
          <div className="flex gap-2 overflow-x-auto border-b border-slate-200 pb-px dark:border-white/10 custom-scrollbar">
              {ABOUT_TABS.map((tab) => (
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

export default AboutUsSetupPage;
