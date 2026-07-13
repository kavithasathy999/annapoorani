const express = require('express');
const fs = require('fs');
const path = require('path');
const pool = require('../config/db');
const auth = require('../middleware/auth');
const upload = require('../middleware/upload');

const router = express.Router();

const normalizeCategory = (row) => ({
  ...row,
  data_id: row.data_id || `CAT-${String(row.id).padStart(3, '0')}`,
  name: row.category_name,
  image: row.category_image,
  sort_order: Number(row.sort_order ?? row.id ?? 0),
  is_active: Number(row.status ?? 1),
});

// GET /api/categories
router.get('/', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM categories ORDER BY sort_order ASC, id ASC');
    res.json({ success: true, data: rows.map(normalizeCategory) });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// GET /api/categories/:id
router.get('/:id', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM categories WHERE id = ?', [req.params.id]);
    if (rows.length === 0) return res.status(404).json({ success: false, message: 'Category not found' });
    res.json({ success: true, data: normalizeCategory(rows[0]) });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// POST /api/categories
router.post('/', auth, upload.handleErrors('image'), async (req, res) => {
  try {
    const name = req.body.name?.trim();
    const isActive = Number(req.body.is_active ?? 1);
    const sortOrder = Math.max(0, Math.trunc(Number(req.body.sort_order) || 0));

    if (!name) {
      if (req.file) {
        try { fs.unlinkSync(req.file.path); } catch (err) {}
      }
      return res.status(400).json({ success: false, message: 'Category name is required.' });
    }

    if (req.file && req.file.size > 3 * 1024 * 1024) {
      try { fs.unlinkSync(req.file.path); } catch (err) {}
      return res.status(400).json({ success: false, message: 'Image size must be less than or equal to 3MB.' });
    }

    const image = req.file ? `/uploads/${req.file.filename}` : req.body.image?.trim() || null;

    const [result] = await pool.query(
      'INSERT INTO categories (category_name, category_image, sort_order, status, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())',
      [name, image, sortOrder, isActive]
    );

    res.status(201).json({
      success: true,
      message: 'Category created',
      id: result.insertId,
      data: normalizeCategory({
        id: result.insertId,
        category_name: name,
        category_image: image,
        sort_order: sortOrder,
        status: isActive,
      }),
    });
  } catch (error) {
    if (req.file) {
      try { fs.unlinkSync(req.file.path); } catch (err) {}
    }
    res.status(500).json({ success: false, message: error.message });
  }
});

// PUT /api/categories/:id
router.put('/:id', auth, upload.handleErrors('image'), async (req, res) => {
  try {
    const name = req.body.name?.trim();
    const isActive = Number(req.body.is_active ?? 1);
    const sortOrder = Math.max(0, Math.trunc(Number(req.body.sort_order) || 0));

    if (!name) {
      if (req.file) {
        try { fs.unlinkSync(req.file.path); } catch (err) {}
      }
      return res.status(400).json({ success: false, message: 'Category name is required.' });
    }

    if (req.file && req.file.size > 3 * 1024 * 1024) {
      try { fs.unlinkSync(req.file.path); } catch (err) {}
      return res.status(400).json({ success: false, message: 'Image size must be less than or equal to 3MB.' });
    }

    const [rows] = await pool.query('SELECT * FROM categories WHERE id = ?', [req.params.id]);
    if (rows.length === 0) {
      if (req.file) {
        try { fs.unlinkSync(req.file.path); } catch (err) {}
      }
      return res.status(404).json({ success: false, message: 'Category not found.' });
    }

    let image = rows[0].category_image;
    if (req.file) {
      if (image && image.startsWith('/uploads/')) {
        const oldPath = path.join(__dirname, '..', image);
        if (fs.existsSync(oldPath)) {
          try { fs.unlinkSync(oldPath); } catch (err) {}
        }
      }
      image = `/uploads/${req.file.filename}`;
    } else if (req.body.image === null || req.body.image === 'null' || req.body.image === '') {
      if (image && image.startsWith('/uploads/')) {
        const oldPath = path.join(__dirname, '..', image);
        if (fs.existsSync(oldPath)) {
          try { fs.unlinkSync(oldPath); } catch (err) {}
        }
      }
      image = null;
    }

    const [result] = await pool.query(
      'UPDATE categories SET category_name = ?, category_image = ?, sort_order = ?, status = ?, updated_at = NOW() WHERE id = ?',
      [name, image, sortOrder, isActive, req.params.id]
    );

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Category not found.' });
    }

    res.json({ success: true, message: 'Category updated' });
  } catch (error) {
    if (req.file) {
      try { fs.unlinkSync(req.file.path); } catch (err) {}
    }
    res.status(500).json({ success: false, message: error.message });
  }
});

// DELETE /api/categories/:id
router.delete('/:id', auth, async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM categories WHERE id = ?', [req.params.id]);
    if (rows.length > 0) {
      const image = rows[0].category_image;
      if (image && image.startsWith('/uploads/')) {
        const oldPath = path.join(__dirname, '..', image);
        if (fs.existsSync(oldPath)) {
          try { fs.unlinkSync(oldPath); } catch (err) {}
        }
      }
    }
    await pool.query('DELETE FROM categories WHERE id = ?', [req.params.id]);
    res.json({ success: true, message: 'Category deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

module.exports = router;
