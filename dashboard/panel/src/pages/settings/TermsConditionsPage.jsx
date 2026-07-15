import { useEffect, useState } from 'react';
import { AlertCircle, BookOpen, LoaderCircle, Save } from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Card } from '../../components/ui/Card';
import { Button } from '../../components/ui/Button';
import { RichTextEditor } from '../../components/ui/RichTextEditor';
import { apiRequest } from '../../lib/api';

const STARTER_TERMS_TEMPLATE = `
  <h1>Terms and Conditions</h1>
  <p>
    Welcome to Bluvel Crackers. By accessing and using our website and purchasing products from us,
    you agree to comply with the following Terms and Conditions.
  </p>
  <h2>1. Acceptance of Terms</h2>
  <p>
    By using this website and placing an order, you confirm that you are legally eligible to purchase
    fireworks in your region and agree to follow all applicable laws and safety regulations.
  </p>
  <h2>2. Orders and Payments</h2>
  <p>
    All orders are subject to availability and confirmation. Prices, offers, and product details may
    change without prior notice.
  </p>
  <h2>3. Safety and Compliance</h2>
  <p>
    Fireworks must be handled responsibly and only according to the instructions provided with the
    product. Customers are responsible for safe storage and usage after delivery.
  </p>
`;

const normalizeHtml = (value = '') =>
  value
    .replace(/<p><br><\/p>/gi, '')
    .replace(/&nbsp;/gi, ' ')
    .replace(/>\s+</g, '><')
    .replace(/\s+/g, ' ')
    .trim();

const TermsConditionsPage = () => {
  const { addToast } = useToast();
  const [content, setContent] = useState('');
  const [savedContent, setSavedContent] = useState('');
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);
  const [isUsingStarterTemplate, setIsUsingStarterTemplate] = useState(false);

  const isDirty = normalizeHtml(content) !== normalizeHtml(savedContent);
  const isSaveDisabled = isLoading || isSaving || !isDirty;

  useEffect(() => {
    let isActive = true;

    const loadTerms = async () => {
      try {
        setIsLoading(true);
        const response = await apiRequest('/settings/terms');
        const persistedContent = response.data?.terms_conditions_html ?? '';
        const shouldUseStarterTemplate = !normalizeHtml(persistedContent);

        if (!isActive) {
          return;
        }

        setSavedContent(persistedContent);
        setContent(shouldUseStarterTemplate ? STARTER_TERMS_TEMPLATE : persistedContent);
        setIsUsingStarterTemplate(shouldUseStarterTemplate);
      } catch (error) {
        if (isActive) {
          addToast(error.message || 'Unable to load terms and conditions.', 'error');
        }
      } finally {
        if (isActive) {
          setIsLoading(false);
        }
      }
    };

    loadTerms();

    return () => {
      isActive = false;
    };
  }, [addToast]);

  const handleSave = async () => {
    try {
      setIsSaving(true);

      await apiRequest('/settings/terms', {
        method: 'PUT',
        body: {
          terms_conditions_html: content ?? '',
        },
      });

      setSavedContent(content ?? '');
      setIsUsingStarterTemplate(false);
      addToast('Terms and conditions saved successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to save terms and conditions.', 'error');
    } finally {
      setIsSaving(false);
    }
  };

  return (
    <div className="space-y-6 fade-in max-w-6xl">
      <PageHeader
        title="Terms & Conditions"
        icon={BookOpen}
        subtitle="Manage the legal content used by your admin-managed website policies."
      />

      {isLoading ? (
        <div className="flex min-h-72 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading terms and conditions...</span>
          </div>
        </div>
      ) : (
        <Card title="Manage Terms and Conditions Content" className="shadow-sm">
          <div className="space-y-5">
            {isUsingStarterTemplate ? (
              <div className="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-200">
                <AlertCircle className="mt-0.5 h-4 w-4 flex-shrink-0" />
                <p>
                  No saved terms content was found, so a starter template has been loaded. Review it
                  and save when you are ready to persist it.
                </p>
              </div>
            ) : null}

            <RichTextEditor
              label="Content"
              value={content}
              onChange={(event) => setContent(event.target.value)}
              disabled={isSaving}
              placeholder="Write terms and conditions here..."
              minHeightClass="min-h-[540px]"
            />

            <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <p className="text-sm text-slate-500 dark:text-slate-400">
                {isDirty ? 'You have unsaved changes.' : 'All changes are saved.'}
              </p>

              <Button
                variant="secondary"
                onClick={handleSave}
                icon={Save}
                disabled={isSaveDisabled}
                className="min-w-40 border-sky-600 bg-sky-600 text-white shadow-none hover:bg-sky-700 hover:text-white disabled:cursor-not-allowed disabled:opacity-60 disabled:hover:bg-sky-600"
              >
                {isSaving ? 'Saving...' : 'Save Settings'}
              </Button>
            </div>
          </div>
        </Card>
      )}
    </div>
  );
};

export default TermsConditionsPage;
