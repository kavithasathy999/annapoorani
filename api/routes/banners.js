const express = require('express');
const fs = require('fs');
const { imageSize } = require('image-size');
const pool = require('../config/db');
const auth = require('../middleware/auth');
const upload = require('../middleware/upload');

const router = express.Router();
const BANNER_WIDTH = 1080;
const BANNER_HEIGHT = 600;

const removeUploadedFile = (file) => {
  if (!file?.path) {
    return;
  }

  try {
    fs.unlinkSync(file.path);
  } catch (error) {
    if (error.code !== 'ENOENT') {
      console.error('Unable to remove rejected banner upload:', error);
    }
  }
};

const validateBannerDimensions = (req, res, next) => {
  if (!req.file) {
    return next();
  }

  try {
    const dimensions = imageSize(fs.readFileSync(req.file.path));
    if (dimensions.width !== BANNER_WIDTH || dimensions.height !== BANNER_HEIGHT) {
      removeUploadedFile(req.file);
      return res.status(400).json({
        success: false,
        message: `Banner image must be exactly ${BANNER_WIDTH} x ${BANNER_HEIGHT} px.`,
      });
    }

    return next();
  } catch (error) {
    removeUploadedFile(req.file);
    return res.status(400).json({
      success: false,
      message: 'Unable to validate the banner image dimensions.',
    });
  }
};

const normalizeActiveStatus = (value, fallback = 1) => {
  if (value === undefined || value === null || value === '') {
    return fallback;
  }

  const status = Number(value);
  return status === 0 || status === 1 ? status : null;
};

const normalizeBanner = (row) => ({
  ...row,
  name: row.name || `Banner ${row.id}`,
  image: row.banner_image,
  sort_order: Number(row.banner_position || row.id || 0),
  is_active: Number(row.is_active ?? 1),
});

// GET /api/banners
router.get('/', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM banner_images ORDER BY banner_position ASC, id ASC');
    res.json({ success: true, data: rows.map(normalizeBanner) });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// POST /api/banners
router.post('/', auth, upload.handleErrors('image'), validateBannerDimensions, async (req, res) => {
  try {
    if (!req.file) {
      return res.status(400).json({ success: false, message: 'Banner image is required.' });
    }

    const image = `/uploads/${req.file.filename}`;
    const name = String(req.body.name || '').trim();
    const position = Number(req.body.sort_order) || 0;
    const isActive = normalizeActiveStatus(req.body.is_active);

    if (!name) {
      removeUploadedFile(req.file);
      return res.status(400).json({ success: false, message: 'Banner name is required.' });
    }

    if (isActive === null) {
      removeUploadedFile(req.file);
      return res.status(400).json({ success: false, message: 'Banner status must be Active or Inactive.' });
    }

    const [result] = await pool.query(
      `INSERT INTO banner_images
       (name, banner_image, banner_position, is_active, created_at, updated_at)
       VALUES (?, ?, ?, ?, NOW(), NOW())`,
      [name, image, position, isActive]
    );

    res.status(201).json({ success: true, message: 'Banner created', id: result.insertId });
  } catch (error) {
    removeUploadedFile(req.file);
    res.status(500).json({ success: false, message: error.message });
  }
});

// PUT /api/banners/:id
router.put('/:id', auth, upload.handleErrors('image'), validateBannerDimensions, async (req, res) => {
  try {
    const name = String(req.body.name || '').trim();
    const position = Number(req.body.sort_order) || 0;
    const isActive = normalizeActiveStatus(req.body.is_active);

    if (!name) {
      removeUploadedFile(req.file);
      return res.status(400).json({ success: false, message: 'Banner name is required.' });
    }

    if (isActive === null) {
      removeUploadedFile(req.file);
      return res.status(400).json({ success: false, message: 'Banner status must be Active or Inactive.' });
    }

    const params = [name, position, isActive];
    let query = 'UPDATE banner_images SET name = ?, banner_position = ?, is_active = ?, updated_at = NOW()';

    if (req.file) {
      query += ', banner_image = ?';
      params.push(`/uploads/${req.file.filename}`);
    }

    query += ' WHERE id = ?';
    params.push(req.params.id);

    const [result] = await pool.query(query, params);
    if (result.affectedRows === 0) {
      removeUploadedFile(req.file);
      return res.status(404).json({ success: false, message: 'Banner not found.' });
    }

    res.json({ success: true, message: 'Banner updated' });
  } catch (error) {
    removeUploadedFile(req.file);
    res.status(500).json({ success: false, message: error.message });
  }
});

// DELETE /api/banners/:id
router.delete('/:id', auth, async (req, res) => {
  try {
    await pool.query('DELETE FROM banner_images WHERE id = ?', [req.params.id]);
    res.json({ success: true, message: 'Banner deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

module.exports = router;
