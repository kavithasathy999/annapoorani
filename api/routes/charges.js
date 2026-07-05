const express = require('express');
const router = express.Router();
const pool = require('../config/db');
const auth = require('../middleware/auth');

// Get all states (for dropdown)
router.get('/states', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT state as state_code, state as state_name FROM state_list ORDER BY state ASC');
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Get cities for a state
router.get('/cities/:state_code', async (req, res) => {
  try {
    const [rows] = await pool.query(
      'SELECT c.id, c.city_name FROM city_list c JOIN state_list s ON c.state_code = s.id WHERE s.state = ? ORDER BY c.city_name ASC',
      [req.params.state_code]
    );
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Get all additional charges
router.get('/', auth, async (req, res) => {
  try {
    const query = `
      SELECT ac.id, ac.state_code, ac.city_id, ac.packing_price, ac.shipping_price, 
             c.city_name
      FROM additional_charges ac
      LEFT JOIN city_list c ON ac.city_id = c.id
      ORDER BY ac.state_code ASC, c.city_name ASC
    `;
    const [rows] = await pool.query(query);
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Create an additional charge
router.post('/', auth, async (req, res) => {
  try {
    const { state_code, city_id, packing_price, shipping_price } = req.body;
    
    // Check if charge already exists for this city
    const [existing] = await pool.query('SELECT id FROM additional_charges WHERE city_id = ?', [city_id]);
    if (existing.length > 0) {
      return res.status(400).json({ success: false, message: 'Additional charges for this city already exist. Please edit the existing entry.' });
    }

    const [result] = await pool.query(
      'INSERT INTO additional_charges (state_code, city_id, packing_price, shipping_price, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())',
      [state_code, city_id, packing_price || 0, shipping_price || 0]
    );
    res.status(201).json({ success: true, id: result.insertId, message: 'Additional charge created.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Update an additional charge
router.put('/:id', auth, async (req, res) => {
  try {
    const { state_code, city_id, packing_price, shipping_price } = req.body;
    
    await pool.query(
      'UPDATE additional_charges SET state_code = ?, city_id = ?, packing_price = ?, shipping_price = ?, updated_at = NOW() WHERE id = ?',
      [state_code, city_id, packing_price || 0, shipping_price || 0, req.params.id]
    );
    res.json({ success: true, message: 'Additional charge updated.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Delete an additional charge
router.delete('/:id', auth, async (req, res) => {
  try {
    const [result] = await pool.query('DELETE FROM additional_charges WHERE id = ?', [req.params.id]);
    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Charge not found.' });
    }
    res.json({ success: true, message: 'Additional charge deleted.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

module.exports = router;
