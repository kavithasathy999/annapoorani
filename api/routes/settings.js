const express = require('express');
const pool = require('../config/db');
const auth = require('../middleware/auth');
const upload = require('../middleware/upload');

const router = express.Router();

const storeConfigUpload = (req, res, next) => {
  const contentType = req.headers['content-type'] || '';
  if (!contentType.includes('multipart/form-data')) {
    return next();
  }

  req.uploadSubDir = 'settings';
  return upload.handleErrors('off_banner_image')(req, res, next);
};

const globalSettingsUpload = (req, res, next) => {
  const contentType = req.headers['content-type'] || '';
  if (!contentType.includes('multipart/form-data')) {
    return next();
  }

  req.uploadSubDir = 'settings';
  return upload.handleFieldsErrors([
    { name: 'main_logo', maxCount: 1 },
    { name: 'favicon', maxCount: 1 },
  ])(req, res, next);
};

const aboutSettingsUpload = (req, res, next) => {
  const contentType = req.headers['content-type'] || '';
  if (!contentType.includes('multipart/form-data')) {
    return next();
  }

  req.uploadSubDir = 'settings';
  return upload.handleFieldsErrors([
    { name: 'story_banner_image', maxCount: 1 },
    { name: 'story_main_image', maxCount: 1 },
  ])(req, res, next);
};

const homepageSettingsUpload = (req, res, next) => {
  const contentType = req.headers['content-type'] || '';
  if (!contentType.includes('multipart/form-data')) {
    return next();
  }

  req.uploadSubDir = 'settings';
  return upload.handleFieldsErrors([{ name: 'hero_section_image', maxCount: 1 }])(req, res, next);
};

const paymentSettingsUpload = (req, res, next) => {
  const contentType = req.headers['content-type'] || '';
  if (!contentType.includes('multipart/form-data')) {
    return next();
  }

  req.uploadSubDir = 'settings';
  return upload.handleFieldsErrors([
    { name: 'gpay_qr_image', maxCount: 1 },
    { name: 'phonepe_qr_image', maxCount: 1 },
  ])(req, res, next);
};

const brandLogoUpload = (req, res, next) => {
  const contentType = req.headers['content-type'] || '';
  if (!contentType.includes('multipart/form-data')) {
    return next();
  }

  req.uploadSubDir = 'brands';
  return upload.handleErrors('logo')(req, res, next);
};

const seoDetailsUpload = (req, res, next) => {
  const contentType = req.headers['content-type'] || '';
  if (!contentType.includes('multipart/form-data')) {
    return next();
  }

  req.uploadSubDir = 'seo';
  return upload.handleErrors('image')(req, res, next);
};

const blogImageUpload = (req, res, next) => {
  const contentType = req.headers['content-type'] || '';
  if (!contentType.includes('multipart/form-data')) {
    return next();
  }

  req.uploadSubDir = 'blogs';
  return upload.handleErrors('image')(req, res, next);
};

const slugifyBlogName = (value = '') =>
  value
    .toLowerCase()
    .trim()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '')
    .replace(/-{2,}/g, '-');

const getUniqueBlogSlug = async (blogName, excludeId = null) => {
  const baseSlug = slugifyBlogName(blogName) || `blog-${Date.now()}`;
  let slugCandidate = baseSlug;
  let suffix = 2;

  while (true) {
    let query = 'SELECT id FROM blogs WHERE slug = ?';
    const params = [slugCandidate];

    if (excludeId != null) {
      query += ' AND id <> ?';
      params.push(excludeId);
    }

    query += ' LIMIT 1';

    const [rows] = await pool.query(query, params);
    if (rows.length === 0) {
      return slugCandidate;
    }

    slugCandidate = `${baseSlug}-${suffix}`;
    suffix += 1;
  }
};

const GLOBAL_SETTINGS_FIELDS = [
  { key: 'company_name', group: 'brand', defaultValue: 'Sparkle Fireworks' },
  { key: 'seo_title', group: 'brand', defaultValue: 'Sparkle Fireworks | Best Crackers Online' },
  { key: 'main_logo', group: 'brand', defaultValue: '' },
  { key: 'favicon', group: 'brand', defaultValue: '' },
  { key: 'primary_phone', group: 'contact', defaultValue: '+91 98765 43210' },
  { key: 'email', group: 'contact', defaultValue: '' },
  { key: 'address', group: 'contact', defaultValue: '' },
  { key: 'whatsapp_number', group: 'contact', defaultValue: '' },
  { key: 'footer_content', group: 'contact', defaultValue: '' },
  { key: 'facebook_url', group: 'social', defaultValue: '' },
  { key: 'instagram_url', group: 'social', defaultValue: '' },
  { key: 'twitter_url', group: 'social', defaultValue: '' },
  { key: 'linkedin_url', group: 'social', defaultValue: '' },
  { key: 'youtube_url', group: 'social', defaultValue: '' },
  { key: 'offer_text_html', group: 'seo', defaultValue: '' },
  { key: 'google_analytics_id', group: 'seo', defaultValue: '' },
  { key: 'show_discount', group: 'display', defaultValue: '1' },
];

const GLOBAL_SETTINGS_KEYS = new Set(GLOBAL_SETTINGS_FIELDS.map((field) => field.key));

const THEME_SETTINGS_FIELDS = [
  { key: 'color_primary', group: 'theme', defaultValue: '#f8fafc' },
  { key: 'color_secondary', group: 'theme', defaultValue: '#ffffff' },
  { key: 'color_tertiary', group: 'theme', defaultValue: '#f59e0b' },
  { key: 'color_quaternary', group: 'theme', defaultValue: '#ec4899' },
];

const TERMS_SETTINGS_FIELD = { key: 'terms_conditions_html', group: 'legal', defaultValue: '' };
const LEGACY_TERMS_SETTINGS_KEY = 'terms_content';
const LEGACY_ABOUT_HEADING_SETTINGS_KEY = 'about_heading';
const LEGACY_ABOUT_DESCRIPTION_SETTINGS_KEY = 'about_description';
const LEGACY_HOMEPAGE_HEADING_SETTINGS_KEY = 'hero_heading';
const CONTACT_PAGE_SHARED_FIELDS = [
  { key: 'primary_phone', group: 'contact', defaultValue: '+91 98765 43210' },
  { key: 'email', group: 'contact', defaultValue: 'support@sparklefireworks.com' },
  { key: 'address', group: 'contact', defaultValue: '123 Sparkle Street, Sivakasi, Tamil Nadu, India' },
];
const CONTACT_PAGE_SETTINGS_FIELDS = [
  { key: 'contact_intro_eyebrow', group: 'contact_page', defaultValue: 'Contact Us' },
  { key: 'contact_intro_heading', group: 'contact_page', defaultValue: 'Have Any Questions?' },
  {
    key: 'contact_intro_description_html',
    group: 'contact_page',
    defaultValue: '<p>Have an inquiry or some feedback for us? Use the form below to contact our team.</p>',
  },
  { key: 'contact_map_iframe_html', group: 'contact_page', defaultValue: '' },
];

const ABOUT_SETTINGS_FIELDS = [
  { key: 'story_banner_image', group: 'about', defaultValue: '' },
  { key: 'story_main_image', group: 'about', defaultValue: '' },
  { key: 'story_eyebrow', group: 'about', defaultValue: 'Est. 2020 - Sivakasi' },
  { key: 'story_heading_html', group: 'about', defaultValue: '' },
  { key: 'story_description_html', group: 'about', defaultValue: '' },
  { key: 'badge_1_text', group: 'about', defaultValue: 'Since 2016' },
  { key: 'badge_2_text', group: 'about', defaultValue: 'Sivakasi Based' },
  { key: 'badge_3_text', group: 'about', defaultValue: 'Safety Certified' },
  { key: 'products_count', group: 'about', defaultValue: '20' },
  { key: 'customers_count', group: 'about', defaultValue: '12586' },
  { key: 'success_percentage', group: 'about', defaultValue: '79' },
  { key: 'purpose_eyebrow', group: 'about', defaultValue: 'What Drives Us' },
  { key: 'purpose_heading', group: 'about', defaultValue: 'Our Purpose & Values' },
  { key: 'pillar_1_title', group: 'about', defaultValue: 'Our Purpose' },
  {
    key: 'pillar_1_text',
    group: 'about',
    defaultValue: 'We create joyful celebrations through safe, reliable fireworks experiences.',
  },
  { key: 'pillar_2_title', group: 'about', defaultValue: 'Our Dedication' },
  {
    key: 'pillar_2_text',
    group: 'about',
    defaultValue: 'We deliver wide variety, timely service, and dependable support for every order.',
  },
  { key: 'pillar_3_title', group: 'about', defaultValue: 'Our Quality' },
  {
    key: 'pillar_3_text',
    group: 'about',
    defaultValue: 'Every cracker is sourced responsibly and checked to meet high safety expectations.',
  },
  { key: 'pillar_4_title', group: 'about', defaultValue: 'Our Promise' },
  {
    key: 'pillar_4_text',
    group: 'about',
    defaultValue: 'We focus on honest pricing, trusted products, and memorable festive moments.',
  },
  {
    key: 'cta_banner_text',
    group: 'about',
    defaultValue: "Let's Make a Difference in the Lives of Others",
  },
  { key: 'cta_button_text', group: 'about', defaultValue: 'ESTIMATE NOW' },
  { key: 'cta_button_link', group: 'about', defaultValue: '/estimate' },
];

const HOMEPAGE_SETTINGS_FIELDS = [
  { key: 'hero_eyebrow', group: 'homepage', defaultValue: 'WELCOME TO SPARKLE' },
  { key: 'hero_heading_html', group: 'homepage', defaultValue: '' },
  {
    key: 'hero_description_html',
    group: 'homepage',
    defaultValue:
      '<p>Since 2026, <strong>The Bluvel Crackers</strong> has been the No.1 destination for all your celebration needs.</p><p>Whether you are planning a grand festival, a joyous event, or an intimate gathering, we have the perfect crackers to make it unforgettable.</p>',
  },
  { key: 'hero_badge_1_text', group: 'homepage', defaultValue: 'Trustable Crackers Shop In Sivakasi' },
  { key: 'hero_badge_2_text', group: 'homepage', defaultValue: '80% Off Sale' },
  { key: 'hero_badge_3_text', group: 'homepage', defaultValue: 'Free Shipping ₹3000+' },
  { key: 'hero_section_image', group: 'homepage', defaultValue: '' },
  { key: 'welcome_badge_count', group: 'homepage', defaultValue: '25' },
  { key: 'welcome_badge_label', group: 'homepage', defaultValue: 'Years' },
  { key: 'hero_cta_text', group: 'homepage', defaultValue: 'Read More About Bluvel Crackers' },
  { key: 'hero_cta_link', group: 'homepage', defaultValue: '/about' },
  { key: 'featured_products_eyebrow', group: 'homepage', defaultValue: 'Our Best HandPicked Products' },
  { key: 'featured_products_heading', group: 'homepage', defaultValue: "Don't Miss This Products" },
  { key: 'featured_product_ids', group: 'homepage', defaultValue: '[]' },
  { key: 'why_choose_eyebrow', group: 'homepage', defaultValue: 'Our Promise' },
  { key: 'why_choose_title', group: 'homepage', defaultValue: 'Why Choose Us' },
  { key: 'why_choose_subtitle', group: 'homepage', defaultValue: 'Built on quality, value, and trust.' },
  { key: 'why_choose_pillar_1_title', group: 'homepage', defaultValue: 'Best Quality' },
  { key: 'why_choose_pillar_1_text', group: 'homepage', defaultValue: 'Every cracker is sourced directly from trusted manufacturers.' },
  { key: 'why_choose_pillar_2_title', group: 'homepage', defaultValue: 'Wide Variety' },
  { key: 'why_choose_pillar_2_text', group: 'homepage', defaultValue: 'From sparklers to aerial shells, our catalogue covers every celebration.' },
  { key: 'why_choose_pillar_3_title', group: 'homepage', defaultValue: 'Safety First' },
  { key: 'why_choose_pillar_3_text', group: 'homepage', defaultValue: 'All products meet government guidelines and safety expectations.' },
  { key: 'why_choose_pillar_4_title', group: 'homepage', defaultValue: 'Trusted Brand' },
  { key: 'why_choose_pillar_4_text', group: 'homepage', defaultValue: 'Thousands of happy customers rely on us season after season.' },
  { key: 'why_choose_stat_1_label', group: 'homepage', defaultValue: 'Availability' },
  { key: 'why_choose_stat_1_value', group: 'homepage', defaultValue: '100' },
  { key: 'why_choose_stat_2_label', group: 'homepage', defaultValue: 'Best Delivery' },
  { key: 'why_choose_stat_2_value', group: 'homepage', defaultValue: '100' },
  { key: 'why_choose_stat_3_label', group: 'homepage', defaultValue: 'Easy Ordering' },
  { key: 'why_choose_stat_3_value', group: 'homepage', defaultValue: '100' },
  { key: 'why_choose_stat_4_label', group: 'homepage', defaultValue: 'Customer Support' },
  { key: 'why_choose_stat_4_value', group: 'homepage', defaultValue: '100' },
  { key: 'why_choose_bottom_1_value', group: 'homepage', defaultValue: '5000+' },
  { key: 'why_choose_bottom_1_label', group: 'homepage', defaultValue: 'Happy Customers' },
  { key: 'why_choose_bottom_2_value', group: 'homepage', defaultValue: '200+' },
  { key: 'why_choose_bottom_2_label', group: 'homepage', defaultValue: 'Products' },
  { key: 'why_choose_bottom_3_value', group: 'homepage', defaultValue: '80%' },
  { key: 'why_choose_bottom_3_label', group: 'homepage', defaultValue: 'Max Discount' },
  { key: 'why_choose_bottom_4_value', group: 'homepage', defaultValue: 'Pan India' },
  { key: 'why_choose_bottom_4_label', group: 'homepage', defaultValue: 'Delivery' },
];

const PAYMENT_SETTINGS_FIELDS = [
  { key: 'bank_holder', group: 'payment', defaultValue: 'Sparkle Fireworks Pvt Ltd' },
  { key: 'bank_account', group: 'payment', defaultValue: '0000111122223333' },
  { key: 'bank_name', group: 'payment', defaultValue: 'HDFC Bank' },
  { key: 'bank_ifsc', group: 'payment', defaultValue: 'HDFC0001234' },
  { key: 'bank_branch', group: 'payment', defaultValue: 'Sivakasi Main' },
  { key: 'gpay_label', group: 'payment', defaultValue: 'Google Pay' },
  { key: 'gpay_number', group: 'payment', defaultValue: '+91 9876543210' },
  { key: 'phonepe_label', group: 'payment', defaultValue: 'PhonePe' },
  { key: 'phonepe_number', group: 'payment', defaultValue: '+91 9876543210' },
  {
    key: 'payment_instructions_html',
    group: 'payment',
    defaultValue: '<p>After successful payment, please send the screenshot to our Whatsapp number.</p>',
  },
  { key: 'gpay_qr_image', group: 'payment', defaultValue: '' },
  { key: 'phonepe_qr_image', group: 'payment', defaultValue: '' },
  { key: 'payment_page_title', group: 'payment', defaultValue: 'Payment Information' },
  { key: 'payment_page_heading_html', group: 'payment', defaultValue: '<p>Please select an option to pay</p>' },
];

const THEME_SETTINGS_KEYS = new Set(THEME_SETTINGS_FIELDS.map((field) => field.key));
const ABOUT_SETTINGS_KEYS = new Set(ABOUT_SETTINGS_FIELDS.map((field) => field.key));
const HOMEPAGE_SETTINGS_KEYS = new Set(HOMEPAGE_SETTINGS_FIELDS.map((field) => field.key));
const PAYMENT_SETTINGS_KEYS = new Set(PAYMENT_SETTINGS_FIELDS.map((field) => field.key));
const CONTACT_PAGE_KEYS = new Set([
  ...CONTACT_PAGE_SHARED_FIELDS.map((field) => field.key),
  ...CONTACT_PAGE_SETTINGS_FIELDS.map((field) => field.key),
]);
const FULL_HEX_COLOR_REGEX = /^#[0-9a-f]{6}$/i;

const getGlobalSettingsPayload = (settingsMap = {}) =>
  GLOBAL_SETTINGS_FIELDS.reduce((accumulator, field) => {
    accumulator[field.key] = settingsMap[field.key] ?? field.defaultValue;
    return accumulator;
  }, {});

const getThemeSettingsPayload = (settingsMap = {}) =>
  THEME_SETTINGS_FIELDS.reduce((accumulator, field) => {
    accumulator[field.key] = settingsMap[field.key] ?? field.defaultValue;
    return accumulator;
  }, {});

const getTermsSettingsPayload = (settingsMap = {}) => ({
  [TERMS_SETTINGS_FIELD.key]:
    settingsMap[TERMS_SETTINGS_FIELD.key] ??
    settingsMap[LEGACY_TERMS_SETTINGS_KEY] ??
    TERMS_SETTINGS_FIELD.defaultValue,
});

const getAboutSettingsPayload = (settingsMap = {}) => {
  const payload = ABOUT_SETTINGS_FIELDS.reduce((accumulator, field) => {
    accumulator[field.key] = settingsMap[field.key] ?? field.defaultValue;
    return accumulator;
  }, {});

  if (!payload.story_heading_html) {
    payload.story_heading_html =
      settingsMap[LEGACY_ABOUT_HEADING_SETTINGS_KEY] ?? payload.story_heading_html;
  }

  if (!payload.story_description_html) {
    payload.story_description_html =
      settingsMap[LEGACY_ABOUT_DESCRIPTION_SETTINGS_KEY] ?? payload.story_description_html;
  }

  return payload;
};

const getContactPageSettingsPayload = (settingsMap = {}) => {
  const payload = CONTACT_PAGE_SHARED_FIELDS.reduce((accumulator, field) => {
    accumulator[field.key] = settingsMap[field.key] ?? field.defaultValue;
    return accumulator;
  }, {});

  return CONTACT_PAGE_SETTINGS_FIELDS.reduce((accumulator, field) => {
    accumulator[field.key] = settingsMap[field.key] ?? field.defaultValue;
    return accumulator;
  }, payload);
};

const parseHomepageFeaturedProductIds = (value) => {
  if (Array.isArray(value)) {
    return value.map((item) => Number(item)).filter((item) => Number.isInteger(item) && item > 0);
  }

  if (typeof value !== 'string' || !value.trim()) {
    return [];
  }

  try {
    const parsedValue = JSON.parse(value);
    if (!Array.isArray(parsedValue)) {
      return [];
    }

    return parsedValue.map((item) => Number(item)).filter((item) => Number.isInteger(item) && item > 0);
  } catch (error) {
    return [];
  }
};

const getHomepageSettingsPayload = (settingsMap = {}) => {
  const payload = HOMEPAGE_SETTINGS_FIELDS.reduce((accumulator, field) => {
    accumulator[field.key] = settingsMap[field.key] ?? field.defaultValue;
    return accumulator;
  }, {});

  if (!payload.hero_heading_html) {
    payload.hero_heading_html = settingsMap[LEGACY_HOMEPAGE_HEADING_SETTINGS_KEY] ?? payload.hero_heading_html;
  }

  payload.featured_product_ids = parseHomepageFeaturedProductIds(payload.featured_product_ids);

  return payload;
};

const getPaymentSettingsPayload = (settingsMap = {}) =>
  PAYMENT_SETTINGS_FIELDS.reduce((accumulator, field) => {
    accumulator[field.key] = settingsMap[field.key] ?? field.defaultValue;
    return accumulator;
  }, {});

const getSettingsMapByKeys = async (keys = []) => {
  if (!keys.length) {
    return {};
  }

  const [rows] = await pool.query(
    `SELECT setting_key, setting_value
     FROM settings
     WHERE setting_key IN (?)`,
    [keys]
  );

  return rows.reduce((accumulator, row) => {
    accumulator[row.setting_key] = row.setting_value ?? '';
    return accumulator;
  }, {});
};

const getNormalizedTermsPayload = (payload = {}) => {
  if (!payload || Array.isArray(payload) || typeof payload !== 'object') {
    throw new Error('Terms settings payload must be an object.');
  }

  const payloadKeys = Object.keys(payload);
  const unknownKeys = payloadKeys.filter((key) => key !== TERMS_SETTINGS_FIELD.key);
  if (unknownKeys.length > 0) {
    throw new Error(`Unknown terms setting key: ${unknownKeys[0]}`);
  }

  const rawValue = payloadKeys.length === 0 ? '' : payload[TERMS_SETTINGS_FIELD.key];
  if (rawValue != null && typeof rawValue !== 'string') {
    throw new Error(`${TERMS_SETTINGS_FIELD.key} must be a string.`);
  }

  return {
    [TERMS_SETTINGS_FIELD.key]: String(rawValue ?? ''),
  };
};

const getNormalizedAboutPayload = (payload = {}) => {
  if (!payload || Array.isArray(payload) || typeof payload !== 'object') {
    throw new Error('About settings payload must be an object.');
  }

  const payloadKeys = Object.keys(payload);
  const unknownKeys = payloadKeys.filter((key) => !ABOUT_SETTINGS_KEYS.has(key));
  if (unknownKeys.length > 0) {
    throw new Error(`Unknown about setting key: ${unknownKeys[0]}`);
  }

  return ABOUT_SETTINGS_FIELDS.reduce((accumulator, field) => {
    const rawValue = payload[field.key];

    if (Array.isArray(rawValue)) {
      throw new Error(`${field.key} must be a string.`);
    }

    if (rawValue != null && typeof rawValue === 'object') {
      throw new Error(`${field.key} must be a string.`);
    }

    accumulator[field.key] = String(rawValue ?? field.defaultValue ?? '');
    return accumulator;
  }, {});
};

const getNormalizedContactPagePayload = (payload = {}) => {
  if (!payload || Array.isArray(payload) || typeof payload !== 'object') {
    throw new Error('Contact page settings payload must be an object.');
  }

  const payloadKeys = Object.keys(payload);
  const unknownKeys = payloadKeys.filter((key) => !CONTACT_PAGE_KEYS.has(key));
  if (unknownKeys.length > 0) {
    throw new Error(`Unknown contact page setting key: ${unknownKeys[0]}`);
  }

  return [...CONTACT_PAGE_SHARED_FIELDS, ...CONTACT_PAGE_SETTINGS_FIELDS].reduce((accumulator, field) => {
    const rawValue = payload[field.key];

    if (Array.isArray(rawValue)) {
      throw new Error(`${field.key} must be a string.`);
    }

    if (rawValue != null && typeof rawValue === 'object') {
      throw new Error(`${field.key} must be a string.`);
    }

    accumulator[field.key] = String(rawValue ?? field.defaultValue ?? '');
    return accumulator;
  }, {});
};

const getNormalizedHomepagePayload = (payload = {}) => {
  if (!payload || Array.isArray(payload) || typeof payload !== 'object') {
    throw new Error('Homepage settings payload must be an object.');
  }

  const payloadKeys = Object.keys(payload);
  const unknownKeys = payloadKeys.filter((key) => !HOMEPAGE_SETTINGS_KEYS.has(key));
  if (unknownKeys.length > 0) {
    throw new Error(`Unknown homepage setting key: ${unknownKeys[0]}`);
  }

  const normalizedPayload = HOMEPAGE_SETTINGS_FIELDS.reduce((accumulator, field) => {
    const rawValue = payload[field.key];

    if (Array.isArray(rawValue) && field.key !== 'featured_product_ids') {
      throw new Error(`${field.key} must be a string.`);
    }

    if (rawValue != null && typeof rawValue === 'object' && !Array.isArray(rawValue)) {
      throw new Error(`${field.key} must be a string.`);
    }

    accumulator[field.key] = String(rawValue ?? field.defaultValue ?? '');
    return accumulator;
  }, {});

  const normalizedFeaturedProductIds = parseHomepageFeaturedProductIds(payload.featured_product_ids);
  if (normalizedFeaturedProductIds.length !== 7) {
    throw new Error('Exactly 7 featured products are required.');
  }

  normalizedPayload.featured_product_ids = JSON.stringify(normalizedFeaturedProductIds);

  return normalizedPayload;
};

const getNormalizedPaymentPayload = (payload = {}) => {
  if (!payload || Array.isArray(payload) || typeof payload !== 'object') {
    throw new Error('Payment settings payload must be an object.');
  }

  const payloadKeys = Object.keys(payload);
  const unknownKeys = payloadKeys.filter((key) => !PAYMENT_SETTINGS_KEYS.has(key));
  if (unknownKeys.length > 0) {
    throw new Error(`Unknown payment setting key: ${unknownKeys[0]}`);
  }

  return PAYMENT_SETTINGS_FIELDS.reduce((accumulator, field) => {
    const rawValue = payload[field.key];

    if (Array.isArray(rawValue)) {
      throw new Error(`${field.key} must be a string.`);
    }

    if (rawValue != null && typeof rawValue === 'object') {
      throw new Error(`${field.key} must be a string.`);
    }

    accumulator[field.key] = String(rawValue ?? field.defaultValue ?? '');
    return accumulator;
  }, {});
};

const getNormalizedThemePayload = (payload = {}) => {
  const normalizedPayload = {};

  for (const key of Object.keys(payload)) {
    if (!THEME_SETTINGS_KEYS.has(key)) {
      throw new Error(`Unknown theme setting key: ${key}`);
    }
  }

  for (const field of THEME_SETTINGS_FIELDS) {
    if (!(field.key in payload)) {
      throw new Error(`Missing theme setting key: ${field.key}`);
    }

    const value = String(payload[field.key] ?? '').trim().toLowerCase();
    if (!FULL_HEX_COLOR_REGEX.test(value)) {
      throw new Error(`Invalid color value for ${field.key}. Use #RRGGBB format.`);
    }

    normalizedPayload[field.key] = value;
  }

  return normalizedPayload;
};

const upsertSetting = async (key, value, group) => {
  await pool.query(
    `INSERT INTO settings (setting_key, setting_value, setting_group)
     VALUES (?, ?, ?)
     ON DUPLICATE KEY UPDATE
       setting_value = VALUES(setting_value),
       setting_group = VALUES(setting_group)`,
    [key, value ?? '', group]
  );
};

const decodeJsonField = (value, fallback) => {
  if (Array.isArray(value) || (value && typeof value === 'object')) {
    return value;
  }
  if (typeof value !== 'string' || !value.trim()) {
    return fallback;
  }
  try {
    return JSON.parse(value);
  } catch (error) {
    return fallback;
  }
};

const getSingleRow = async (tableName) => {
  const [rows] = await pool.query(`SELECT * FROM ${tableName} ORDER BY id ASC LIMIT 1`);
  return rows[0] || {};
};

const getSingleRowId = async (connection, tableName) => {
  const [rows] = await connection.query(`SELECT id FROM ${tableName} ORDER BY id ASC LIMIT 1`);
  if (rows.length > 0) {
    return rows[0].id;
  }
  const [result] = await connection.query(`INSERT INTO ${tableName} (created_at, updated_at) VALUES (NOW(), NOW())`);
  return result.insertId;
};

const updateSingleRow = async (tableName, values) => {
  const connection = await pool.getConnection();
  try {
    const id = await getSingleRowId(connection, tableName);
    const entries = Object.entries(values);
    const assignments = entries.map(([key]) => `${key} = ?`).join(', ');
    await connection.query(
      `UPDATE ${tableName} SET ${assignments}, updated_at = NOW() WHERE id = ?`,
      [...entries.map(([, value]) => value ?? ''), id]
    );
  } finally {
    connection.release();
  }
};

const homepageToDashboard = (row = {}) => {
  const whyHeading = decodeJsonField(row.why_heading_data, {});
  const whyPillars = decodeJsonField(row.why_pillars, []);
  const whyDials = decodeJsonField(row.why_dials, []);
  const whyStats = decodeJsonField(row.why_stats, []);

  return {
    hero_eyebrow: row.hero_eyebrow || '',
    hero_heading_html: row.welcome_heading || '',
    hero_description_html: row.welcome_text || '',
    hero_badge_1_text: row.badge1_text || '',
    hero_badge_2_text: row.badge2_text || '',
    hero_badge_3_text: row.badge3_text || '',
    hero_section_image: row.welcome_image || '',
    welcome_badge_count: row.welcome_badge_count || '25',
    welcome_badge_label: row.welcome_badge_label || 'Years',
    hero_cta_text: row.welcome_button_text || '',
    hero_cta_link: row.welcome_button_link || '',
    featured_products_eyebrow: row.products_eyebrow || '',
    featured_products_heading: row.products_heading || '',
    featured_product_ids: parseHomepageFeaturedProductIds(row.featured_product_ids),
    why_choose_eyebrow: whyHeading.eyebrow || '',
    why_choose_title: whyHeading.title || '',
    why_choose_subtitle: whyHeading.subtitle || '',
    why_choose_pillar_1_title: whyPillars[0]?.title || '',
    why_choose_pillar_1_text: whyPillars[0]?.text || '',
    why_choose_pillar_2_title: whyPillars[1]?.title || '',
    why_choose_pillar_2_text: whyPillars[1]?.text || '',
    why_choose_pillar_3_title: whyPillars[2]?.title || '',
    why_choose_pillar_3_text: whyPillars[2]?.text || '',
    why_choose_pillar_4_title: whyPillars[3]?.title || '',
    why_choose_pillar_4_text: whyPillars[3]?.text || '',
    why_choose_stat_1_label: whyDials[0]?.label || '',
    why_choose_stat_1_value: whyDials[0]?.value || '',
    why_choose_stat_2_label: whyDials[1]?.label || '',
    why_choose_stat_2_value: whyDials[1]?.value || '',
    why_choose_stat_3_label: whyDials[2]?.label || '',
    why_choose_stat_3_value: whyDials[2]?.value || '',
    why_choose_stat_4_label: whyDials[3]?.label || '',
    why_choose_stat_4_value: whyDials[3]?.value || '',
    why_choose_bottom_1_value: whyStats[0]?.value || '',
    why_choose_bottom_1_label: whyStats[0]?.label || '',
    why_choose_bottom_2_value: whyStats[1]?.value || '',
    why_choose_bottom_2_label: whyStats[1]?.label || '',
    why_choose_bottom_3_value: whyStats[2]?.value || '',
    why_choose_bottom_3_label: whyStats[2]?.label || '',
    why_choose_bottom_4_value: whyStats[3]?.value || '',
    why_choose_bottom_4_label: whyStats[3]?.label || '',
  };
};

const homepageFromDashboard = (payload) => ({
  hero_eyebrow: payload.hero_eyebrow,
  welcome_heading: payload.hero_heading_html,
  welcome_text: payload.hero_description_html,
  badge1_text: payload.hero_badge_1_text,
  badge2_text: payload.hero_badge_2_text,
  badge3_text: payload.hero_badge_3_text,
  welcome_image: payload.hero_section_image,
  welcome_badge_count: payload.welcome_badge_count,
  welcome_badge_label: payload.welcome_badge_label,
  welcome_button_text: payload.hero_cta_text,
  welcome_button_link: payload.hero_cta_link,
  products_eyebrow: payload.featured_products_eyebrow,
  products_heading: payload.featured_products_heading,
  featured_product_ids: payload.featured_product_ids,
  why_heading_data: JSON.stringify({
    eyebrow: payload.why_choose_eyebrow,
    title: payload.why_choose_title,
    subtitle: payload.why_choose_subtitle,
  }),
  why_pillars: JSON.stringify([1, 2, 3, 4].map((index) => ({
    title: payload[`why_choose_pillar_${index}_title`],
    text: payload[`why_choose_pillar_${index}_text`],
  }))),
  why_dials: JSON.stringify([1, 2, 3, 4].map((index) => ({
    label: payload[`why_choose_stat_${index}_label`],
    value: payload[`why_choose_stat_${index}_value`],
  }))),
  why_stats: JSON.stringify([1, 2, 3, 4].map((index) => ({
    label: payload[`why_choose_bottom_${index}_label`],
    value: payload[`why_choose_bottom_${index}_value`],
  }))),
});

// ==========================================
// SETTINGS (key-value store)
// ==========================================

class AdditionalChargeValidationError extends Error {}

const normalizeAdditionalChargeSettings = (settings) => {
  const normalizedSettings = { ...settings };

  const nameKey = 'additional_charge_name';
  const percentageKey = 'additional_charge_percentage';
  const hasName = Object.prototype.hasOwnProperty.call(settings, nameKey);
  const hasPercentage = Object.prototype.hasOwnProperty.call(settings, percentageKey);

  if (!hasName && !hasPercentage) {
    return normalizedSettings;
  }

  if (!hasName || !hasPercentage) {
    throw new AdditionalChargeValidationError('Charge name and discount percentage are required together.');
  }

  if (typeof settings[nameKey] !== 'string') {
    throw new AdditionalChargeValidationError('Charge name must be valid text.');
  }

  const name = settings[nameKey].trim();
  if (!name || name.length > 100) {
    throw new AdditionalChargeValidationError('Charge name is required and must not exceed 100 characters.');
  }

  const rawPercentage = settings[percentageKey];
  if (typeof rawPercentage === 'boolean' || rawPercentage == null || typeof rawPercentage === 'object') {
    throw new AdditionalChargeValidationError('Discount percentage must be a valid number.');
  }

  const percentageText = String(rawPercentage).trim();
  if (!/^\d+(?:\.\d{1,2})?$/.test(percentageText)) {
    throw new AdditionalChargeValidationError('Discount percentage must have a maximum of 2 decimal places.');
  }

  const percentage = Number(percentageText);
  if (!Number.isFinite(percentage) || percentage <= 0 || percentage > 100) {
    throw new AdditionalChargeValidationError('Discount percentage must be greater than 0 and no more than 100.');
  }

  normalizedSettings[nameKey] = name;
  normalizedSettings[percentageKey] = percentage.toFixed(2);

  return normalizedSettings;
};

// GET /api/settings — Get all settings or by group
router.get('/', async (req, res) => {
  try {
    const { group } = req.query;
    let query = 'SELECT * FROM settings';
    const params = [];
    if (group) {
      query += ' WHERE setting_group = ?';
      params.push(group);
    }
    const [rows] = await pool.query(query, params);
    
    // Convert to object for easier frontend consumption
    const settingsMap = {};
    rows.forEach(row => { settingsMap[row.setting_key] = row.setting_value; });
    
    res.json({ success: true, data: settingsMap, raw: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// PUT /api/settings — Bulk update settings
router.put('/', auth, async (req, res) => {
  try {
    if (!req.body || Array.isArray(req.body) || typeof req.body !== 'object') {
      return res.status(400).json({ success: false, message: 'Settings payload must be an object.' });
    }

    const settings = normalizeAdditionalChargeSettings(req.body);
    for (const [key, value] of Object.entries(settings)) {
      await pool.query(
        'INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?',
        [key, value, value]
      );
    }
    res.json({ success: true, message: 'Settings saved' });
  } catch (error) {
    const isValidationError = error instanceof AdditionalChargeValidationError;
    res.status(isValidationError ? 400 : 500).json({ success: false, message: error.message });
  }
});

router.get('/theme', async (req, res, next) => {
  if (req.path === '/theme' && req.baseUrl === '/api/settings') {
    return auth(req, res, next);
  }

  return next();
}, async (req, res) => {
  try {
    const row = await getSingleRow('theme_settings');
    res.json({
      success: true,
      data: {
        color_primary: row.primary_color || '#f8fafc',
        color_secondary: row.secondary_color || '#ffffff',
        color_tertiary: row.tertiary_color || '#f59e0b',
        color_quaternary: row.quaternary_color || '#ec4899',
      },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/theme', (req, res, next) => {
  if (req.baseUrl !== '/api/settings') {
    return res.status(404).json({ success: false, message: 'Route not found.' });
  }

  return auth(req, res, next);
}, async (req, res) => {
  try {
    const normalizedPayload = getNormalizedThemePayload(req.body || {});
    await updateSingleRow('theme_settings', {
      primary_color: normalizedPayload.color_primary,
      secondary_color: normalizedPayload.color_secondary,
      tertiary_color: normalizedPayload.color_tertiary,
      quaternary_color: normalizedPayload.color_quaternary,
    });

    res.json({
      success: true,
      message: 'Theme settings saved successfully.',
      data: normalizedPayload,
    });
  } catch (error) {
    const isValidationError =
      error.message.startsWith('Unknown theme setting key:') ||
      error.message.startsWith('Missing theme setting key:') ||
      error.message.startsWith('Invalid color value for');

    res.status(isValidationError ? 400 : 500).json({
      success: false,
      message: error.message,
    });
  }
});

// ==========================================
// STORE CONFIG (on/off, min order, discount)
// ==========================================

// GET /api/settings/store
router.get('/store', async (req, res) => {
  try {
    const [discountRows] = await pool.query('SELECT discount FROM discounts ORDER BY id DESC LIMIT 1');
    const [pageOffRows] = await pool.query('SELECT status, image FROM page_off ORDER BY id ASC LIMIT 1');
    const homeSettingsRows = await getSingleRow('home_settings');
    res.json({
      success: true,
      data: {
        is_store_open: Number(pageOffRows[0]?.status ?? 1),
        min_order_value: Number(homeSettingsRows?.min_order_value ?? 0),
        global_discount: Number(discountRows[0]?.discount || 0),
        global_gst: Number(homeSettingsRows?.global_gst ?? 0),
        off_banner_image: pageOffRows[0]?.image || '',
      },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// PUT /api/settings/store
router.put('/store', auth, storeConfigUpload, async (req, res) => {
  try {
    const { is_store_open, min_order_value, global_discount, global_gst, apply_discount } = req.body;
    const normalizedStoreOpen = Number(is_store_open ?? 1);
    const normalizedMinOrderValue = Number(min_order_value ?? 0);
    const normalizedGlobalDiscount = Number(global_discount ?? 0);
    const normalizedGlobalGst = Number(global_gst ?? 0);
    const shouldApplyDiscount = apply_discount === true || apply_discount === 'true' || apply_discount === '1';

    if (![0, 1].includes(normalizedStoreOpen)) {
      return res.status(400).json({ success: false, message: 'Store status must be 0 or 1.' });
    }

    if (!Number.isFinite(normalizedMinOrderValue) || normalizedMinOrderValue < 0) {
      return res.status(400).json({ success: false, message: 'Minimum order value must be a valid non-negative number.' });
    }

    if (!Number.isFinite(normalizedGlobalDiscount) || normalizedGlobalDiscount < 0 || normalizedGlobalDiscount > 100) {
      return res.status(400).json({ success: false, message: 'Global discount must be between 0 and 100.' });
    }

    if (!Number.isFinite(normalizedGlobalGst) || normalizedGlobalGst < 0 || normalizedGlobalGst > 100) {
      return res.status(400).json({ success: false, message: 'Global GST must be between 0 and 100.' });
    }

    const [discountRows] = await pool.query('SELECT id FROM discounts ORDER BY id DESC LIMIT 1');
    if (discountRows.length > 0) {
      await pool.query('UPDATE discounts SET discount = ?, updated_at = NOW() WHERE id = ?', [normalizedGlobalDiscount, discountRows[0].id]);
    } else {
      await pool.query('INSERT INTO discounts (discount, created_at, updated_at) VALUES (?, NOW(), NOW())', [normalizedGlobalDiscount]);
    }

    let updatedProducts = 0;
    if (shouldApplyDiscount) {
      const [discountResult] = await pool.query(
        `UPDATE products
         SET product_regular_price = ROUND(product_mrp_price * (100 - ?) / 100, 2),
             updated_at = NOW()
         WHERE product_mrp_price IS NOT NULL`,
        [normalizedGlobalDiscount]
      );
      updatedProducts = discountResult.affectedRows;
    }

    const [pageOffRows] = await pool.query('SELECT * FROM page_off ORDER BY id ASC LIMIT 1');
    const offBannerImage = req.file ? `/uploads/settings/${req.file.filename}` : pageOffRows[0]?.image || '';
    if (pageOffRows.length > 0) {
      await pool.query('UPDATE page_off SET status = ?, image = ?, updated_at = NOW() WHERE id = ?', [normalizedStoreOpen, offBannerImage, pageOffRows[0].id]);
    } else {
      await pool.query('INSERT INTO page_off (status, image, created_at, updated_at) VALUES (?, ?, NOW(), NOW())', [normalizedStoreOpen, offBannerImage]);
    }

    await updateSingleRow('home_settings', { min_order_value: normalizedMinOrderValue, global_gst: normalizedGlobalGst });

    res.json({
      success: true,
      message: shouldApplyDiscount ? 'Global discount applied to products' : 'Store config updated',
      updated_products: updatedProducts,
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// ==========================================
// ORDER STATUSES
// ==========================================

// GET /api/settings/order-statuses
router.get('/order-statuses', async (req, res) => {
  try {
    const [rows] = await pool.query(`
      SELECT os.id,
             os.order_status AS name,
             '#64748b' AS color,
             os.id AS sort_order,
             0 AS usage_count
      FROM order_status os
      ORDER BY os.id ASC
    `);
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.get('/global', auth, async (req, res) => {
  try {
    const row = await getSingleRow('global_settings');
    res.json({
      success: true,
      data: {
        company_name: row.company_name || '',
        seo_title: row.meta_title || '',
        main_logo: row.logo || '',
        favicon: row.favicon || '',
        primary_phone: row.phone_number || '',
        email: '',
        address: row.address || '',
        whatsapp_number: row.whatsapp_number || '',
        footer_content: row.footer_content || '',
        facebook_url: row.facebook_link || '',
        instagram_url: row.instagram_link || '',
        twitter_url: row.twitter_link || '',
        linkedin_url: row.linkedin_link || '',
        youtube_url: row.youtube_link || '',
        offer_text_html: row.top_offer_text || '',
        google_analytics_id: row.header_codes || '',
        show_discount: Boolean(row.show_discount ?? 1),
      },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/global', auth, globalSettingsUpload, async (req, res) => {
  try {
    const files = req.files || {};
    const payload = {};

    for (const field of GLOBAL_SETTINGS_FIELDS) {
      payload[field.key] = req.body[field.key] ?? field.defaultValue;
    }

    const existingMap = await getSingleRow('global_settings');

    const mainLogoFile = files.main_logo?.[0];
    const faviconFile = files.favicon?.[0];

    payload.main_logo = mainLogoFile
      ? `/uploads/settings/${mainLogoFile.filename}`
      : existingMap.logo || payload.main_logo || '';
    payload.favicon = faviconFile
      ? `/uploads/settings/${faviconFile.filename}`
      : existingMap.favicon || payload.favicon || '';

    await updateSingleRow('global_settings', {
      company_name: payload.company_name,
      meta_title: payload.seo_title,
      logo: payload.main_logo,
      favicon: payload.favicon,
      phone_number: payload.primary_phone,
      whatsapp_number: payload.whatsapp_number,
      footer_content: payload.footer_content,
      address: payload.address,
      header_codes: payload.google_analytics_id,
      facebook_link: payload.facebook_url,
      instagram_link: payload.instagram_url,
      twitter_link: payload.twitter_url,
      linkedin_link: payload.linkedin_url,
      youtube_link: payload.youtube_url,
      top_offer_text: payload.offer_text_html,
      show_discount: payload.show_discount === 'true' || payload.show_discount === true ? 1 : 0,
    });

    res.json({
      success: true,
      message: 'Global settings saved successfully.',
      data: getGlobalSettingsPayload(payload),
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.get('/contact-page', async (req, res) => {
  try {
    const row = await getSingleRow('contact_us');
    res.json({
      success: true,
      data: {
        primary_phone: row.phone || '',
        email: row.email || '',
        address: row.address || '',
        contact_intro_eyebrow: row.hero_eyebrow || '',
        contact_intro_heading: row.heading || row.hero_title || '',
        contact_intro_description_html: row.subheading || row.hero_subtitle || '',
        contact_map_iframe_html: row.map_iframe || '',
      },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/contact-page', auth, async (req, res) => {
  try {
    const normalizedPayload = getNormalizedContactPagePayload(req.body || {});

    await updateSingleRow('contact_us', {
      phone: normalizedPayload.primary_phone,
      email: normalizedPayload.email,
      address: normalizedPayload.address,
      hero_eyebrow: normalizedPayload.contact_intro_eyebrow,
      heading: normalizedPayload.contact_intro_heading,
      hero_title: normalizedPayload.contact_intro_heading,
      subheading: normalizedPayload.contact_intro_description_html,
      hero_subtitle: normalizedPayload.contact_intro_description_html,
      map_iframe: normalizedPayload.contact_map_iframe_html,
    });

    res.json({
      success: true,
      message: 'Contact page settings saved successfully.',
      data: getContactPageSettingsPayload(normalizedPayload),
    });
  } catch (error) {
    const isValidationError =
      error.message === 'Contact page settings payload must be an object.' ||
      error.message.startsWith('Unknown contact page setting key:') ||
      error.message.endsWith('must be a string.');

    res.status(isValidationError ? 400 : 500).json({
      success: false,
      message: error.message,
    });
  }
});
// ==========================================
// WELCOME BADGE (YEARS) SETTINGS
// ==========================================
router.get('/welcome-badge', async (req, res) => {
  try {
    const row = await getSingleRow('home_settings');
    res.json({
      success: true,
      data: {
        welcome_badge_count: row.welcome_badge_count || '25',
        welcome_badge_label: row.welcome_badge_label || 'Years',
      },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/welcome-badge', auth, async (req, res) => {
  try {
    const { welcome_badge_count, welcome_badge_label } = req.body;
    if (welcome_badge_count === undefined || welcome_badge_label === undefined) {
      return res.status(400).json({
        success: false,
        message: 'welcome_badge_count and welcome_badge_label are required.',
      });
    }

    const connection = await pool.getConnection();
    try {
      const id = await getSingleRowId(connection, 'home_settings');
      await connection.query(
        `UPDATE home_settings 
         SET welcome_badge_count = ?, welcome_badge_label = ?, updated_at = NOW() 
         WHERE id = ?`,
        [welcome_badge_count, welcome_badge_label, id]
      );
    } finally {
      connection.release();
    }

    res.json({
      success: true,
      message: 'Welcome badge settings saved successfully.',
      data: { welcome_badge_count, welcome_badge_label },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});
// ==========================================
// FESTIVAL OFFER SETTINGS
// ==========================================
router.get('/festival-offer', async (req, res) => {
  try {
    const row = await getSingleRow('home_settings');
    
    // Format datetime-local string (YYYY-MM-DDTHH:mm)
    let formattedDate = '';
    if (row.offer_end_date) {
      const d = new Date(row.offer_end_date);
      const year = d.getFullYear();
      const month = String(d.getMonth() + 1).padStart(2, '0');
      const day = String(d.getDate()).padStart(2, '0');
      const hours = String(d.getHours()).padStart(2, '0');
      const minutes = String(d.getMinutes()).padStart(2, '0');
      formattedDate = `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    res.json({
      success: true,
      data: {
        offer_heading: row.offer_heading || '',
        offer_subheading: row.offer_subheading || '',
        offer_end_date: formattedDate,
        offer_button_text: row.offer_button_text || '',
        offer_button_link: row.offer_button_link || '',
      },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/festival-offer', auth, async (req, res) => {
  try {
    const {
      offer_heading,
      offer_subheading,
      offer_end_date,
      offer_button_text,
      offer_button_link,
    } = req.body;

    const connection = await pool.getConnection();
    try {
      const id = await getSingleRowId(connection, 'home_settings');
      await connection.query(
        `UPDATE home_settings 
         SET offer_heading = ?, 
             offer_subheading = ?, 
             offer_end_date = ?, 
             offer_button_text = ?, 
             offer_button_link = ?, 
             updated_at = NOW() 
         WHERE id = ?`,
        [
          offer_heading ?? '',
          offer_subheading ?? '',
          offer_end_date ? new Date(offer_end_date) : null,
          offer_button_text ?? '',
          offer_button_link ?? '',
          id
        ]
      );
    } finally {
      connection.release();
    }

    res.json({
      success: true,
      message: 'Festival offer settings saved successfully.',
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.get('/homepage', async (req, res) => {
  try {
    const row = await getSingleRow('home_settings');
    res.json({
      success: true,
      data: homepageToDashboard(row),
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/homepage', auth, homepageSettingsUpload, async (req, res) => {
  try {
    const normalizedPayload = getNormalizedHomepagePayload(req.body || {});
    const existingSettings = await getSingleRow('home_settings');
    const heroSectionImageFile = req.files?.hero_section_image?.[0];

    normalizedPayload.hero_section_image = heroSectionImageFile
      ? `/uploads/settings/${heroSectionImageFile.filename}`
      : existingSettings.welcome_image || normalizedPayload.hero_section_image || '';

    await updateSingleRow('home_settings', homepageFromDashboard(normalizedPayload));

    res.json({
      success: true,
      message: 'Homepage settings saved successfully.',
      data: getHomepageSettingsPayload(normalizedPayload),
    });
  } catch (error) {
    const isValidationError =
      error.message === 'Homepage settings payload must be an object.' ||
      error.message.startsWith('Unknown homepage setting key:') ||
      error.message.endsWith('must be a string.') ||
      error.message === 'Exactly 7 featured products are required.';

    res.status(isValidationError ? 400 : 500).json({
      success: false,
      message: error.message,
    });
  }
});

router.get('/about', async (req, res) => {
  try {
    const row = await getSingleRow('about_us');
    res.json({
      success: true,
      data: {
        story_banner_image: row.banner_image || '',
        story_main_image: row.main_image || '',
        story_eyebrow: row.eyebrow || row.hero_eyebrow || '',
        story_heading_html: row.heading || row.hero_title || '',
        story_description_html: row.description || row.hero_subtitle || '',
        badge_1_text: row.badge1_text || '',
        badge_2_text: row.badge2_text || '',
        badge_3_text: row.badge3_text || '',
        products_count: String(row.products_count ?? ''),
        customers_count: String(row.customers_count ?? ''),
        success_percentage: String(row.success_percentage ?? ''),
        purpose_eyebrow: row.purpose_eyebrow || '',
        purpose_heading: row.purpose_heading || '',
        pillar_1_title: row.p1_title || '',
        pillar_1_text: row.p1_text || '',
        pillar_2_title: row.p2_title || '',
        pillar_2_text: row.p2_text || '',
        pillar_3_title: row.p3_title || '',
        pillar_3_text: row.p3_text || '',
        pillar_4_title: row.p4_title || '',
        pillar_4_text: row.p4_text || '',
        cta_banner_text: row.action_text || '',
        cta_button_text: row.action_button_text || '',
        cta_button_link: row.action_button_link || '',
      },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/about', auth, aboutSettingsUpload, async (req, res) => {
  try {
    const files = req.files || {};
    const normalizedPayload = getNormalizedAboutPayload(req.body || {});
    const existingSettings = await getSingleRow('about_us');

    const bannerFile = files.story_banner_image?.[0];
    const mainImageFile = files.story_main_image?.[0];

    normalizedPayload.story_banner_image = bannerFile
      ? `/uploads/settings/${bannerFile.filename}`
      : existingSettings.banner_image || normalizedPayload.story_banner_image || '';
    normalizedPayload.story_main_image = mainImageFile
      ? `/uploads/settings/${mainImageFile.filename}`
      : existingSettings.main_image || normalizedPayload.story_main_image || '';

    await updateSingleRow('about_us', {
      banner_image: normalizedPayload.story_banner_image,
      main_image: normalizedPayload.story_main_image,
      eyebrow: normalizedPayload.story_eyebrow,
      hero_eyebrow: normalizedPayload.story_eyebrow,
      heading: normalizedPayload.story_heading_html,
      hero_title: normalizedPayload.story_heading_html,
      description: normalizedPayload.story_description_html,
      hero_subtitle: normalizedPayload.story_description_html,
      badge1_text: normalizedPayload.badge_1_text,
      badge2_text: normalizedPayload.badge_2_text,
      badge3_text: normalizedPayload.badge_3_text,
      products_count: Number(normalizedPayload.products_count || 0),
      customers_count: Number(normalizedPayload.customers_count || 0),
      success_percentage: Number(normalizedPayload.success_percentage || 0),
      purpose_eyebrow: normalizedPayload.purpose_eyebrow,
      purpose_heading: normalizedPayload.purpose_heading,
      p1_title: normalizedPayload.pillar_1_title,
      p1_text: normalizedPayload.pillar_1_text,
      p2_title: normalizedPayload.pillar_2_title,
      p2_text: normalizedPayload.pillar_2_text,
      p3_title: normalizedPayload.pillar_3_title,
      p3_text: normalizedPayload.pillar_3_text,
      p4_title: normalizedPayload.pillar_4_title,
      p4_text: normalizedPayload.pillar_4_text,
      action_text: normalizedPayload.cta_banner_text,
      action_button_text: normalizedPayload.cta_button_text,
      action_button_link: normalizedPayload.cta_button_link,
    });

    res.json({
      success: true,
      message: 'About settings saved successfully.',
      data: normalizedPayload,
    });
  } catch (error) {
    const isValidationError =
      error.message === 'About settings payload must be an object.' ||
      error.message.startsWith('Unknown about setting key:') ||
      error.message.endsWith('must be a string.');

    res.status(isValidationError ? 400 : 500).json({
      success: false,
      message: error.message,
    });
  }
});

router.get('/terms', auth, async (req, res) => {
  try {
    const row = await getSingleRow('term_conditions');
    res.json({
      success: true,
      data: { terms_conditions_html: row.content || '' },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/terms', auth, async (req, res) => {
  try {
    const normalizedPayload = getNormalizedTermsPayload(req.body || {});
    await updateSingleRow('term_conditions', {
      content: normalizedPayload[TERMS_SETTINGS_FIELD.key],
    });

    res.json({
      success: true,
      message: 'Terms and conditions saved successfully.',
      data: normalizedPayload,
    });
  } catch (error) {
    const isValidationError =
      error.message === 'Terms settings payload must be an object.' ||
      error.message.startsWith('Unknown terms setting key:') ||
      error.message.endsWith('must be a string.');

    res.status(isValidationError ? 400 : 500).json({
      success: false,
      message: error.message,
    });
  }
});

// POST /api/settings/order-statuses
router.post('/order-statuses', auth, async (req, res) => {
  try {
    const name = req.body.name?.trim();
    const color = req.body.color?.trim() || '#64748b';
    const requestedSortOrder = Number(req.body.sort_order ?? 0);

    if (!name) {
      return res.status(400).json({ success: false, message: 'Status name is required.' });
    }

    const [result] = await pool.query('INSERT INTO order_status (order_status, created_at, updated_at) VALUES (?, NOW(), NOW())', [name]);
    res.status(201).json({ success: true, message: 'Status created', id: result.insertId });
  } catch (error) {
    if (error.code === 'ER_DUP_ENTRY') {
      return res.status(409).json({ success: false, message: 'Status name already exists.' });
    }
    res.status(500).json({ success: false, message: error.message });
  }
});

// PUT /api/settings/order-statuses/reorder
router.put('/order-statuses/reorder', auth, async (req, res) => {
  const connection = await pool.getConnection();
  try {
    const statuses = Array.isArray(req.body.statuses) ? req.body.statuses : [];

    if (statuses.length === 0) {
      return res.status(400).json({ success: false, message: 'Statuses are required for reorder.' });
    }

    const ids = statuses.map((status) => Number(status.id)).filter(Boolean);
    if (ids.length !== statuses.length) {
      return res.status(400).json({ success: false, message: 'Invalid status ids provided.' });
    }

    const [existingRows] = await connection.query('SELECT id FROM order_status');
    if (existingRows.length !== statuses.length) {
      return res.status(400).json({ success: false, message: 'Reorder payload must include all existing statuses.' });
    }

    const existingIds = new Set(existingRows.map((row) => Number(row.id)));
    const hasUnknownIds = ids.some((id) => !existingIds.has(id));
    if (hasUnknownIds) {
      return res.status(400).json({ success: false, message: 'One or more statuses do not exist.' });
    }

    await connection.beginTransaction();

    for (let index = 0; index < statuses.length; index += 1) {
      // Laravel order_status does not have sort_order; keep endpoint as a no-op compatibility call.
    }

    await connection.commit();
    res.json({ success: true, message: 'Status order updated.' });
  } catch (error) {
    await connection.rollback();
    res.status(500).json({ success: false, message: error.message });
  } finally {
    connection.release();
  }
});

// PUT /api/settings/order-statuses/:id
router.put('/order-statuses/:id', auth, async (req, res) => {
  const connection = await pool.getConnection();
  try {
    const name = req.body.name?.trim();
    const color = req.body.color?.trim() || '#64748b';
    const sort_order = Number(req.body.sort_order ?? 0);

    if (!name) {
      return res.status(400).json({ success: false, message: 'Status name is required.' });
    }

    const [rows] = await connection.query('SELECT id, order_status AS name FROM order_status WHERE id = ? LIMIT 1', [req.params.id]);
    if (rows.length === 0) {
      return res.status(404).json({ success: false, message: 'Status not found.' });
    }

    const currentStatus = rows[0];

    await connection.beginTransaction();

    const [result] = await connection.query(
      'UPDATE order_status SET order_status = ?, updated_at = NOW() WHERE id = ?',
      [name, req.params.id]
    );

    if (currentStatus.name !== name) {
      await connection.query('UPDATE orders SET status = ? WHERE status = ?', [name, currentStatus.name]);
    }

    await connection.commit();
    res.json({ success: true, message: 'Status updated.' });
  } catch (error) {
    await connection.rollback();
    if (error.code === 'ER_DUP_ENTRY') {
      return res.status(409).json({ success: false, message: 'Status name already exists.' });
    }
    res.status(500).json({ success: false, message: error.message });
  } finally {
    connection.release();
  }
});

// DELETE /api/settings/order-statuses/:id
router.delete('/order-statuses/:id', auth, async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT id, order_status AS name FROM order_status WHERE id = ?', [req.params.id]);
    if (rows.length === 0) {
      return res.status(404).json({ success: false, message: 'Status not found.' });
    }

    const statusName = rows[0].name;
    const [[{ usageCount }]] = await pool.query('SELECT COUNT(*) AS usageCount FROM orders WHERE status = ?', [statusName]);
    if (Number(usageCount) > 0) {
      return res.status(400).json({ success: false, message: 'This status is already used by existing orders and cannot be deleted.' });
    }

    await pool.query('DELETE FROM order_status WHERE id = ?', [req.params.id]);
    res.json({ success: true, message: 'Status deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// ==========================================
// GEOGRAPHY (States, Cities, Areas)
// ==========================================

// States
router.get('/states', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT id, state AS name FROM state_list ORDER BY state ASC');
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.post('/states', auth, async (req, res) => {
  try {
    const name = req.body.name?.trim();
    if (!name) {
      return res.status(400).json({ success: false, message: 'State name is required.' });
    }

    const [result] = await pool.query('INSERT INTO state_list (state) VALUES (?)', [name]);
    res.status(201).json({ success: true, id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/states/:id', auth, async (req, res) => {
  try {
    const name = req.body.name?.trim();
    if (!name) {
      return res.status(400).json({ success: false, message: 'State name is required.' });
    }

    const [result] = await pool.query('UPDATE state_list SET state = ? WHERE id = ?', [name, req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'State not found.' });
    }

    res.json({ success: true, message: 'State updated' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.delete('/states/:id', auth, async (req, res) => {
  try {
    const [result] = await pool.query('DELETE FROM state_list WHERE id = ?', [req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'State not found.' });
    }

    res.json({ success: true, message: 'State deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Cities
router.get('/cities', async (req, res) => {
  try {
    const [rows] = await pool.query(`
      SELECT c.id, c.state_code AS state_id, c.city_name AS name, c.city_code AS code, s.state AS state_name
      FROM city_list c
      LEFT JOIN state_list s ON s.id = c.state_code
      ORDER BY c.city_name ASC
    `);
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.post('/cities', auth, async (req, res) => {
  try {
    const { state_id, name, code } = req.body;
    if (!state_id) {
      return res.status(400).json({ success: false, message: 'State is required.' });
    }

    const cityName = name?.trim();
    if (!cityName) {
      return res.status(400).json({ success: false, message: 'City name is required.' });
    }

    const [result] = await pool.query('INSERT INTO city_list (state_code, city_name, city_code) VALUES (?, ?, ?)', [state_id, cityName, code?.trim() || null]);
    res.status(201).json({ success: true, id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/cities/:id', auth, async (req, res) => {
  try {
    const { state_id, name, code } = req.body;
    if (!state_id) {
      return res.status(400).json({ success: false, message: 'State is required.' });
    }

    const cityName = name?.trim();
    if (!cityName) {
      return res.status(400).json({ success: false, message: 'City name is required.' });
    }

    const [result] = await pool.query(
      'UPDATE city_list SET state_code = ?, city_name = ?, city_code = ? WHERE id = ?',
      [state_id, cityName, code?.trim() || null, req.params.id]
    );

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'City not found.' });
    }

    res.json({ success: true, message: 'City updated' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.delete('/cities/:id', auth, async (req, res) => {
  try {
    const [result] = await pool.query('DELETE FROM city_list WHERE id = ?', [req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'City not found.' });
    }

    res.json({ success: true, message: 'City deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Areas
router.get('/areas', async (req, res) => {
  try {
    const [rows] = await pool.query(
      `SELECT a.id, a.city_id, a.area_name AS name, a.pincode, c.city_name, c.state_code AS state_id, s.state AS state_name
       FROM areas a
       LEFT JOIN city_list c ON a.city_id = c.id
       LEFT JOIN state_list s ON c.state_code = s.id
       ORDER BY a.area_name ASC`
    );
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.post('/areas', auth, async (req, res) => {
  try {
    const { city_id, name, pincode } = req.body;
    if (!city_id) {
      return res.status(400).json({ success: false, message: 'City is required.' });
    }

    const areaName = name?.trim();
    if (!areaName) {
      return res.status(400).json({ success: false, message: 'Area name is required.' });
    }

    const [result] = await pool.query('INSERT INTO areas (city_id, area_name, pincode, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', [city_id, areaName, pincode?.trim() || null]);
    res.status(201).json({ success: true, id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/areas/:id', auth, async (req, res) => {
  try {
    const { city_id, name, pincode } = req.body;
    if (!city_id) {
      return res.status(400).json({ success: false, message: 'City is required.' });
    }

    const areaName = name?.trim();
    if (!areaName) {
      return res.status(400).json({ success: false, message: 'Area name is required.' });
    }

    const [result] = await pool.query(
      'UPDATE areas SET city_id = ?, area_name = ?, pincode = ?, updated_at = NOW() WHERE id = ?',
      [city_id, areaName, pincode?.trim() || null, req.params.id]
    );

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Area not found.' });
    }

    res.json({ success: true, message: 'Area updated' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.delete('/areas/:id', auth, async (req, res) => {
  try {
    const [result] = await pool.query('DELETE FROM areas WHERE id = ?', [req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Area not found.' });
    }

    res.json({ success: true, message: 'Area deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// ==========================================
// SEO, BLOGS, BRANDS, ENQUIRIES
// ==========================================

// SEO Headings
router.get('/seo-headings', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT id, heading AS page_name, heading FROM seo_heading ORDER BY id ASC');
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.post('/seo-headings', auth, async (req, res) => {
  try {
    const page_name = req.body.page_name?.trim();
    const heading = req.body.heading?.trim();

    if (!page_name) {
      return res.status(400).json({ success: false, message: 'Page name is required.' });
    }

    if (!heading) {
      return res.status(400).json({ success: false, message: 'Heading is required.' });
    }

    const [result] = await pool.query('INSERT INTO seo_heading (heading, created_at, updated_at) VALUES (?, NOW(), NOW())', [heading || page_name]);
    res.status(201).json({ success: true, message: 'SEO heading created.', id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/seo-headings/:id', auth, async (req, res) => {
  try {
    const page_name = req.body.page_name?.trim();
    const heading = req.body.heading?.trim();

    if (!page_name) {
      return res.status(400).json({ success: false, message: 'Page name is required.' });
    }

    if (!heading) {
      return res.status(400).json({ success: false, message: 'Heading is required.' });
    }

    const [result] = await pool.query(
      'UPDATE seo_heading SET heading = ?, updated_at = NOW() WHERE id = ?',
      [heading || page_name, req.params.id]
    );

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'SEO heading not found.' });
    }

    res.json({ success: true, message: 'SEO heading updated.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.delete('/seo-headings/:id', auth, async (req, res) => {
  try {
    const [[{ linkedSeoDetailsCount }]] = await pool.query(
      'SELECT COUNT(*) AS linkedSeoDetailsCount FROM seo_datas WHERE seo_headingId = ?',
      [req.params.id]
    );

    if (linkedSeoDetailsCount > 0) {
      return res.status(409).json({
        success: false,
        message: 'This SEO heading is used by existing SEO details and cannot be deleted.',
      });
    }

    const [result] = await pool.query('DELETE FROM seo_heading WHERE id = ?', [req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'SEO heading not found.' });
    }

    res.json({ success: true, message: 'SEO heading deleted.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// SEO Details
router.get('/seo-details', async (req, res) => {
  try {
    const [rows] = await pool.query(`
      SELECT
        sd.id,
        sd.seo_headingId AS seo_heading_id,
        sd.meta_title,
        sd.meta_des AS meta_description,
        sd.meta_key AS meta_keywords,
        sd.name,
        sd.description,
        sd.image,
        sd.alt_key,
        sd.url,
        sd.canonical,
        sd.feet_content,
        sd.created_at,
        sd.updated_at,
        sh.heading AS heading_page_name,
        sh.heading AS seo_heading_label
      FROM seo_datas sd
      LEFT JOIN seo_heading sh ON sh.id = sd.seo_headingId
      ORDER BY sd.id ASC
    `);
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.post('/seo-details', auth, seoDetailsUpload, async (req, res) => {
  try {
    const seoHeadingId = Number(req.body.seo_heading_id);
    const meta_title = req.body.meta_title?.trim();
    const meta_description = req.body.meta_description?.trim();
    const meta_keywords = req.body.meta_keywords?.trim();
    const name = req.body.name?.trim();
    const description = req.body.description?.trim();
    const alt_key = req.body.alt_key?.trim();
    const url = req.body.url?.trim();
    const canonical = req.body.canonical?.trim() || null;
    const feet_content = req.body.feet_content?.trim();
    const image = req.file
      ? `/uploads/seo/${req.file.filename}`
      : req.body.existing_image?.trim() || req.body.image?.trim() || null;

    if (!Number.isInteger(seoHeadingId) || seoHeadingId <= 0) {
      return res.status(400).json({ success: false, message: 'SEO heading is required.' });
    }

    const [headingRows] = await pool.query(
      'SELECT id, heading AS page_name, heading FROM seo_heading WHERE id = ? LIMIT 1',
      [seoHeadingId]
    );

    if (headingRows.length === 0) {
      return res.status(400).json({ success: false, message: 'Selected SEO heading is invalid.' });
    }

    if (!meta_title || !meta_description || !meta_keywords || !name || !description || !alt_key || !url || !feet_content) {
      return res.status(400).json({ success: false, message: 'All required SEO detail fields must be filled.' });
    }

    if (!image) {
      return res.status(400).json({ success: false, message: 'SEO image is required.' });
    }

    const [result] = await pool.query(
      `INSERT INTO seo_datas (
        seo_headingId, meta_title, meta_des, meta_key,
        name, description, image, alt_key, url, canonical, feet_content, created_at, updated_at
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())`,
      [
        seoHeadingId,
        meta_title,
        meta_description,
        meta_keywords,
        name,
        description,
        image,
        alt_key,
        url,
        canonical,
        feet_content,
      ]
    );
    res.status(201).json({ success: true, message: 'SEO detail created.', id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/seo-details/:id', auth, seoDetailsUpload, async (req, res) => {
  try {
    const seoHeadingId = Number(req.body.seo_heading_id);
    const meta_title = req.body.meta_title?.trim();
    const meta_description = req.body.meta_description?.trim();
    const meta_keywords = req.body.meta_keywords?.trim();
    const name = req.body.name?.trim();
    const description = req.body.description?.trim();
    const alt_key = req.body.alt_key?.trim();
    const url = req.body.url?.trim();
    const canonical = req.body.canonical?.trim() || null;
    const feet_content = req.body.feet_content?.trim();

    if (!Number.isInteger(seoHeadingId) || seoHeadingId <= 0) {
      return res.status(400).json({ success: false, message: 'SEO heading is required.' });
    }

    const [existingRows] = await pool.query('SELECT image FROM seo_datas WHERE id = ? LIMIT 1', [req.params.id]);
    if (existingRows.length === 0) {
      return res.status(404).json({ success: false, message: 'SEO detail not found.' });
    }

    const [headingRows] = await pool.query(
      'SELECT id, heading AS page_name, heading FROM seo_heading WHERE id = ? LIMIT 1',
      [seoHeadingId]
    );

    if (headingRows.length === 0) {
      return res.status(400).json({ success: false, message: 'Selected SEO heading is invalid.' });
    }

    if (!meta_title || !meta_description || !meta_keywords || !name || !description || !alt_key || !url || !feet_content) {
      return res.status(400).json({ success: false, message: 'All required SEO detail fields must be filled.' });
    }

    const image = req.file
      ? `/uploads/seo/${req.file.filename}`
      : req.body.existing_image?.trim() || req.body.image?.trim() || existingRows[0].image;

    if (!image) {
      return res.status(400).json({ success: false, message: 'SEO image is required.' });
    }

    await pool.query(
      `UPDATE seo_datas
       SET seo_headingId = ?, meta_title = ?, meta_des = ?, meta_key = ?,
           name = ?, description = ?, image = ?, alt_key = ?, url = ?, canonical = ?, feet_content = ?, updated_at = NOW()
       WHERE id = ?`,
      [
        seoHeadingId,
        meta_title,
        meta_description,
        meta_keywords,
        name,
        description,
        image,
        alt_key,
        url,
        canonical,
        feet_content,
        req.params.id,
      ]
    );

    res.json({ success: true, message: 'SEO detail updated.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.delete('/seo-details/:id', auth, async (req, res) => {
  try {
    const [result] = await pool.query('DELETE FROM seo_datas WHERE id = ?', [req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'SEO detail not found.' });
    }

    res.json({ success: true, message: 'SEO detail deleted.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Blogs
router.get('/blogs', async (req, res) => {
  try {
    const [rows] = await pool.query(
      `SELECT id, title, url AS slug, meta_title,
              COALESCE(meta_description, meta_des) AS meta_description,
              COALESCE(meta_keywords, meta_key) AS meta_keywords,
              feet_content AS content, image,
              1 AS is_published, created_at AS published_at, created_at, updated_at
       FROM blogs
       ORDER BY created_at DESC, id DESC`
    );
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.post('/blogs', auth, blogImageUpload, async (req, res) => {
  try {
    const metaTitle = req.body.meta_title?.trim();
    const metaDescription = req.body.meta_description?.trim();
    const metaKeywords = req.body.meta_keywords?.trim();
    const blogName = req.body.blog_name?.trim() || req.body.title?.trim();
    const feetContent = req.body.feet_content?.trim() || req.body.content?.trim();
    const image = req.file ? `/uploads/blogs/${req.file.filename}` : req.body.image?.trim() || null;

    if (!metaTitle || !metaDescription || !metaKeywords || !blogName || !feetContent) {
      return res.status(400).json({ success: false, message: 'All required blog fields must be filled.' });
    }

    if (!image) {
      return res.status(400).json({ success: false, message: 'Blog image is required.' });
    }

    const slug = slugifyBlogName(blogName);

    const [result] = await pool.query(
      `INSERT INTO blogs (
        title, url, meta_title, meta_description, meta_keywords, meta_des, meta_key,
        feet_content, image, created_at, updated_at
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())`,
      [blogName, slug, metaTitle, metaDescription, metaKeywords, metaDescription, metaKeywords, feetContent, image]
    );
    res.status(201).json({ success: true, message: 'Blog created.', id: result.insertId });
  } catch (error) {
    if (error.code === 'ER_DUP_ENTRY') {
      return res.status(400).json({ success: false, message: 'A blog with the generated slug already exists.' });
    }
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/blogs/:id', auth, blogImageUpload, async (req, res) => {
  try {
    const blogId = Number(req.params.id);
    const metaTitle = req.body.meta_title?.trim();
    const metaDescription = req.body.meta_description?.trim();
    const metaKeywords = req.body.meta_keywords?.trim();
    const blogName = req.body.blog_name?.trim() || req.body.title?.trim();
    const feetContent = req.body.feet_content?.trim() || req.body.content?.trim();

    if (!Number.isInteger(blogId) || blogId <= 0) {
      return res.status(400).json({ success: false, message: 'Blog id is invalid.' });
    }

    if (!metaTitle || !metaDescription || !metaKeywords || !blogName || !feetContent) {
      return res.status(400).json({ success: false, message: 'All required blog fields must be filled.' });
    }

    const [existingRows] = await pool.query('SELECT image FROM blogs WHERE id = ? LIMIT 1', [blogId]);
    if (existingRows.length === 0) {
      return res.status(404).json({ success: false, message: 'Blog not found.' });
    }

    const image = req.file
      ? `/uploads/blogs/${req.file.filename}`
      : req.body.existing_image?.trim() || existingRows[0].image;

    if (!image) {
      return res.status(400).json({ success: false, message: 'Blog image is required.' });
    }

    const slug = slugifyBlogName(blogName);

    await pool.query(
      `UPDATE blogs
       SET title = ?, url = ?, meta_title = ?, meta_description = ?, meta_keywords = ?,
           meta_des = ?, meta_key = ?, feet_content = ?, image = ?, updated_at = NOW()
       WHERE id = ?`,
      [blogName, slug, metaTitle, metaDescription, metaKeywords, metaDescription, metaKeywords, feetContent, image, blogId]
    );

    res.json({ success: true, message: 'Blog updated.' });
  } catch (error) {
    if (error.code === 'ER_DUP_ENTRY') {
      return res.status(400).json({ success: false, message: 'A blog with the generated slug already exists.' });
    }
    res.status(500).json({ success: false, message: error.message });
  }
});

router.delete('/blogs/:id', auth, async (req, res) => {
  try {
    const [result] = await pool.query('DELETE FROM blogs WHERE id = ?', [req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Blog not found.' });
    }

    res.json({ success: true, message: 'Blog deleted.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Brands
router.get('/brands', async (req, res) => {
  try {
    const search = req.query.search?.trim();
    let query = `
      SELECT id, name, logo, sort_order, is_active, created_at
      FROM brands
      WHERE 1 = 1
    `;
    const params = [];

    if (search) {
      query += ' AND name LIKE ?';
      params.push(`%${search}%`);
    }

    query += ' ORDER BY sort_order ASC, id DESC';

    const [rows] = await pool.query(query, params);
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.post('/brands', auth, brandLogoUpload, async (req, res) => {
  try {
    const name = req.body.name?.trim() || 'Unnamed Brand';
    const sort_order = Number(req.body.sort_order) || 0;
    const is_active = req.body.is_active !== undefined ? Number(req.body.is_active) : 1;
    const logo = req.file ? `/uploads/brands/${req.file.filename}` : req.body.logo?.trim() || null;
    if (!logo) {
      return res.status(400).json({ success: false, message: 'Brand logo is required.' });
    }

    const [result] = await pool.query(
      'INSERT INTO brands (name, logo, sort_order, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())',
      [name, logo, sort_order, is_active]
    );
    res.status(201).json({ success: true, message: 'Brand created', id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/brands/:id', auth, brandLogoUpload, async (req, res) => {
  try {
    const [existingRows] = await pool.query('SELECT logo FROM brands WHERE id = ? LIMIT 1', [req.params.id]);
    if (existingRows.length === 0) {
      return res.status(404).json({ success: false, message: 'Brand not found.' });
    }

    const name = req.body.name?.trim() || 'Unnamed Brand';
    const sort_order = Number(req.body.sort_order) || 0;
    const is_active = req.body.is_active !== undefined ? Number(req.body.is_active) : 1;
    const logo = req.file
      ? `/uploads/brands/${req.file.filename}`
      : req.body.logo?.trim() || existingRows[0].logo;

    await pool.query(
      'UPDATE brands SET name = ?, logo = ?, sort_order = ?, is_active = ?, updated_at = NOW() WHERE id = ?',
      [name, logo, sort_order, is_active, req.params.id]
    );
    res.json({ success: true, message: 'Brand updated' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.delete('/brands/:id', auth, async (req, res) => {
  try {
    const [result] = await pool.query('DELETE FROM brands WHERE id = ?', [req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Brand not found.' });
    }

    res.json({ success: true, message: 'Brand deleted' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Enquiries
router.get('/enquiries', auth, async (req, res) => {
  try {
    const { search, is_read, start_date, end_date } = req.query;
    const normalizedIsRead = is_read === undefined
      ? null
      : is_read === '0' || is_read === '1'
        ? Number(is_read)
        : undefined;

    if (normalizedIsRead === undefined) {
      return res.status(400).json({ success: false, message: 'is_read filter must be 0 or 1.' });
    }

    let query = `
      SELECT id, name, email, phone, message, is_read, created_at, updated_at
      FROM contact_enquiries
      WHERE 1 = 1
    `;
    const params = [];

    if (search) {
      query += ' AND (name LIKE ? OR email LIKE ? OR phone LIKE ? OR message LIKE ?)';
      params.push(`%${search}%`, `%${search}%`, `%${search}%`, `%${search}%`);
    }

    if (normalizedIsRead !== null) {
      query += ' AND is_read = ?';
      params.push(normalizedIsRead);
    }

    if (start_date) {
      query += ' AND DATE(created_at) >= ?';
      params.push(start_date);
    }

    if (end_date) {
      query += ' AND DATE(created_at) <= ?';
      params.push(end_date);
    }

    query += ' ORDER BY created_at DESC';

    const [rows] = await pool.query(query, params);
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.put('/enquiries/:id/read', auth, async (req, res) => {
  try {
    const enquiryId = Number(req.params.id);
    const isRead = req.body?.is_read;
    const normalizedIsRead = isRead === true || isRead === 1 || isRead === '1' ? 1 : isRead === false || isRead === 0 || isRead === '0' ? 0 : null;

    if (!Number.isInteger(enquiryId) || enquiryId <= 0) {
      return res.status(400).json({ success: false, message: 'Enquiry id is invalid.' });
    }

    if (normalizedIsRead == null) {
      return res.status(400).json({ success: false, message: 'is_read must be true or false.' });
    }

    const [rows] = await pool.query('SELECT id FROM contact_enquiries WHERE id = ?', [enquiryId]);
    if (rows.length === 0) {
      return res.status(404).json({ success: false, message: 'Enquiry not found.' });
    }

    await pool.query(
      'UPDATE contact_enquiries SET is_read = ?, updated_at = NOW() WHERE id = ?',
      [normalizedIsRead, enquiryId]
    );

    res.json({
      success: true,
      message: `Enquiry marked as ${normalizedIsRead ? 'read' : 'unread'}.`,
      data: { id: enquiryId, is_read: normalizedIsRead },
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.delete('/enquiries/:id', auth, async (req, res) => {
  try {
    const [result] = await pool.query('DELETE FROM contact_enquiries WHERE id = ?', [req.params.id]);

    if (result.affectedRows === 0) {
      return res.status(404).json({ success: false, message: 'Enquiry not found.' });
    }

    res.json({ success: true, message: 'Enquiry deleted.' });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

router.post('/enquiries', async (req, res) => {
  try {
    const { name, email, phone, message } = req.body;
    const [result] = await pool.query(
      'INSERT INTO contact_enquiries (name, email, phone, message, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())',
      [name, email, phone, message]
    );
    res.status(201).json({ success: true, id: result.insertId });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

module.exports = router;
