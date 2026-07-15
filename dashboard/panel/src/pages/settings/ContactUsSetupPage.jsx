import { useEffect, useMemo, useState } from 'react';
import {
  ContactRound,
  Heading,
  LoaderCircle,
  Mail,
  MapPin,
  Phone,
  Save,
} from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Card } from '../../components/ui/Card';
import { Button } from '../../components/ui/Button';
import { Input } from '../../components/ui/FormFields';
import { RichTextEditor } from '../../components/ui/RichTextEditor';
import { apiRequest } from '../../lib/api';

const tabs = [
  { id: 'Contact Details', label: 'Contact Details', icon: ContactRound },
  { id: 'Page Headers', label: 'Page Headers', icon: Heading },
  { id: 'Map & Visuals', label: 'Map & Visuals', icon: MapPin },
];

const initialForm = {
  primary_phone: '',
  email: '',
  address: '',
  contact_intro_eyebrow: '',
  contact_intro_heading: '',
  contact_intro_description_html: '',
  contact_map_iframe_html: '',
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

const IconInput = ({ label, value, onChange, icon: Icon, placeholder, name, type = 'text' }) => (
  <div className="space-y-1.5">
    <label className="text-sm font-medium text-slate-600 dark:text-slate-400">{label}</label>
    <div className="flex overflow-hidden rounded-lg border border-slate-300 bg-white shadow-sm transition-all focus-within:border-amber-500 focus-within:ring-2 focus-within:ring-amber-500/20 dark:border-white/10 dark:bg-[#0a0a0f]">
      <div className="flex w-12 items-center justify-center border-r border-slate-200 bg-slate-50 text-slate-500 dark:border-white/10 dark:bg-white/[0.03] dark:text-slate-400">
        <Icon className="h-4 w-4" />
      </div>
      <input
        type={type}
        name={name}
        value={value}
        onChange={onChange}
        placeholder={placeholder}
        className="w-full border-0 bg-transparent px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none dark:text-white dark:placeholder-slate-600"
      />
    </div>
  </div>
);

const extractIframeSrc = (value = '') => {
  const iframeMatch = value.match(/<iframe\b[^>]*\bsrc=(['"])(.*?)\1/i);
  return iframeMatch?.[2]?.trim() || '';
};

const ContactUsSetupPage = () => {
  const { addToast } = useToast();
  const [activeTab, setActiveTab] = useState(tabs[0].id);
  const [form, setForm] = useState(initialForm);
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);

  const mapPreviewSrc = useMemo(
    () => extractIframeSrc(form.contact_map_iframe_html),
    [form.contact_map_iframe_html]
  );

  const loadSettings = async () => {
    try {
      setIsLoading(true);
      const response = await apiRequest('/settings/contact-page');
      setForm({
        ...initialForm,
        ...(response.data || {}),
      });
    } catch (error) {
      addToast(error.message || 'Unable to load contact page settings.', 'error');
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

  const handleSave = async () => {
    try {
      setIsSaving(true);
      const response = await apiRequest('/settings/contact-page', {
        method: 'PUT',
        body: form,
      });

      setForm({
        ...initialForm,
        ...(response.data || form),
      });
      addToast('Contact page settings saved successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to save contact page settings.', 'error');
    } finally {
      setIsSaving(false);
    }
  };

  const renderContactDetailsTab = () => (
    <Card className="space-y-8">
      <SectionHeader
        icon={ContactRound}
        title="Contact Information"
        description="Update the primary contact details shared across the storefront and Contact page."
      />

      <div className="grid gap-6 md:grid-cols-2">
        <IconInput
          label="Phone Number"
          icon={Phone}
          name="primary_phone"
          value={form.primary_phone}
          onChange={handleInputChange}
          placeholder="Phone: 9898565896"
        />
        <IconInput
          label="Email Address"
          icon={Mail}
          name="email"
          type="email"
          value={form.email}
          onChange={handleInputChange}
          placeholder="hello@bluvel.com"
        />
      </div>

      <div className="space-y-1.5">
        <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Physical Address</label>
        <textarea
          name="address"
          rows="4"
          value={form.address}
          onChange={handleInputChange}
          placeholder="Anaikuttam, Sivakasi."
          className={textAreaClassName}
        />
      </div>
    </Card>
  );

  const renderPageHeadersTab = () => (
    <Card className="space-y-8">
      <SectionHeader
        icon={Heading}
        title="Intro Content"
        description="Control the Contact page eyebrow, heading, and introductory copy."
      />

      <div className="grid gap-6">
        <Input
          label="Small Title (Eyebrow)"
          name="contact_intro_eyebrow"
          value={form.contact_intro_eyebrow}
          onChange={handleInputChange}
          placeholder="Contact Us"
        />
        <Input
          label="Main Heading"
          name="contact_intro_heading"
          value={form.contact_intro_heading}
          onChange={handleInputChange}
          placeholder="Have Any Questions?"
        />
      </div>

      <RichTextEditor
        label="Description Text"
        name="contact_intro_description_html"
        value={form.contact_intro_description_html}
        onChange={handleInputChange}
        placeholder="Have an inquiry or some feedback for us? Use the form below to contact our team."
        minHeightClass="min-h-[260px]"
      />
    </Card>
  );

  const renderMapTab = () => (
    <Card className="space-y-8">
      <SectionHeader
        icon={MapPin}
        title="Location Map"
        description="Paste the Google Maps embed iframe code to power the Contact page map preview."
      />

      <div className="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
        <div className="space-y-3">
          <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Google Maps iframe code</label>
          <textarea
            name="contact_map_iframe_html"
            rows="8"
            value={form.contact_map_iframe_html}
            onChange={handleInputChange}
            placeholder={'<iframe src="https://www.google.com/maps/embed?..." loading="lazy"></iframe>'}
            className={`${textAreaClassName} min-h-[220px] font-mono text-sm`}
          />
          <p className="text-sm text-slate-500 dark:text-slate-400">
            Tip: Go to Google Maps &gt; Share &gt; Embed a map to get this code.
          </p>
        </div>

        <div className="space-y-3">
          <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Live Preview</label>
          <div className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#13131a]">
            {mapPreviewSrc ? (
              <iframe
                title="Contact page map preview"
                src={mapPreviewSrc}
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                className="h-[320px] w-full border-0"
                allowFullScreen
              />
            ) : (
              <div className="flex h-[320px] items-center justify-center p-6 text-center text-sm text-slate-500 dark:text-slate-400">
                Paste a valid Google Maps iframe embed code to preview the map here.
              </div>
            )}
          </div>
        </div>
      </div>
    </Card>
  );

  const renderActiveTab = () => {
    if (activeTab === 'Contact Details') {
      return renderContactDetailsTab();
    }

    if (activeTab === 'Page Headers') {
      return renderPageHeadersTab();
    }

    return renderMapTab();
  };

  return (
    <div className="space-y-6 fade-in max-w-5xl">
      <PageHeader
        title="Contact Us Setup"
        icon={Phone}
        subtitle="Manage contact details, intro content, and map embed settings for the Contact page."
        action={
          <Button onClick={handleSave} icon={Save} disabled={isLoading || isSaving}>
            {isSaving ? 'Saving...' : 'Save Settings'}
          </Button>
        }
      />

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading contact page settings...</span>
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

export default ContactUsSetupPage;
