import { useEffect, useState } from 'react';
import { LoaderCircle, Receipt } from 'lucide-react';
import { useParams } from 'react-router-dom';
import { Button } from '../../components/ui/Button';
import { apiRequest } from '../../lib/api';
import { buildInvoiceHtml } from '../../utils/invoiceTemplate';

const BillingInvoicePreviewPage = () => {
  const { invoiceId } = useParams();
  const [isLoading, setIsLoading] = useState(Boolean(invoiceId));
  const [errorMessage, setErrorMessage] = useState('');

  useEffect(() => {
    if (!invoiceId) {
      return undefined;
    }

    let active = true;
    let printFrame = null;
    let closeTimer = null;

    const closePrintTab = () => {
      if (!active) {
        return;
      }

      if (printFrame?.isConnected) {
        printFrame.remove();
      }

      closeTimer = window.setTimeout(() => {
        window.close();

        if (!window.closed) {
          window.location.replace('/orders/billing');
        }
      }, 150);
    };

    const printInvoiceInHiddenFrame = (invoiceHtml) => {
      printFrame = document.createElement('iframe');
      printFrame.title = 'Invoice print document';
      printFrame.setAttribute('aria-hidden', 'true');
      printFrame.tabIndex = -1;
      printFrame.style.cssText = [
        'position:fixed',
        'left:-10000px',
        'top:0',
        'width:210mm',
        'height:297mm',
        'border:0',
        'opacity:0',
        'pointer-events:none',
      ].join(';');

      printFrame.addEventListener('load', async () => {
        if (!active) {
          return;
        }

        try {
          const frameWindow = printFrame.contentWindow;
          const frameDocument = printFrame.contentDocument;

          if (!frameWindow || !frameDocument) {
            throw new Error('Invoice print document could not be prepared.');
          }

          if (frameDocument.fonts?.ready) {
            await frameDocument.fonts.ready;
          }

          const imageLoads = Array.from(frameDocument.images).map(
            (image) =>
              image.complete
                ? Promise.resolve()
                : new Promise((resolve) => {
                    image.addEventListener('load', resolve, { once: true });
                    image.addEventListener('error', resolve, { once: true });
                  })
          );
          await Promise.all(imageLoads);

          if (!active) {
            return;
          }

          frameWindow.addEventListener('afterprint', closePrintTab, { once: true });
          frameWindow.focus();
          frameWindow.print();
        } catch (error) {
          if (active) {
            setErrorMessage(error.message || 'Unable to open the browser print dialog.');
            setIsLoading(false);
          }
        }
      });

      document.body.appendChild(printFrame);
      printFrame.srcdoc = invoiceHtml;
    };

    const loadInvoice = async () => {
      try {
        setIsLoading(true);
        setErrorMessage('');
        const response = await apiRequest(`/orders/${invoiceId}`);

        if (active) {
          const invoiceHtml = buildInvoiceHtml({ invoice: response.data });
          printInvoiceInHiddenFrame(invoiceHtml);
        }
      } catch (error) {
        if (active) {
          setErrorMessage(error.message || 'Unable to load invoice preview.');
          setIsLoading(false);
        }
      }
    };

    loadInvoice();

    return () => {
      active = false;
      if (closeTimer) {
        window.clearTimeout(closeTimer);
      }
      if (printFrame?.isConnected) {
        printFrame.remove();
      }
    };
  }, [invoiceId]);

  const closePreviewTab = () => {
    window.close();

    if (!window.closed) {
      window.location.replace('/orders/billing');
    }
  };

  return (
    <div className="flex min-h-[70vh] items-center justify-center p-4">
      <div className="w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm dark:border-white/10 dark:bg-[#13131a]">
        {!invoiceId || isLoading ? (
          <div className="flex flex-col items-center gap-4 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-8 w-8 animate-spin text-amber-500" />
            <p className="font-medium">
              {invoiceId ? 'Loading invoice and opening browser print dialog...' : 'Creating invoice and preparing print preview...'}
            </p>
          </div>
        ) : errorMessage ? (
          <div className="flex flex-col items-center gap-4">
            <Receipt className="h-10 w-10 text-rose-500" />
            <div>
              <p className="font-semibold text-slate-900 dark:text-white">Print preview could not be loaded</p>
              <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">{errorMessage}</p>
            </div>
            <div className="flex gap-3">
              <Button variant="secondary" onClick={closePreviewTab}>Close Tab</Button>
              <Button onClick={() => window.location.reload()}>Retry</Button>
            </div>
          </div>
        ) : null}
      </div>
    </div>
  );
};

export default BillingInvoicePreviewPage;
