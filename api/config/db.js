const mysql = require('mysql2/promise');
const fs = require('fs');
const path = require('path');
require('dotenv').config();

const databaseName = process.env.DB_NAME || 'crackers_shop';
const baseDbConfig = {
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  port: process.env.DB_PORT || 3306,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
  enableKeepAlive: true,
  keepAliveInitialDelay: 0,
};

const pool = mysql.createPool({
  ...baseDbConfig,
  database: databaseName,
});

const quoteIdentifier = (identifier) => `\`${identifier.replace(/`/g, '``')}\``;

const getSchemaStatements = () => {
  const schemaPath = path.join(__dirname, 'schema.sql');
  const schemaSql = fs
    .readFileSync(schemaPath, 'utf8')
    .replace(/CREATE DATABASE IF NOT EXISTS\s+`?[\w-]+`?\s*;/i, `CREATE DATABASE IF NOT EXISTS ${quoteIdentifier(databaseName)};`)
    .replace(/USE\s+`?[\w-]+`?\s*;/i, `USE ${quoteIdentifier(databaseName)};`);

  return schemaSql
    .split(';')
    .map((statement) => statement.trim())
    .filter(Boolean);
};

const ensureDatabaseExists = async () => {
  const serverPool = mysql.createPool(baseDbConfig);
  try {
    await serverPool.query(`CREATE DATABASE IF NOT EXISTS ${quoteIdentifier(databaseName)}`);
  } finally {
    await serverPool.end();
  }
};

const ensureBaseSchema = async (connection) => {
  const [tableRows] = await connection.query('SHOW TABLES');
  const tableNameKey = `Tables_in_${databaseName}`;
  const existingTables = new Set(tableRows.map((row) => row[tableNameKey]));

  if (existingTables.has('migrations') || existingTables.has('users') || existingTables.has('global_settings')) {
    return;
  }

  if (existingTables.has('admin_users')) {
    return;
  }

  const statements = getSchemaStatements();
  for (const statement of statements) {
    await connection.query(statement);
  }

  console.log('Database schema initialized or repaired for:', databaseName);
};

const ensureCategoriesSchema = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'categories'`);
  if (tableRows.length === 0) {
    return;
  }

  const [columnRows] = await connection.query(
    `SELECT COLUMN_NAME
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'categories'`,
    [databaseName]
  );
  const existingColumns = new Set(columnRows.map((row) => row.COLUMN_NAME));

  if (!existingColumns.has('sort_order')) {
    await connection.query(
      'ALTER TABLE categories ADD COLUMN sort_order INT NOT NULL DEFAULT 0 AFTER category_image'
    );
    await connection.query('UPDATE categories SET sort_order = id');
    console.log('Category sort order schema added for legacy database.');
  }

  const [indexRows] = await connection.query(
    `SELECT INDEX_NAME
     FROM INFORMATION_SCHEMA.STATISTICS
     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'categories' AND INDEX_NAME = 'idx_categories_sort_order'`,
    [databaseName]
  );

  if (indexRows.length === 0) {
    await connection.query('ALTER TABLE categories ADD INDEX idx_categories_sort_order (sort_order, id)');
  }
};

const ensureProductsSortOrderSchema = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'products'`);
  if (tableRows.length === 0) {
    return;
  }

  const [columnRows] = await connection.query(
    `SELECT COLUMN_NAME
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'products'`,
    [databaseName]
  );
  const existingColumns = new Set(columnRows.map((row) => row.COLUMN_NAME));

  if (!existingColumns.has('sort_order')) {
    await connection.query(
      'ALTER TABLE products ADD COLUMN sort_order INT UNSIGNED NOT NULL DEFAULT 0 AFTER product_image'
    );
    await connection.query('UPDATE products SET sort_order = id');
    console.log('Product sort order schema added for legacy database.');
  }

  const [indexRows] = await connection.query(
    `SELECT INDEX_NAME
     FROM INFORMATION_SCHEMA.STATISTICS
     WHERE TABLE_SCHEMA = ?
       AND TABLE_NAME = 'products'
       AND INDEX_NAME = 'idx_products_category_sort_order'`,
    [databaseName]
  );

  if (indexRows.length === 0) {
    await connection.query(
      'ALTER TABLE products ADD INDEX idx_products_category_sort_order (category_id, sort_order, id)'
    );
  }
};

const ensureBannersSchema = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'banner_images'`);
  if (tableRows.length === 0) {
    return;
  }

  const [columnRows] = await connection.query(
    `SELECT COLUMN_NAME
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'banner_images'`,
    [databaseName]
  );
  const existingColumns = new Set(columnRows.map((row) => row.COLUMN_NAME));
  const alterClauses = [];

  if (!existingColumns.has('name')) {
    alterClauses.push('ADD COLUMN name VARCHAR(255) DEFAULT NULL AFTER id');
  }
  if (!existingColumns.has('link')) {
    alterClauses.push('ADD COLUMN link TEXT DEFAULT NULL AFTER banner_image');
  }
  if (!existingColumns.has('is_active')) {
    alterClauses.push('ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER banner_position');
  }

  if (alterClauses.length > 0) {
    await connection.query(`ALTER TABLE banner_images ${alterClauses.join(', ')}`);
    console.log('Banner schema updated for legacy database.');
  }

  await connection.query(
    `UPDATE banner_images
     SET name = CONCAT('Banner ', id)
     WHERE name IS NULL OR TRIM(name) = ''`
  );
};

const ensureBillingOrdersSchema = async (connection) => {
  const [orderTableRows] = await connection.query(`SHOW TABLES LIKE 'orders'`);
  if (orderTableRows.length > 0) {
    const [orderColumnRows] = await connection.query(
      `SELECT COLUMN_NAME
       FROM INFORMATION_SCHEMA.COLUMNS
       WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'orders'`,
      [databaseName]
    );
    const orderColumns = new Set(orderColumnRows.map((row) => row.COLUMN_NAME));

    if (!orderColumns.has('is_gst_applied')) {
      await connection.query(
        'ALTER TABLE orders ADD COLUMN is_gst_applied TINYINT(1) NOT NULL DEFAULT 0 AFTER notes'
      );
    }
    if (!orderColumns.has('total_gst')) {
      await connection.query(
        'ALTER TABLE orders ADD COLUMN total_gst DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER is_gst_applied'
      );
    }
  }

  const [slotTableRows] = await connection.query(`SHOW TABLES LIKE 'product_slots'`);
  if (slotTableRows.length > 0) {
    const [slotColumnRows] = await connection.query(
      `SELECT COLUMN_NAME
       FROM INFORMATION_SCHEMA.COLUMNS
       WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'product_slots'`,
      [databaseName]
    );
    const slotColumns = new Set(slotColumnRows.map((row) => row.COLUMN_NAME));

    if (!slotColumns.has('is_gst_applied')) {
      await connection.query(
        'ALTER TABLE product_slots ADD COLUMN is_gst_applied TINYINT(1) NOT NULL DEFAULT 0 AFTER qty'
      );
    }
    if (!slotColumns.has('item_gst')) {
      await connection.query(
        'ALTER TABLE product_slots ADD COLUMN item_gst DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER is_gst_applied'
      );
    }
    if (!slotColumns.has('product_gst_rate')) {
      await connection.query(
        'ALTER TABLE product_slots ADD COLUMN product_gst_rate DECIMAL(5,2) NOT NULL DEFAULT 0 AFTER item_gst'
      );
    }
  }
};

const ensureSeoDetailsSchema = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'seo_details'`);
  if (tableRows.length === 0) {
    return;
  }

  const [columnRows] = await connection.query(
    `SELECT COLUMN_NAME
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'seo_details'`,
    [databaseName]
  );

  const existingColumns = new Set(columnRows.map((row) => row.COLUMN_NAME));
  const alterClauses = [];

  if (!existingColumns.has('seo_heading_id')) {
    alterClauses.push('ADD COLUMN seo_heading_id INT DEFAULT NULL AFTER id');
  }
  if (!existingColumns.has('name')) {
    alterClauses.push('ADD COLUMN name VARCHAR(255) DEFAULT NULL AFTER meta_keywords');
  }
  if (!existingColumns.has('description')) {
    alterClauses.push('ADD COLUMN description TEXT DEFAULT NULL AFTER name');
  }
  if (!existingColumns.has('image')) {
    alterClauses.push('ADD COLUMN image VARCHAR(255) DEFAULT NULL AFTER description');
  }
  if (!existingColumns.has('alt_key')) {
    alterClauses.push('ADD COLUMN alt_key VARCHAR(255) DEFAULT NULL AFTER image');
  }
  if (!existingColumns.has('url')) {
    alterClauses.push('ADD COLUMN url VARCHAR(255) DEFAULT NULL AFTER alt_key');
  }
  if (!existingColumns.has('canonical')) {
    alterClauses.push('ADD COLUMN canonical VARCHAR(255) DEFAULT NULL AFTER url');
  }
  if (!existingColumns.has('feet_content')) {
    alterClauses.push('ADD COLUMN feet_content LONGTEXT DEFAULT NULL AFTER canonical');
  }

  if (alterClauses.length > 0) {
    await connection.query(`ALTER TABLE seo_details ${alterClauses.join(', ')}`);
    console.log('SEO details schema updated for legacy database.');
  }

  const [indexRows] = await connection.query(
    `SELECT INDEX_NAME
     FROM INFORMATION_SCHEMA.STATISTICS
     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'seo_details' AND INDEX_NAME = 'idx_seo_details_heading_id'`,
    [databaseName]
  );

  if (indexRows.length === 0) {
    await connection.query('ALTER TABLE seo_details ADD INDEX idx_seo_details_heading_id (seo_heading_id)');
  }

  await connection.query(`
    UPDATE seo_details sd
    INNER JOIN seo_headings sh ON sh.page_name = sd.page_name
    SET sd.seo_heading_id = sh.id
    WHERE sd.seo_heading_id IS NULL
  `);
};

const ensureBlogsSchema = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'blogs'`);
  if (tableRows.length === 0) {
    return;
  }

  const [columnRows] = await connection.query(
    `SELECT COLUMN_NAME
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'blogs'`,
    [databaseName]
  );

  const existingColumns = new Set(columnRows.map((row) => row.COLUMN_NAME));
  const alterClauses = [];

  if (!existingColumns.has('meta_description')) {
    alterClauses.push('ADD COLUMN meta_description TEXT DEFAULT NULL AFTER meta_title');
    existingColumns.add('meta_description');
  }

  if (!existingColumns.has('meta_keywords')) {
    if (existingColumns.has('meta_description')) {
      alterClauses.push('ADD COLUMN meta_keywords TEXT DEFAULT NULL AFTER meta_description');
    } else {
      alterClauses.push('ADD COLUMN meta_keywords TEXT DEFAULT NULL AFTER meta_title');
    }
  }

  if (alterClauses.length > 0) {
    await connection.query(`ALTER TABLE blogs ${alterClauses.join(', ')}`);
    console.log('Blogs schema updated for legacy database.');
  }
};

const ensureContactEnquiriesSchema = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'contact_enquiries'`);

  if (tableRows.length === 0) {
    await connection.query(`
      CREATE TABLE contact_enquiries (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        message TEXT NOT NULL,
        is_read TINYINT(1) NOT NULL DEFAULT 0,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_contact_enquiries_is_read_created_at (is_read, created_at)
      )
    `);
    console.log('Contact enquiries table created.');
    return;
  }

  const [columnRows] = await connection.query(
    `SELECT COLUMN_NAME
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'contact_enquiries'`,
    [databaseName]
  );
  const existingColumns = new Set(columnRows.map((row) => row.COLUMN_NAME));

  if (!existingColumns.has('is_read')) {
    await connection.query(
      'ALTER TABLE contact_enquiries ADD COLUMN is_read TINYINT(1) NOT NULL DEFAULT 0 AFTER message'
    );
    console.log('Contact enquiry read status column added for legacy database.');
  }

  const [indexRows] = await connection.query(
    `SELECT INDEX_NAME
     FROM INFORMATION_SCHEMA.STATISTICS
     WHERE TABLE_SCHEMA = ?
       AND TABLE_NAME = 'contact_enquiries'
       AND INDEX_NAME = 'idx_contact_enquiries_is_read_created_at'`,
    [databaseName]
  );

  if (indexRows.length === 0) {
    await connection.query(
      'ALTER TABLE contact_enquiries ADD INDEX idx_contact_enquiries_is_read_created_at (is_read, created_at)'
    );
  }
};

const ensureStoreConfigSchema = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'store_config'`);
  if (tableRows.length > 0) {
    return;
  }

  await connection.query(`
    CREATE TABLE store_config (
      id INT AUTO_INCREMENT PRIMARY KEY,
      is_store_open TINYINT(1) DEFAULT 1,
      min_order_value DECIMAL(10, 2) DEFAULT 2000.00,
      global_discount DECIMAL(5, 2) DEFAULT 0.00,
      off_banner_image VARCHAR(255) DEFAULT NULL,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
  `);

  let isStoreOpen = 1;
  let minimumOrderValue = 2000;
  let globalDiscount = 0;
  let offBannerImage = null;

  const [pageOffTableRows] = await connection.query(`SHOW TABLES LIKE 'page_off'`);
  if (pageOffTableRows.length > 0) {
    const [pageOffRows] = await connection.query(
      'SELECT status, image FROM page_off ORDER BY id ASC LIMIT 1'
    );
    isStoreOpen = Number(pageOffRows[0]?.status ?? isStoreOpen);
    offBannerImage = pageOffRows[0]?.image || null;
  }

  const [homeSettingsTableRows] = await connection.query(`SHOW TABLES LIKE 'home_settings'`);
  if (homeSettingsTableRows.length > 0) {
    const [homeSettingsRows] = await connection.query(
      'SELECT min_order_value FROM home_settings ORDER BY id ASC LIMIT 1'
    );
    minimumOrderValue = Number(homeSettingsRows[0]?.min_order_value ?? minimumOrderValue);
  }

  const [discountTableRows] = await connection.query(`SHOW TABLES LIKE 'discounts'`);
  if (discountTableRows.length > 0) {
    const [discountRows] = await connection.query(
      'SELECT discount FROM discounts ORDER BY id DESC LIMIT 1'
    );
    globalDiscount = Number(discountRows[0]?.discount ?? globalDiscount);
  }

  await connection.query(
    `INSERT INTO store_config
      (is_store_open, min_order_value, global_discount, off_banner_image)
     VALUES (?, ?, ?, ?)`,
    [isStoreOpen, minimumOrderValue, globalDiscount, offBannerImage]
  );

  console.log('Store config table created for legacy database.');
};

const ensureSettingsDefaults = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'settings'`);
  if (tableRows.length === 0) {
    return;
  }

  const settingsDefaults = [
    ['company_name', 'Sparkle Fireworks', 'brand'],
    ['seo_title', 'Sparkle Fireworks | Best Crackers Online', 'brand'],
    ['main_logo', '', 'brand'],
    ['favicon', '', 'brand'],
    ['primary_phone', '+91 98765 43210', 'contact'],
    ['email', 'support@sparklefireworks.com', 'contact'],
    ['address', '123 Sparkle Street, Sivakasi, Tamil Nadu, India', 'contact'],
    ['whatsapp_number', '', 'contact'],
    ['footer_content', '', 'contact'],
    ['facebook_url', '', 'social'],
    ['instagram_url', '', 'social'],
    ['twitter_url', '', 'social'],
    ['linkedin_url', '', 'social'],
    ['youtube_url', '', 'social'],
    ['offer_text_html', '', 'seo'],
    ['contact_intro_eyebrow', 'Contact Us', 'contact_page'],
    ['contact_intro_heading', 'Have Any Questions?', 'contact_page'],
    ['contact_intro_description_html', '<p>Have an inquiry or some feedback for us? Use the form below to contact our team.</p>', 'contact_page'],
    ['contact_map_iframe_html', '', 'contact_page'],
    ['hero_eyebrow', 'WELCOME TO SPARKLE', 'homepage'],
    ['hero_heading_html', '', 'homepage'],
    ['hero_description_html', '<p>Since 2026, <strong>The Bluvel Crackers</strong> has been the No.1 destination for all your celebration needs.</p><p>Whether you are planning a grand festival, a joyous event, or an intimate gathering, we have the perfect crackers to make it unforgettable.</p>', 'homepage'],
    ['hero_badge_1_text', 'Trustable Crackers Shop In Sivakasi', 'homepage'],
    ['hero_badge_2_text', '80% Off Sale', 'homepage'],
    ['hero_badge_3_text', 'Free Shipping ₹3000+', 'homepage'],
    ['hero_section_image', '', 'homepage'],
    ['hero_cta_text', 'Read More About Bluvel Crackers', 'homepage'],
    ['hero_cta_link', '/about', 'homepage'],
    ['featured_products_eyebrow', 'Our Best HandPicked Products', 'homepage'],
    ['featured_products_heading', 'Don\'t Miss This Products', 'homepage'],
    ['featured_product_ids', '[]', 'homepage'],
    ['why_choose_eyebrow', 'Our Promise', 'homepage'],
    ['why_choose_title', 'Why Choose Us', 'homepage'],
    ['why_choose_subtitle', 'Built on quality, value, and trust.', 'homepage'],
    ['why_choose_pillar_1_title', 'Best Quality', 'homepage'],
    ['why_choose_pillar_1_text', 'Every cracker is sourced directly from trusted manufacturers.', 'homepage'],
    ['why_choose_pillar_2_title', 'Wide Variety', 'homepage'],
    ['why_choose_pillar_2_text', 'From sparklers to aerial shells, our catalogue covers every celebration.', 'homepage'],
    ['why_choose_pillar_3_title', 'Safety First', 'homepage'],
    ['why_choose_pillar_3_text', 'All products meet government guidelines and safety expectations.', 'homepage'],
    ['why_choose_pillar_4_title', 'Trusted Brand', 'homepage'],
    ['why_choose_pillar_4_text', 'Thousands of happy customers rely on us season after season.', 'homepage'],
    ['why_choose_stat_1_label', 'Availability', 'homepage'],
    ['why_choose_stat_1_value', '100', 'homepage'],
    ['why_choose_stat_2_label', 'Best Delivery', 'homepage'],
    ['why_choose_stat_2_value', '100', 'homepage'],
    ['why_choose_stat_3_label', 'Easy Ordering', 'homepage'],
    ['why_choose_stat_3_value', '100', 'homepage'],
    ['why_choose_stat_4_label', 'Customer Support', 'homepage'],
    ['why_choose_stat_4_value', '100', 'homepage'],
    ['why_choose_bottom_1_value', '5000+', 'homepage'],
    ['why_choose_bottom_1_label', 'Happy Customers', 'homepage'],
    ['why_choose_bottom_2_value', '200+', 'homepage'],
    ['why_choose_bottom_2_label', 'Products', 'homepage'],
    ['why_choose_bottom_3_value', '80%', 'homepage'],
    ['why_choose_bottom_3_label', 'Max Discount', 'homepage'],
    ['why_choose_bottom_4_value', 'Pan India', 'homepage'],
    ['why_choose_bottom_4_label', 'Delivery', 'homepage'],
    ['bank_holder', 'Sparkle Fireworks Pvt Ltd', 'payment'],
    ['bank_account', '0000111122223333', 'payment'],
    ['bank_name', 'HDFC Bank', 'payment'],
    ['bank_ifsc', 'HDFC0001234', 'payment'],
    ['bank_branch', 'Sivakasi Main', 'payment'],
    ['gpay_label', 'Google Pay', 'payment'],
    ['gpay_number', '+91 9876543210', 'payment'],
    ['phonepe_label', 'PhonePe', 'payment'],
    ['phonepe_number', '+91 9876543210', 'payment'],
    ['payment_instructions_html', '<p>After successful payment, please send the screenshot to our Whatsapp number.</p>', 'payment'],
    ['gpay_qr_image', '', 'payment'],
    ['phonepe_qr_image', '', 'payment'],
    ['payment_page_title', 'Payment Information', 'payment'],
    ['payment_page_heading_html', '<p>Please select an option to pay</p>', 'payment'],
  ];

  for (const [key, value, group] of settingsDefaults) {
    await connection.query(
      'INSERT IGNORE INTO settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?)',
      [key, value, group]
    );
  }
};

const ensureDefaultAdmin = async (connection) => {
  const [tableRows] = await connection.query(`SHOW TABLES LIKE 'admin_users'`);
  if (tableRows.length === 0) {
    return;
  }

  const [adminRows] = await connection.query('SELECT COUNT(*) AS count FROM admin_users');
  if (adminRows[0].count > 0) {
    return;
  }

  await connection.query(
    'INSERT INTO admin_users (name, email, password, role) VALUES (?, ?, ?, ?)',
    [
      'System Admin',
      'admin@annapoorani.com',
      '$2a$10$4bONZNynDE7pTLECbJLw8epOe.6cNJn.Qbr5ioepT82nZEurcf8rO',
      'admin',
    ]
  );
  console.log('Default admin user created: admin@annapoorani.com');
};

const initializeDatabase = async () => {
  let connection;
  try {
    await ensureDatabaseExists();
    connection = await pool.getConnection();
    console.log('MySQL connected successfully. Database:', databaseName);
    await ensureBaseSchema(connection);
    await ensureCategoriesSchema(connection);
    await ensureProductsSortOrderSchema(connection);
    await ensureBannersSchema(connection);
    await ensureBillingOrdersSchema(connection);
    await ensureSeoDetailsSchema(connection);
    await ensureBlogsSchema(connection);
    await ensureContactEnquiriesSchema(connection);
    await ensureStoreConfigSchema(connection);
    await ensureSettingsDefaults(connection);
    await ensureDefaultAdmin(connection);
  } catch (error) {
    console.error('MySQL connection failed:', error.message);
    console.error('Make sure MySQL is running and the database exists.');
    console.error(`Run: mysql -u root -e "CREATE DATABASE IF NOT EXISTS ${databaseName};"`);
    throw error;
  } finally {
    connection?.release();
  }
};

pool.ready = initializeDatabase();
pool.databaseName = databaseName;

module.exports = pool;
