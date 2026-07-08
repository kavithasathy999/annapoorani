const mysql = require('mysql2/promise');

async function migrate() {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    database: 'crackers_db',
    password: ''
  });

  try {
    console.log("Checking home_settings...");
    const [cols1] = await connection.query("SHOW COLUMNS FROM home_settings LIKE 'global_gst'");
    if (cols1.length === 0) {
      await connection.query("ALTER TABLE home_settings ADD COLUMN global_gst DECIMAL(5,2) DEFAULT 0");
      console.log("Added global_gst to home_settings");
    } else {
      console.log("global_gst already exists in home_settings");
    }

    console.log("Checking products...");
    const [cols2] = await connection.query("SHOW COLUMNS FROM products LIKE 'product_gst'");
    if (cols2.length === 0) {
      await connection.query("ALTER TABLE products ADD COLUMN product_gst DECIMAL(5,2) DEFAULT NULL");
      console.log("Added product_gst to products");
    } else {
      console.log("product_gst already exists in products");
    }

  } catch (error) {
    console.error("Migration error:", error);
  } finally {
    await connection.end();
  }
}

migrate();
