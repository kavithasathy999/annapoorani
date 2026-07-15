import { useCallback, useEffect, useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Plus, Package, Edit, Trash, LoaderCircle, UploadCloud, Percent, Download } from 'lucide-react';
import { useToast } from '../../context/ToastContext';
import { useConfirm } from '../../context/ConfirmContext';
import { PageHeader } from '../../components/ui/PageHeader';
import { DataTable } from '../../components/ui/DataTable';
import { Button } from '../../components/ui/Button';
import { Badge } from '../../components/ui/Badge';
import { Modal } from '../../components/ui/Modal';
import { Input, Select } from '../../components/ui/FormFields';
import { apiRequest, getAssetUrl } from '../../lib/api';

const downloadCsvFile = (rows, fileName) => {
  const escapeCsvValue = (value) => `"${String(value ?? '').replace(/"/g, '""')}"`;
  const csvContent = rows.map((row) => row.map(escapeCsvValue).join(',')).join('\n');
  const blob = new Blob([`\uFEFF${csvContent}`], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.download = fileName;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  URL.revokeObjectURL(url);
};

const parseBulkUploadFile = async (file, categories) => {
  const text = await file.text();
  const extension = file.name.split('.').pop()?.toLowerCase();
  const categoryMap = new Map((categories || []).map((category) => [category.name.toLowerCase(), category.id]));

  const normalizeItem = (item, index) => {
    const categoryId = item.category_id || categoryMap.get(String(item.category_name || '').toLowerCase());
    if (!categoryId) {
      throw new Error(`Bulk upload row ${index + 1}: category not found.`);
    }

    if (!String(item.name || '').trim()) {
      throw new Error(`Bulk upload row ${index + 1}: product name is required.`);
    }

    return {
      category_id: String(categoryId),
      name: String(item.name || '').trim(),
      image: String(item.image || '').trim(),
      price: String(Number(item.price || 0)),
      sale_price: String(Number(item.sale_price || 0)),
      content_unit: String(item.content_unit || '1 Box').trim(),
      stock_status: String(item.stock_status || 'In Stock').trim(),
      description: String(item.description || '').trim(),
      sort_order: String(Number(item.sort_order || 0)),
      is_active: String(Number(item.is_active ?? 1)),
    };
  };

  if (extension === 'json') {
    const items = JSON.parse(text);
    if (!Array.isArray(items)) {
      throw new Error('Bulk upload JSON must be an array of products.');
    }
    return items.map(normalizeItem);
  }

  const lines = text.split(/\r?\n/).map((line) => line.trim()).filter(Boolean);
  if (lines.length < 2) {
    throw new Error('Bulk upload CSV must include a header row and at least one data row.');
  }

  const headers = lines[0].split(',').map((header) => header.trim());
  return lines.slice(1).map((line, index) => {
    const values = line.split(',').map((value) => value.trim());
    const item = headers.reduce((accumulator, header, headerIndex) => {
      accumulator[header] = values[headerIndex] ?? '';
      return accumulator;
    }, {});

    return normalizeItem(item, index);
  });
};

const ProductsPage = () => {
  const navigate = useNavigate();
  const { addToast } = useToast();
  const { confirmDelete } = useConfirm();
  const [products, setProducts] = useState([]);
  const [categories, setCategories] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [storeConfig, setStoreConfig] = useState({});
  const [discountValue, setDiscountValue] = useState('');
  const [bulkFile, setBulkFile] = useState(null);
  const [isDiscountModalOpen, setIsDiscountModalOpen] = useState(false);
  const [isTargetModalOpen, setIsTargetModalOpen] = useState(false);
  const [isBulkUploadModalOpen, setIsBulkUploadModalOpen] = useState(false);
  const [isGstModalOpen, setIsGstModalOpen] = useState(false);
  const [isSavingDiscount, setIsSavingDiscount] = useState(false);
  const [isSavingTarget, setIsSavingTarget] = useState(false);
  const [isSavingGst, setIsSavingGst] = useState(false);
  const [isBulkUploading, setIsBulkUploading] = useState(false);
  const [targetValue, setTargetValue] = useState('');
  const [gstValue, setGstValue] = useState('0');

  const loadProductsPage = useCallback(async () => {
    try {
      setIsLoading(true);
      const [productsResponse, categoriesResponse, storeResponse] = await Promise.all([
        apiRequest('/products?limit=500'),
        apiRequest('/categories'),
        apiRequest('/settings/store'),
      ]);

      setProducts(productsResponse.data || []);
      setCategories(categoriesResponse.data || []);
      setStoreConfig(storeResponse.data || {});

      const currentDiscount = String(storeResponse.data?.global_discount ?? 0);
      const currentTarget = String(storeResponse.data?.min_order_value ?? 0);
      const currentGst = String(storeResponse.data?.global_gst ?? 0);
      setDiscountValue(currentDiscount);
      setTargetValue(currentTarget);
      setGstValue(currentGst);
    } catch (error) {
      addToast(error.message || 'Unable to load products.', 'error');
    } finally {
      setIsLoading(false);
    }
  }, [addToast]);

  useEffect(() => {
    loadProductsPage();
  }, [loadProductsPage]);

  const handleDelete = async (product) => {
    const confirmed = await confirmDelete();
    if (!confirmed) {
      return;
    }

    try {
      await apiRequest(`/products/${product.id}`, { method: 'DELETE' });
      addToast('Product deleted successfully.');
      await loadProductsPage();
    } catch (error) {
      addToast(error.message || 'Unable to delete product.', 'error');
    }
  };

  const handleTogglePdfSetting = async (productId, field, newValue) => {
    try {
      setProducts((current) =>
        current.map((product) =>
          product.id === productId ? { ...product, [field]: newValue } : product
        )
      );

      await apiRequest(`/products/${productId}/toggles`, {
        method: 'PATCH',
        body: {
          [field]: newValue,
        },
      });
      addToast('PDF setting updated successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to update setting.', 'error');
      await loadProductsPage();
    }
  };

  const handleDeleteAll = async () => {
    const confirmed = await confirmDelete();
    if (!confirmed) {
      return;
    }

    try {
      await apiRequest('/products', { method: 'DELETE' });
      addToast('All products deleted successfully.');
      await loadProductsPage();
    } catch (error) {
      addToast(error.message || 'Unable to delete all products.', 'error');
    }
  };

  const handleSaveDiscount = async () => {
    const normalizedDiscount = Number(discountValue);
    if (!Number.isFinite(normalizedDiscount) || normalizedDiscount < 0 || normalizedDiscount > 100) {
      addToast('Discount must be between 0 and 100.', 'error');
      return;
    }

    try {
      setIsSavingDiscount(true);

      const response = await apiRequest('/settings/store', {
        method: 'PUT',
        body: {
          is_store_open: Number(storeConfig.is_store_open ?? 1),
          min_order_value: Number(storeConfig.min_order_value ?? 0),
          global_discount: normalizedDiscount,
          global_gst: Number(storeConfig.global_gst ?? 0),
          apply_discount: true,
        },
      });

      setStoreConfig((current) => ({ ...current, global_discount: normalizedDiscount }));
      setIsDiscountModalOpen(false);
      addToast(`Discount applied to ${response.updated_products ?? products.length} products successfully.`);
      await loadProductsPage();
    } catch (error) {
      addToast(error.message || 'Unable to save discount.', 'error');
    } finally {
      setIsSavingDiscount(false);
    }
  };

  const handleSaveTarget = async () => {
    try {
      setIsSavingTarget(true);

      await apiRequest('/settings/store', {
        method: 'PUT',
        body: {
          is_store_open: Number(storeConfig.is_store_open ?? 1),
          min_order_value: Number(targetValue || 0),
          global_discount: Number(storeConfig.global_discount ?? 0),
          global_gst: Number(storeConfig.global_gst ?? 0),
        },
      });

      setStoreConfig((current) => ({ ...current, min_order_value: Number(targetValue || 0) }));
      setIsTargetModalOpen(false);
      addToast('Minimum Target updated successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to save Minimum Target.', 'error');
    } finally {
      setIsSavingTarget(false);
    }
  };

  const handleSaveGst = async () => {
    try {
      setIsSavingGst(true);

      await apiRequest('/settings/store', {
        method: 'PUT',
        body: {
          is_store_open: Number(storeConfig.is_store_open ?? 1),
          min_order_value: Number(storeConfig.min_order_value ?? 0),
          global_discount: Number(storeConfig.global_discount ?? 0),
          global_gst: Number(gstValue || 0),
        },
      });

      setStoreConfig((current) => ({ ...current, global_gst: Number(gstValue || 0) }));
      setIsGstModalOpen(false);
      addToast('Overall GST updated successfully.');
    } catch (error) {
      addToast(error.message || 'Unable to save Overall GST.', 'error');
    } finally {
      setIsSavingGst(false);
    }
  };

  const handleBulkUpload = async () => {
    if (!bulkFile) {
      addToast('Choose a CSV or JSON file first.', 'error');
      return;
    }

    try {
      setIsBulkUploading(true);
      const items = await parseBulkUploadFile(bulkFile, categories);

      for (const item of items) {
        await apiRequest('/products', {
          method: 'POST',
          body: item,
        });
      }

      setBulkFile(null);
      setIsBulkUploadModalOpen(false);
      addToast(`${items.length} products uploaded successfully.`);
      await loadProductsPage();
    } catch (error) {
      addToast(error.message || 'Unable to bulk upload products.', 'error');
    } finally {
      setIsBulkUploading(false);
    }
  };

  const handleDownloadBulkData = () => {
    const headers = [
      'category_name',
      'name',
      'image',
      'price',
      'sale_price',
      'content_unit',
      'stock_status',
      'description',
      'sort_order',
      'is_active',
    ];

    const rows = products.length
      ? products.map((product) => [
          product.category_name || '',
          product.name || '',
          product.image || '',
          product.price || 0,
          product.sale_price || 0,
          product.content_unit || '1 Box',
          product.stock_status || 'In Stock',
          product.description || '',
          product.sort_order || 0,
          product.is_active ?? 1,
        ])
      : [['', '', '', 0, 0, '1 Box', 'In Stock', '', 0, 1]];

    downloadCsvFile([headers, ...rows], 'products_bulk_upload_data.csv');
    addToast(products.length ? 'Product data downloaded successfully.' : 'Sample bulk upload file downloaded successfully.');
  };

  const tableRows = useMemo(
    () =>
      products.map((product, index) => ({
        ...product,
        serial: index + 1,
        imageUrl: getAssetUrl(product.image),
        categoryLabel: product.category_name || 'Unassigned',
        salePriceLabel: Number(product.sale_price || 0),
        priceLabel: Number(product.price || 0),
        stockLabel: product.stock_status || 'In Stock',
      })),
    [products]
  );

  const columns = [
    { key: 'serial', label: 'S.No' },
    {
      key: 'categoryLabel',
      label: 'Category Name',
      render: (value) => <span className="font-medium text-slate-600 dark:text-slate-300">{value}</span>,
    },
    {
      key: 'name',
      label: 'Product Name',
      render: (value) => <span className="font-semibold text-slate-800 dark:text-white">{value}</span>,
    },
    {
      key: 'sort_order',
      label: 'Sort Order',
      className: 'text-center',
      render: (value) => <span className="font-semibold text-slate-600 dark:text-slate-300">{Number(value ?? 0)}</span>,
    },
    {
      key: 'imageUrl',
      label: 'Image',
      render: (value, row) =>
        value ? (
          <img
            src={value}
            className="h-12 w-12 rounded-xl border border-slate-200 object-cover shadow-sm dark:border-white/10"
            alt={row.name}
          />
        ) : (
          <div className="flex h-12 w-12 items-center justify-center rounded-xl border border-dashed border-slate-300 text-xs text-slate-400 dark:border-white/10 dark:text-slate-500">
            N/A
          </div>
        ),
    },
    {
      key: 'priceLabel',
      label: 'Price',
      render: (value) => <span className="text-slate-500 dark:text-slate-400">{value}</span>,
    },
    {
      key: 'salePriceLabel',
      label: 'Sale Price',
      render: (value) => <span className="font-bold text-emerald-600 dark:text-emerald-400">{value}</span>,
    },
    {
      key: 'is_product_gst_active',
      label: 'Gst',
      render: (value, row) => (
        <button
          onClick={() => handleTogglePdfSetting(row.id, 'is_product_gst_active', value ? 0 : 1)}
          className={`flex h-5 w-9 items-center rounded-full p-0.5 transition-colors ${
            value ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-700'
          }`}
          aria-label="Toggle GST"
        >
          <div className={`h-4 w-4 rounded-full bg-white transition-transform ${value ? 'translate-x-4' : 'translate-x-0'}`} />
        </button>
      ),
    },
    {
      key: 'content_unit',
      label: 'Content',
      render: (value) => <span className="text-slate-600 dark:text-slate-300">{value || '-'}</span>,
    },
    {
      key: 'stockLabel',
      label: 'Stock',
      render: (value) => <Badge status={value} />,
    },
    {
      key: 'show_mrp_in_pdf',
      label: 'MRP (PDF)',
      render: (value, row) => (
        <button
          onClick={() => handleTogglePdfSetting(row.id, 'show_mrp_in_pdf', value ? 0 : 1)}
          className={`flex h-5 w-9 items-center rounded-full p-0.5 transition-colors ${
            value ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-700'
          }`}
          aria-label="Toggle MRP in PDF"
        >
          <div className={`h-4 w-4 rounded-full bg-white transition-transform ${value ? 'translate-x-4' : 'translate-x-0'}`} />
        </button>
      ),
    },
    {
      key: 'show_discount_in_pdf',
      label: 'Discount (PDF)',
      render: (value, row) => (
        <button
          onClick={() => handleTogglePdfSetting(row.id, 'show_discount_in_pdf', value ? 0 : 1)}
          className={`flex h-5 w-9 items-center rounded-full p-0.5 transition-colors ${
            value ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-700'
          }`}
          aria-label="Toggle Discount in PDF"
        >
          <div className={`h-4 w-4 rounded-full bg-white transition-transform ${value ? 'translate-x-4' : 'translate-x-0'}`} />
        </button>
      ),
    },
    {
      key: 'actions',
      label: 'Actions',
      render: (_, row) => (
        <div className="flex gap-2">
          <button
            onClick={() => navigate(`/website/products/${row.id}/edit`)}
            className="rounded bg-slate-100 p-1.5 text-slate-600 transition-colors hover:bg-slate-200 dark:bg-white/5 dark:text-slate-300 dark:hover:bg-white/10"
            aria-label={`Edit ${row.name}`}
          >
            <Edit className="h-4 w-4" />
          </button>
          <button
            onClick={() => handleDelete(row)}
            className="rounded bg-rose-50 p-1.5 text-rose-600 transition-colors hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20"
            aria-label={`Delete ${row.name}`}
          >
            <Trash className="h-4 w-4" />
          </button>
        </div>
      ),
    },
  ];

  return (
    <div className="space-y-6 fade-in max-w-[1600px]">
      <PageHeader
        title="Products"
        icon={Package}
        action={
          <div className="flex items-center gap-4 flex-wrap justify-end">
             <Button variant="danger" icon={Trash} onClick={handleDeleteAll}>
                Delete All
             </Button>
             <Button variant="secondary" icon={Percent} onClick={() => setIsTargetModalOpen(true)}>
                Minimum Target
             </Button>
             <Button variant="secondary" icon={Percent} onClick={() => setIsGstModalOpen(true)}>
                Overall GST
             </Button>
             <Button
               variant="secondary"
               icon={Percent}
               onClick={() => {
                 setDiscountValue(String(storeConfig.global_discount ?? 0));
                 setIsDiscountModalOpen(true);
               }}
             >
                Add Discount
             </Button>
             <Button variant="secondary" icon={UploadCloud} onClick={() => setIsBulkUploadModalOpen(true)}>
                Bulk Upload
             </Button>
             <Button icon={Plus} onClick={() => navigate('/website/products/new')}>
                Add Product
             </Button>
          </div>
        }
      />

      <div className="flex flex-wrap items-center gap-x-8 gap-y-3 p-4 bg-rose-50/50 dark:bg-rose-500/5 rounded-xl border border-rose-100 dark:border-rose-500/10">
         <span className="text-lg font-bold text-rose-600 dark:text-rose-400 flex items-center gap-2">
            Overall Discount: {storeConfig.global_discount ?? 0}%
         </span>
         <span className="text-lg font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-2">
            Overall GST: {storeConfig.global_gst ?? 0}%
         </span>
      </div>

      {isLoading ? (
        <div className="flex min-h-64 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#0a0a0f]">
          <div className="flex items-center gap-3 text-slate-500 dark:text-slate-400">
            <LoaderCircle className="h-5 w-5 animate-spin" />
            <span>Loading products...</span>
          </div>
        </div>
      ) : (
        <DataTable
          columns={columns}
          data={tableRows}
          searchPlaceholder="Search products..."
          exportable
          exportVariant="buttons"
          showColumnVisibility
          exportFileName="products"
        />
      )}

      <Modal isOpen={isDiscountModalOpen} onClose={() => setIsDiscountModalOpen(false)} title="Add Discount">
        <div className="space-y-4">
          <Input
            label="Price Discount (%)"
            name="discount"
            type="number"
            min="0"
            max="100"
            value={discountValue}
            onChange={(event) => setDiscountValue(event.target.value)}
            placeholder="Enter Price Discount"
          />
          <Button className="w-full" onClick={handleSaveDiscount} disabled={isSavingDiscount}>
            {isSavingDiscount ? 'Saving...' : 'Save changes'}
          </Button>
        </div>
      </Modal>

      <Modal isOpen={isTargetModalOpen} onClose={() => setIsTargetModalOpen(false)} title="Set Minimum Target">
        <div className="space-y-4">
          <Input
            label="Minimum Order Value"
            name="target"
            type="number"
            min="0"
            value={targetValue}
            onChange={(event) => setTargetValue(event.target.value)}
            placeholder="Enter Minimum Order Value"
          />
          <Button className="w-full" onClick={handleSaveTarget} disabled={isSavingTarget}>
            {isSavingTarget ? 'Saving...' : 'Save changes'}
          </Button>
        </div>
      </Modal>

      <Modal isOpen={isGstModalOpen} onClose={() => setIsGstModalOpen(false)} title="Set Overall GST">
        <div className="space-y-4">
          <Select
            label="Select gst percentage"
            name="gst"
            value={gstValue}
            onChange={(event) => setGstValue(event.target.value)}
            options={[
              { label: '0%', value: '0' },
              { label: '5%', value: '5' },
              { label: '12%', value: '12' },
              { label: '18%', value: '18' },
              { label: '28%', value: '28' },
            ]}
          />
          <Button className="w-full" onClick={handleSaveGst} disabled={isSavingGst}>
            {isSavingGst ? 'Saving...' : 'Save changes'}
          </Button>
        </div>
      </Modal>

      <Modal isOpen={isBulkUploadModalOpen} onClose={() => setIsBulkUploadModalOpen(false)} title="Bulk Upload Products">
        <div className="space-y-4">
          <Button variant="secondary" className="w-full" icon={Download} onClick={handleDownloadBulkData}>
            Download Data
          </Button>
          <label className="block">
            <span className="mb-1.5 block text-sm font-medium text-slate-600 dark:text-slate-400">Upload CSV or JSON</span>
            <input
              type="file"
              accept=".csv,.json"
              onChange={(event) => setBulkFile(event.target.files?.[0] || null)}
              className="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm dark:border-white/10 dark:bg-[#0a0a0f] dark:text-white"
            />
          </label>
          <div className="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-500 dark:border-white/10 dark:bg-white/[0.02] dark:text-slate-400">
            Use headers like `category_name,name,image,price,sale_price,content_unit,stock_status,description,sort_order,is_active`
          </div>
          <Button className="w-full" onClick={handleBulkUpload} disabled={isBulkUploading}>
            {isBulkUploading ? 'Uploading...' : 'Upload Products'}
          </Button>
        </div>
      </Modal>
    </div>
  );
};

export default ProductsPage;
