import { useEffect, useMemo, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { Plus, Trash2, Save, ArrowLeft, LoaderCircle } from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { Card } from '../../components/ui/Card';
import { Button } from '../../components/ui/Button';
import { Input, Select } from '../../components/ui/FormFields';
import { Modal } from '../../components/ui/Modal';
import { apiRequest } from '../../lib/api';

const PAYMENT_STATUS_OPTIONS = ['Pending', 'Paid', 'Failed'];
const FALLBACK_ORDER_STATUSES = ['Pending', 'Dispatch', 'Complete', 'Payment Pending', 'Printed', 'Paid'];

const createEmptyItem = () => ({
  product_id: '',
  quantity: '1',
  price: '',
  is_gst_applied: true,
  item_gst: 0,
  product_gst_rate: 0,
});

const createInitialInvoiceForm = () => ({
  customer_id: '',
  status: 'Pending',
  payment_status: 'Pending',
  packing: '0',
  discount: '0',
  notes: '',
  apply_gst: true,
  items: [createEmptyItem()],
});

const createInitialCustomerForm = () => ({
  name: '',
  phone: '',
  email: '',
  address: '',
  city: '',
  state: '',
  pincode: '',
});

const formatCurrency = (value) =>
  new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR',
    maximumFractionDigits: 2,
  }).format(Number(value || 0));

const BillingInvoiceFormPage = () => {
  const navigate = useNavigate();
  const { invoiceId } = useParams();
  const { addToast } = useToast();

  const [customers, setCustomers] = useState([]);
  const [products, setProducts] = useState([]);
  const [orderStatuses, setOrderStatuses] = useState(FALLBACK_ORDER_STATUSES);
  const [invoiceProductOverrides, setInvoiceProductOverrides] = useState([]);
  const [globalGst, setGlobalGst] = useState(0);
  
  const [isLoading, setIsLoading] = useState(true);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [isCustomerModalOpen, setIsCustomerModalOpen] = useState(false);
  const [isSubmittingCustomer, setIsSubmittingCustomer] = useState(false);
  
  const [invoiceForm, setInvoiceForm] = useState(createInitialInvoiceForm());
  const [customerForm, setCustomerForm] = useState(createInitialCustomerForm());

  const isEditing = Boolean(invoiceId);

  const activeProducts = useMemo(
    () => products.filter((product) => Number(product.is_active ?? 1) === 1),
    [products]
  );

  const customerOptions = useMemo(
    () => [
      { label: 'Select Customer', value: '' },
      ...customers.map((customer) => ({
        label: `${customer.name} (${customer.phone})`,
        value: String(customer.id),
      })),
    ],
    [customers]
  );

  const productOptions = useMemo(
    () => [
      { label: 'Select Product', value: '' },
      ...[...activeProducts, ...invoiceProductOverrides]
        .filter((product, index, productsList) => index === productsList.findIndex((entry) => String(entry.id) === String(product.id)))
        .map((product) => ({
        label: `${product.name} - ${formatCurrency(product.sale_price || product.price)}`,
        value: String(product.id),
      })),
    ],
    [activeProducts, invoiceProductOverrides]
  );

  const orderStatusOptions = useMemo(
    () => orderStatuses.map((status) => ({ label: status, value: status })),
    [orderStatuses]
  );
  
  useEffect(() => {
    let active = true;
    const fetchAll = async () => {
      setIsLoading(true);
      try {
        const [customersResponse, productsResponse, statusResponse, storeResponse] = await Promise.all([
          apiRequest('/customers?limit=500'),
          apiRequest('/products?limit=500'),
          apiRequest('/settings/order-statuses'),
          apiRequest('/settings/store'),
        ]);
        
        if (!active) return;
        
        setCustomers(customersResponse.data || []);
        const loadedProducts = productsResponse.data || [];
        setProducts(loadedProducts);
        setOrderStatuses(
          (statusResponse.data || []).length > 0
            ? statusResponse.data.map((status) => status.name)
            : FALLBACK_ORDER_STATUSES
        );
        const storeGst = Number(storeResponse.data?.global_gst || 0);
        setGlobalGst(storeGst);

        if (isEditing) {
          const response = await apiRequest(`/orders/${invoiceId}`);
          const invoice = response.data;
          
          const missingProducts = (invoice.items || [])
            .filter(
              (item) => !loadedProducts.some((product) => String(product.id) === String(item.product_id))
            )
            .map((item) => ({
              id: item.product_id,
              name: item.product_name || `Product #${item.product_id}`,
              price: item.price,
              sale_price: item.price,
              is_active: 0,
            }));

          setInvoiceProductOverrides(missingProducts);

          const invoiceSubTotal = (invoice.items || []).reduce(
            (sum, item) => sum + (Number(item.quantity ?? 0) * Number(item.price ?? 0)),
            0
          );
          const packingPercent = invoiceSubTotal > 0 ? (Number(invoice.packing || 0) * 100) / invoiceSubTotal : 0;
          const roundedPackingPercent = parseFloat(packingPercent.toFixed(4));
          const discountPercent = invoiceSubTotal > 0 ? (Number(invoice.discount || 0) * 100) / invoiceSubTotal : 0;
          const roundedDiscountPercent = parseFloat(discountPercent.toFixed(4));

          setInvoiceForm({
            customer_id: String(invoice.customer_id || ''),
            status: invoice.status || 'Pending',
            payment_status: invoice.payment_status || 'Pending',
            packing: String(roundedPackingPercent),
            discount: String(roundedDiscountPercent),
            notes: invoice.notes || '',
            apply_gst: Boolean(invoice.is_gst_applied),
            items:
              (invoice.items || []).map((item) => ({
                product_id: String(item.product_id || ''),
                quantity: String(item.quantity ?? 1),
                price: String(item.price ?? 0),
                is_gst_applied: Boolean(item.is_gst_applied),
                item_gst: Number(item.item_gst || 0),
                product_gst_rate: Number(item.product_gst_rate || 0),
              })) || [createEmptyItem()],
          });
        }
      } catch (error) {
        addToast(error.message || 'Unable to load data.', 'error');
        if (isEditing) navigate('/orders/billing');
      } finally {
        setIsLoading(false);
      }
    };
    fetchAll();
    return () => { active = false; };
  }, [isEditing, invoiceId, navigate, addToast]);


  const handleInvoiceFieldChange = (event) => {
    const { name, value } = event.target;
    setInvoiceForm((current) => ({ ...current, [name]: value }));
  };

  const handleInvoiceItemChange = (index, field, value) => {
    setInvoiceForm((current) => {
      const nextItems = current.items.map((item, itemIndex) => {
        if (itemIndex !== index) {
          return item;
        }

        const nextItem = { ...item, [field]: value };

        if (field === 'product_id') {
          const selectedProduct = activeProducts.find((product) => String(product.id) === String(value)) || 
                                  invoiceProductOverrides.find((product) => String(product.id) === String(value));
          if (selectedProduct) {
            nextItem.price = String(selectedProduct.sale_price || selectedProduct.price || 0);
            const prodGst = selectedProduct.product_gst;
            nextItem.product_gst_rate = (prodGst !== null && prodGst !== '' && prodGst !== undefined) ? Number(prodGst) : globalGst;
          }
        }

        if (['product_id', 'quantity', 'price', 'is_gst_applied'].includes(field)) {
          const qty = Number(nextItem.quantity || 0);
          const price = Number(nextItem.price || 0);
          const total = qty * price;
          if (nextItem.is_gst_applied && nextItem.product_gst_rate > 0) {
            nextItem.item_gst = (total * nextItem.product_gst_rate) / 100;
          } else {
            nextItem.item_gst = 0;
          }
        }

        return nextItem;
      });

      return { ...current, items: nextItems };
    });
  };

  const addInvoiceItem = () => {
    setInvoiceForm((current) => ({
      ...current,
      items: [...current.items, createEmptyItem()],
    }));
  };

  const removeInvoiceItem = (index) => {
    setInvoiceForm((current) => ({
      ...current,
      items: current.items.filter((_, itemIndex) => itemIndex !== index),
    }));
  };

  const invoiceTotals = useMemo(() => {
    let subTotal = 0;
    let subTotalForOverallGst = 0;
    const individualGsts = [];
    let totalGst = 0;
    let overallGstAmount = 0;

    invoiceForm.items.forEach((item) => {
      const qty = Number(item.quantity || 0);
      const price = Number(item.price || 0);
      const total = qty * price;
      subTotal += total;

      if (item.is_gst_applied && item.product_gst_rate > 0) {
        const itemGst = (total * item.product_gst_rate) / 100;
        const product = products.find(p => String(p.id) === String(item.product_id));
        const pName = product ? product.name : `Product #${item.product_id}`;
        individualGsts.push({ label: `${pName} GST (${item.product_gst_rate}%)`, amount: itemGst });
        totalGst += itemGst;
      } else {
        subTotalForOverallGst += total;
      }
    });

    if (invoiceForm.apply_gst && globalGst > 0) {
       overallGstAmount = (subTotalForOverallGst * globalGst) / 100;
       totalGst += overallGstAmount;
    }

    const packingPercentage = Number(invoiceForm.packing || 0);
    const packing = (subTotal * packingPercentage) / 100;
    const parsedDiscountPercentage = Number(invoiceForm.discount || 0);
    const discountPercentage = Number.isFinite(parsedDiscountPercentage) ? parsedDiscountPercentage : 0;
    const discount = (subTotal * discountPercentage) / 100;

    return {
      subTotal,
      packing,
      discount,
      discountPercentage,
      totalGst,
      overallGstAmount,
      overallGstRate: globalGst,
      individualGsts,
      grandTotal: subTotal + totalGst + packing - discount,
    };
  }, [invoiceForm, products, globalGst]);

  const handleSubmitInvoice = async () => {
    if (!invoiceForm.customer_id) {
      addToast('Customer is required.', 'error');
      return;
    }

    if (invoiceForm.items.length === 0) {
      addToast('Add at least one product line item.', 'error');
      return;
    }

    const discountPercentage = Number(invoiceForm.discount || 0);
    if (!Number.isFinite(discountPercentage) || discountPercentage < 0 || discountPercentage > 100) {
      addToast('Discount must be between 0 and 100 percent.', 'error');
      return;
    }

    const itemsPayload = invoiceForm.items.map((item) => ({
      product_id: Number(item.product_id),
      quantity: Number(item.quantity),
      price: Number(item.price),
      is_gst_applied: Boolean(item.is_gst_applied),
      item_gst: Number(item.item_gst),
      product_gst_rate: Number(item.product_gst_rate),
    }));

    if (itemsPayload.some((item) => !item.product_id || item.quantity <= 0 || item.price < 0)) {
      addToast('Each line item needs a product, positive quantity, and valid price.', 'error');
      return;
    }

    if (invoiceTotals.grandTotal < 0) {
      addToast('Grand total cannot be negative.', 'error');
      return;
    }

    const panelBaseUrl = window.location.origin;
    const previewWindow = window.open(`${panelBaseUrl}/orders/billing/preview`, '_blank');

    if (!previewWindow) {
      addToast('Allow popups for this site to open the invoice preview in a new tab.', 'error');
      return;
    }

    const payload = {
      customer_id: Number(invoiceForm.customer_id),
      items: itemsPayload,
      order_type: 'BILLING',
      packing: invoiceTotals.packing,
      discount: invoiceTotals.discount,
      payment_status: invoiceForm.payment_status,
      status: invoiceForm.status,
      notes: invoiceForm.notes.trim(),
      apply_gst: invoiceForm.apply_gst,
      total_gst: invoiceTotals.totalGst,
    };

    try {
      setIsSubmitting(true);
      let newInvoiceId = invoiceId;

      if (isEditing) {
        await apiRequest(`/orders/${invoiceId}`, {
          method: 'PUT',
          body: payload,
        });
        addToast('Billing invoice updated successfully.');
      } else {
        const response = await apiRequest('/orders', {
          method: 'POST',
          body: payload,
        });
        newInvoiceId = response.id;
        addToast('Billing invoice created successfully.');
      }
      
      if (newInvoiceId) {
        if (!previewWindow.closed) {
          previewWindow.location.replace(`${panelBaseUrl}/orders/billing/${newInvoiceId}/preview`);
        } else {
          addToast('Invoice saved, but the preview tab was closed.', 'error');
        }
      } else if (!previewWindow.closed) {
        previewWindow.close();
      }

      navigate('/orders/billing');
    } catch (error) {
      if (!previewWindow.closed) {
        previewWindow.close();
      }
      addToast(error.message || 'Unable to save billing invoice.', 'error');
    } finally {
      setIsSubmitting(false);
    }
  };

  const handleCustomerFieldChange = (event) => {
    const { name, value } = event.target;
    setCustomerForm((current) => ({ ...current, [name]: value }));
  };

  const handleCreateCustomer = async () => {
    if (!customerForm.name.trim()) {
      addToast('Customer name is required.', 'error');
      return;
    }

    if (!customerForm.phone.trim()) {
      addToast('Phone number is required.', 'error');
      return;
    }

    const payload = {
      name: customerForm.name.trim(),
      phone: customerForm.phone.trim(),
      email: customerForm.email.trim(),
      address: customerForm.address.trim(),
      city: customerForm.city.trim(),
      state: customerForm.state.trim(),
      pincode: customerForm.pincode.trim(),
    };

    try {
      setIsSubmittingCustomer(true);
      const response = await apiRequest('/customers', {
        method: 'POST',
        body: payload,
      });

      const nextCustomer = {
        id: response.id,
        ...payload,
      };

      setCustomers((current) => [nextCustomer, ...current]);
      setInvoiceForm((current) => ({ ...current, customer_id: String(response.id) }));
      setCustomerForm(createInitialCustomerForm());
      setIsCustomerModalOpen(false);
      addToast('Customer created successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to create customer.', 'error');
    } finally {
      setIsSubmittingCustomer(false);
    }
  };

  if (isLoading) {
    return (
      <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
        <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
          <LoaderCircle className="h-5 w-5 animate-spin" />
          <span>Loading invoice data...</span>
        </div>
      </div>
    );
  }

  return (
    <div className="space-y-6 fade-in max-w-5xl mx-auto">
      <PageHeader
        title={isEditing ? 'Edit Billing Invoice' : 'New Billing Invoice'}
        icon={isEditing ? Save : Plus}
        action={
          <Button variant="secondary" icon={ArrowLeft} onClick={() => navigate('/orders/billing')}>
            Back to Invoices
          </Button>
        }
      />

      <Card>
        <div className="space-y-8">
          <div className="space-y-4">
            <h3 className="text-lg font-bold text-slate-800 dark:text-white">Customer Details</h3>
            <div className="grid gap-4 md:grid-cols-[minmax(0,1fr)_auto]">
              <Select
                label="Customer"
                name="customer_id"
                value={invoiceForm.customer_id}
                onChange={handleInvoiceFieldChange}
                options={customerOptions}
              />
              <div className="flex items-end">
                <Button variant="secondary" onClick={() => setIsCustomerModalOpen(true)}>
                  Quick Add Customer
                </Button>
              </div>
            </div>
          </div>

          <div className="space-y-4">
            <h3 className="text-lg font-bold text-slate-800 dark:text-white">Order Details</h3>
            <div className="grid gap-4 md:grid-cols-4">
              <Select
                label="Order Status"
                name="status"
                value={invoiceForm.status}
                onChange={handleInvoiceFieldChange}
                options={orderStatusOptions}
              />
              <Select
                label="Payment Status"
                name="payment_status"
                value={invoiceForm.payment_status}
                onChange={handleInvoiceFieldChange}
                options={PAYMENT_STATUS_OPTIONS.map((status) => ({ label: status, value: status }))}
              />
              <Input
                label="Packing (%)"
                name="packing"
                type="number"
                min="0"
                step="0.01"
                value={invoiceForm.packing}
                onChange={handleInvoiceFieldChange}
              />
              <Input
                label="Discount (%)"
                name="discount"
                type="number"
                min="0"
                max="100"
                step="0.01"
                value={invoiceForm.discount}
                onChange={handleInvoiceFieldChange}
              />
              <div className="flex flex-col gap-1.5 justify-center">
                <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Overall GST</label>
                <label className="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    className="sr-only peer"
                    checked={invoiceForm.apply_gst}
                    onChange={(e) => setInvoiceForm(curr => ({ ...curr, apply_gst: e.target.checked }))}
                  />
                  <div className="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 dark:peer-focus:ring-amber-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-amber-500"></div>
                  <span className="ml-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                    {invoiceForm.apply_gst ? 'ON' : 'OFF'}
                  </span>
                </label>
              </div>
            </div>
          </div>

          <div className="space-y-4">
            <div className="flex flex-wrap items-center justify-between gap-4">
              <h3 className="text-lg font-bold text-slate-800 dark:text-white">Line Items</h3>
              <Button variant="secondary" onClick={addInvoiceItem} icon={Plus}>
                Add Item
              </Button>
            </div>

            <div className="space-y-4">
              {invoiceForm.items.map((item, index) => (
                <div key={`${index}-${item.product_id}`} className="rounded-xl border border-slate-200 p-4 dark:border-white/10">
                  <div className="grid gap-4 lg:grid-cols-[minmax(0,1.5fr)_120px_140px_140px_auto]">
                    <Select
                      label={`Product ${index + 1}`}
                      value={item.product_id}
                      onChange={(event) => handleInvoiceItemChange(index, 'product_id', event.target.value)}
                      options={productOptions}
                    />
                    <Input
                      label="Quantity"
                      type="number"
                      min="1"
                      step="1"
                      value={item.quantity}
                      onChange={(event) => handleInvoiceItemChange(index, 'quantity', event.target.value)}
                    />
                    <Input
                      label="Rate"
                      type="number"
                      min="0"
                      step="0.01"
                      value={item.price}
                      onChange={(event) => handleInvoiceItemChange(index, 'price', event.target.value)}
                    />
                    <div className="flex flex-col gap-1.5 justify-center">
                      <label className="text-sm font-medium text-slate-600 dark:text-slate-400">GST</label>
                      <label className="relative inline-flex items-center cursor-pointer">
                        <input
                          type="checkbox"
                          className="sr-only peer"
                          checked={item.is_gst_applied}
                          onChange={(e) => handleInvoiceItemChange(index, 'is_gst_applied', e.target.checked)}
                        />
                        <div className="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-amber-300 dark:peer-focus:ring-amber-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-amber-500"></div>
                      </label>
                    </div>
                    <div className="flex flex-col gap-1.5">
                      <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Line Total</label>
                      <div className="rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 dark:border-white/10 dark:bg-white/[0.02] dark:text-white">
                        {formatCurrency(Number(item.quantity || 0) * Number(item.price || 0))}
                      </div>
                    </div>
                    <div className="flex items-end">
                      <Button
                        variant="danger"
                        onClick={() => removeInvoiceItem(index)}
                        disabled={invoiceForm.items.length === 1}
                        icon={Trash2}
                      >
                        Remove
                      </Button>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
            <div className="flex flex-col gap-1.5">
              <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Notes</label>
              <textarea
                name="notes"
                value={invoiceForm.notes}
                onChange={handleInvoiceFieldChange}
                rows={5}
                placeholder="Add invoice notes or billing remarks"
                className="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 shadow-sm transition-all focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-white/10 dark:bg-[#0a0a0f] dark:text-white dark:placeholder-slate-600"
              />
            </div>

            <div className="rounded-xl border border-slate-200 bg-slate-50 p-5 dark:border-white/10 dark:bg-white/[0.02]">
              <h4 className="text-base font-semibold text-slate-800 dark:text-white">Totals</h4>
              <div className="mt-4 space-y-3 text-sm">
                {invoiceTotals.individualGsts.map((gst, idx) => (
                  <div key={idx} className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                    <span>{gst.label}</span>
                    <strong>{formatCurrency(gst.amount)}</strong>
                  </div>
                ))}

                {invoiceForm.apply_gst && invoiceTotals.overallGstAmount > 0 && (
                  <div className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                    <span>Overall GST ({invoiceTotals.overallGstRate}%)</span>
                    <strong>{formatCurrency(invoiceTotals.overallGstAmount)}</strong>
                  </div>
                )}

                <div className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                  <span>Sub Total</span>
                  <strong>{formatCurrency(invoiceTotals.subTotal)}</strong>
                </div>
                <div className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                  <span>Packing</span>
                  <strong>{formatCurrency(invoiceTotals.packing)}</strong>
                </div>
                <div className="flex items-center justify-between text-slate-600 dark:text-slate-300">
                  <span>Discount</span>
                  <strong>{formatCurrency(invoiceTotals.discount)}</strong>
                </div>
                <div className="flex items-center justify-between border-t border-slate-200 pt-3 text-base font-bold text-slate-900 dark:border-white/10 dark:text-white">
                  <span>Grand Total</span>
                  <span>{formatCurrency(invoiceTotals.grandTotal)}</span>
                </div>
              </div>
            </div>
          </div>

          <div className="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-white/10">
            <Button variant="secondary" onClick={() => navigate('/orders/billing')} disabled={isSubmitting}>
              Cancel
            </Button>
            <Button onClick={handleSubmitInvoice} icon={Save} disabled={isSubmitting}>
              {isSubmitting ? 'Saving...' : isEditing ? 'Update Invoice' : 'Create Invoice'}
            </Button>
          </div>
        </div>
      </Card>

      <Modal
        isOpen={isCustomerModalOpen}
        onClose={() => setIsCustomerModalOpen(false)}
        title="Quick Add Customer"
        maxWidthClass="max-w-2xl"
      >
        <div className="space-y-4">
          <div className="grid gap-4 md:grid-cols-2">
            <Input label="Customer Name" name="name" value={customerForm.name} onChange={handleCustomerFieldChange} />
            <Input label="Phone Number" name="phone" value={customerForm.phone} onChange={handleCustomerFieldChange} />
          </div>
          <div className="grid gap-4 md:grid-cols-2">
            <Input label="Email" name="email" value={customerForm.email} onChange={handleCustomerFieldChange} />
            <Input label="Pincode" name="pincode" value={customerForm.pincode} onChange={handleCustomerFieldChange} />
          </div>
          <div className="grid gap-4 md:grid-cols-2">
            <Input label="City" name="city" value={customerForm.city} onChange={handleCustomerFieldChange} />
            <Input label="State" name="state" value={customerForm.state} onChange={handleCustomerFieldChange} />
          </div>
          <div className="flex flex-col gap-1.5">
            <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Address</label>
            <textarea
              name="address"
              value={customerForm.address}
              onChange={handleCustomerFieldChange}
              rows={4}
              className="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 shadow-sm transition-all focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-white/10 dark:bg-[#0a0a0f] dark:text-white dark:placeholder-slate-600"
            />
          </div>
          <div className="flex justify-end gap-3">
            <Button variant="secondary" onClick={() => setIsCustomerModalOpen(false)} disabled={isSubmittingCustomer}>
              Cancel
            </Button>
            <Button onClick={handleCreateCustomer} icon={Save} disabled={isSubmittingCustomer}>
              {isSubmittingCustomer ? 'Saving...' : 'Create Customer'}
            </Button>
          </div>
        </div>
      </Modal>
    </div>
  );
};

export default BillingInvoiceFormPage;
