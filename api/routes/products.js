const express = require('express');
const pool = require('../config/db');
const auth = require('../middleware/auth');
const upload = require('../middleware/upload');

const router = express.Router();

const toStockLabel = (value) => Number(value ?? 1) > 0 ? 'In Stock' : 'Out of Stock';

const normalizeProduct = (row) => ({
  ...row,
  name: row.product_name,
  image: row.product_image,
  price: Number(row.product_mrp_price || 0),
  sale_price: Number(row.product_regular_price || 0),
  content_unit: row.product_content || row.product_quantity || '1 Box',
  stock_status: toStockLabel(row.product_stock),
  description: row.pro_details || row.product_desc || '',
  sort_order: Number(row.sort_order || row.id || 0),
  is_active: Number(row.is_active ?? 1),
  category_name: row.category_name,
  show_mrp_in_pdf: Number(row.show_mrp_in_pdf ?? 1),
  show_discount_in_pdf: Number(row.show_discount_in_pdf ?? 1),
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
    query += ' ORDER BY p.id DESC LIMIT ? OFFSET ?';
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
router.post('/', auth, upload.handleErrors('image'), async (req, res) => {
  try {
    const categoryId = Number(req.body.category_id);
    const name = req.body.name?.trim();
    const image = req.file ? `/uploads/${req.file.filename}` : req.body.image?.trim() || null;
    const mrpPrice = Number(req.body.price) || 0;
    const regularPrice = Number(req.body.sale_price) || 0;
    const contentUnit = req.body.content_unit?.trim() || '1 Box';
    const stockValue = req.body.stock_status === 'Out of Stock' ? 0 : 1;
    const description = req.body.description?.trim() || null;
    const showMrpInPdf = req.body.show_mrp_in_pdf !== undefined ? Number(req.body.show_mrp_in_pdf) : 1;
    const showDiscountInPdf = req.body.show_discount_in_pdf !== undefined ? Number(req.body.show_discount_in_pdf) : 1;

    if (!categoryId) {
      return res.status(400).json({ success: false, message: 'Category is required.' });
    }
    if (!name) {
      return res.status(400).json({ success: false, message: 'Product name is required.' });
    }

    const [result] = await pool.query(
      `INSERT INTO products
       (category_id, product_name, product_mrp_price, product_regular_price, product_image,
        product_content, product_quantity, product_stock, product_desc, pro_details, show_mrp_in_pdf, show_discount_in_pdf, created_at, updated_at)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())`,
      [categoryId, name, mrpPrice, regularPrice, image, contentUnit, contentUnit, stockValue, description, description, showMrpInPdf, showDiscountInPdf]
    );

    res.status(201).json({ success: true, message: 'Product created', id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// PUT /api/products/:id
router.put('/:id', auth, upload.handleErrors('image'), async (req, res) => {
  try {
    const categoryId = Number(req.body.category_id);
    const name = req.body.name?.trim();
    const image = req.file ? `/uploads/${req.file.filename}` : req.body.image?.trim() || null;
    const mrpPrice = Number(req.body.price) || 0;
    const regularPrice = Number(req.body.sale_price) || 0;
    const contentUnit = req.body.content_unit?.trim() || '1 Box';
    const stockValue = req.body.stock_status === 'Out of Stock' ? 0 : 1;
    const description = req.body.description?.trim() || null;
    const showMrpInPdf = req.body.show_mrp_in_pdf !== undefined ? Number(req.body.show_mrp_in_pdf) : 1;
    const showDiscountInPdf = req.body.show_discount_in_pdf !== undefined ? Number(req.body.show_discount_in_pdf) : 1;

    if (!categoryId) {
      return res.status(400).json({ success: false, message: 'Category is required.' });
    }
    if (!name) {
      return res.status(400).json({ success: false, message: 'Product name is required.' });
    }

    const params = [
      categoryId,
      name,
      mrpPrice,
      regularPrice,
      contentUnit,
      contentUnit,
      stockValue,
      description,
      description,
      showMrpInPdf,
      showDiscountInPdf,
    ];
    let query = `
      UPDATE products
      SET category_id = ?, product_name = ?, product_mrp_price = ?, product_regular_price = ?,
          product_content = ?, product_quantity = ?, product_stock = ?, product_desc = ?,
          pro_details = ?, show_mrp_in_pdf = ?, show_discount_in_pdf = ?, updated_at = NOW()
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
    const { show_mrp_in_pdf, show_discount_in_pdf } = req.body;
    
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
