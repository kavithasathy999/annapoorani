const express = require('express');
const pool = require('../config/db');
const auth = require('../middleware/auth');
const upload = require('../middleware/upload');

const router = express.Router();
const validateProductImageDimensions = upload.validateImageDimensions({
  image: { width: 670, height: 800, label: 'Product Image' },
});

const toStockLabel = (value) => Number(value ?? 1) > 0 ? 'In Stock' : 'Out of Stock';

const parseSortOrder = (value) => {
  const sortOrder = Number(value ?? 0);
  return Number.isInteger(sortOrder) && sortOrder >= 0 && sortOrder <= 4294967295
    ? sortOrder
    : null;
};

const normalizeProduct = (row) => ({
  ...row,
  name: row.product_name,
  image: row.product_image,
  price: Number(row.product_mrp_price || 0),
  sale_price: Number(row.product_regular_price || 0),
  content_unit: row.product_content || row.product_quantity || '1 Box',
  stock_status: toStockLabel(row.product_stock),
  description: row.pro_details || row.product_desc || '',
  sort_order: Number(row.sort_order ?? row.id ?? 0),
  is_active: Number(row.is_active ?? 1),
  category_name: row.category_name,
  show_mrp_in_pdf: Number(row.show_mrp_in_pdf ?? 1),
  show_discount_in_pdf: Number(row.show_discount_in_pdf ?? 1),
  is_product_gst_active: Number(row.is_product_gst_active ?? 1),
  product_gst: row.product_gst !== null ? Number(row.product_gst) : null,
});

// GET /api/products
router.get('/', async (req, res) => {
  try {
    const { category, stock, search, page = 1, limit = 20 } = req.query;
    let query = `
      SELECT p.*, c.category_name
      FROM products p
      LEFT JOIN categories c ON p.category_id = c.id
      WHERE 1=1
    `;
    const params = [];

    if (category) {
      query += ' AND p.category_id = ?';
      params.push(category);
    }
    if (stock) {
      query += ' AND p.product_stock = ?';
      params.push(stock === 'Out of Stock' ? 0 : 1);
    }
    if (search) {
      query += ' AND p.product_name LIKE ?';
      params.push(`%${search}%`);
    }

    const countQuery = query.replace('SELECT p.*, c.category_name', 'SELECT COUNT(*) as total');
    const [countRows] = await pool.query(countQuery, params);
    const total = countRows[0].total;

    const normalizedPage = Number(page);
    const normalizedLimit = Number(limit);
    const offset = (normalizedPage - 1) * normalizedLimit;
    query += ' ORDER BY p.sort_order ASC, p.id ASC LIMIT ? OFFSET ?';
    params.push(normalizedLimit, offset);

    const [rows] = await pool.query(query, params);

    res.json({
      success: true,
      data: rows.map(normalizeProduct),
      pagination: {
        page: normalizedPage,
        limit: normalizedLimit,
        total,
        totalPages: Math.ceil(total / normalizedLimit),
      },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// GET /api/products/:id
router.get('/:id', async (req, res) => {
  try {
    const [rows] = await pool.query(
      `SELECT p.*, c.category_name
       FROM products p
       LEFT JOIN categories c ON p.category_id = c.id
       WHERE p.id = ?`,
      [req.params.id]
    );
    if (rows.length === 0) return res.status(404).json({ success: false, message: 'Product not found' });
    res.json({ success: true, data: normalizeProduct(rows[0]) });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// POST /api/products
router.post('/', auth, upload.handleErrors('image'), validateProductImageDimensions, async (req, res) => {
  try {
    const categoryId = Number(req.body.category_id);
    const name = req.body.name?.trim();
    const image = req.file ? `/uploads/${req.file.filename}` : req.body.image?.trim() || null;
    const mrpPrice = Number(req.body.price) || 0;
    const regularPrice = Number(req.body.sale_price) || 0;
    const contentUnit = req.body.content_unit?.trim() || '1 Box';
    const stockValue = req.body.stock_status === 'Out of Stock' ? 0 : 1;
    const description = req.body.description?.trim() || null;
    const sortOrder = parseSortOrder(req.body.sort_order);
    const showMrpInPdf = req.body.show_mrp_in_pdf !== undefined ? Number(req.body.show_mrp_in_pdf) : 1;
    const showDiscountInPdf = req.body.show_discount_in_pdf !== undefined ? Number(req.body.show_discount_in_pdf) : 1;
    const productGst = req.body.product_gst !== undefined && req.body.product_gst !== '' ? Number(req.body.product_gst) : null;

    if (!categoryId) {
      return res.status(400).json({ success: false, message: 'Category is required.' });
    }
    if (!name) {
      return res.status(400).json({ success: false, message: 'Product name is required.' });
    }
    if (sortOrder === null) {
      return res.status(400).json({ success: false, message: 'Sort order must be a non-negative whole number.' });
    }

    const [result] = await pool.query(
      `INSERT INTO products
       (category_id, product_name, product_mrp_price, product_regular_price, product_image,
        sort_order, product_content, product_quantity, product_stock, product_desc, pro_details,
        show_mrp_in_pdf, show_discount_in_pdf, product_gst, created_at, updated_at)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())`,
      [categoryId, name, mrpPrice, regularPrice, image, sortOrder, contentUnit, contentUnit, stockValue, description, description, showMrpInPdf, showDiscountInPdf, productGst]
    );

    res.status(201).json({ success: true, message: 'Product created', id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// PUT /api/products/:id
router.put('/:id', auth, upload.handleErrors('image'), validateProductImageDimensions, async (req, res) => {
  try {
    const categoryId = Number(req.body.category_id);
    const name = req.body.name?.trim();
    const image = req.file ? `/uploads/${req.file.filename}` : req.body.image?.trim() || null;
    const mrpPrice = Number(req.body.price) || 0;
    const regularPrice = Number(req.body.sale_price) || 0;
    const contentUnit = req.body.content_unit?.trim() || '1 Box';
    const stockValue = req.body.stock_status === 'Out of Stock' ? 0 : 1;
    const description = req.body.description?.trim() || null;
    const sortOrder = parseSortOrder(req.body.sort_order);
    const showMrpInPdf = req.body.show_mrp_in_pdf !== undefined ? Number(req.body.show_mrp_in_pdf) : 1;
    const showDiscountInPdf = req.body.show_discount_in_pdf !== undefined ? Number(req.body.show_discount_in_pdf) : 1;
    const productGst = req.body.product_gst !== undefined && req.body.product_gst !== '' ? Number(req.body.product_gst) : null;

    if (!categoryId) {
      return res.status(400).json({ success: false, message: 'Category is required.' });
    }
    if (!name) {
      return res.status(400).json({ success: false, message: 'Product name is required.' });
    }
    if (sortOrder === null) {
      return res.status(400).json({ success: false, message: 'Sort order must be a non-negative whole number.' });
    }

    const params = [
      categoryId,
      name,
      mrpPrice,
      regularPrice,
      sortOrder,
      contentUnit,
      contentUnit,
      stockValue,
      description,
      description,
      showMrpInPdf,
      showDiscountInPdf,
      productGst,
    ];
    let query = `
      UPDATE products
      SET category_id = ?, product_name = ?, product_mrp_price = ?, product_regular_price = ?,
          sort_order = ?, product_content = ?, product_quantity = ?, product_stock = ?, product_desc = ?,
          pro_details = ?, show_mrp_in_pdf = ?, show_discount_in_pdf = ?, product_gst = ?, updated_at = NOW()
    `;

    if (image) {
      query += ', product_image = ?';
      params.push(image);
    }

    query += ' WHERE id = ?';
    params.push(req.params.id);

    const [result] = await pool.query(query, params);
    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Product not found.' });
    }

    res.json({ success: true, message: 'Product updated' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// PATCH /api/products/:id/toggles
router.patch('/:id/toggles', auth, async (req, res) => {
  try {
    const { show_mrp_in_pdf, show_discount_in_pdf, is_product_gst_active } = req.body;
    
    let query = 'UPDATE products SET updated_at = NOW()';
    const params = [];
    
    if (show_mrp_in_pdf !== undefined) {
      query += ', show_mrp_in_pdf = ?';
      params.push(Number(show_mrp_in_pdf));
    }
    
    if (show_discount_in_pdf !== undefined) {
      query += ', show_discount_in_pdf = ?';
      params.push(Number(show_discount_in_pdf));
    }
    
    if (is_product_gst_active !== undefined) {
      query += ', is_product_gst_active = ?';
      params.push(Number(is_product_gst_active));
    }
    
    query += ' WHERE id = ?';
    params.push(req.params.id);

    const [result] = await pool.query(query, params);
    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Product not found.' });
    }

    res.json({ success: true, message: 'Product toggles updated' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// DELETE /api/products/:id
router.delete('/:id', auth, async (req, res) => {
  try {
    await pool.query('DELETE FROM products WHERE id = ?', [req.params.id]);
    res.json({ success: true, message: 'Product deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// DELETE /api/products
router.delete('/', auth, async (req, res) => {
  try {
    await pool.query('DELETE FROM products');
    res.json({ success: true, message: 'All products deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

module.exports = router;
