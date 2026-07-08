const mysql = require('mysql2/promise');

async function migrate() {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    database: 'crackers_db',
    password: ''
  });

  try {
    console.log("Checking if is_product_gst_active column exists in products table...");
    const [columns] = await connection.query("SHOW COLUMNS FROM products LIKE 'is_product_gst_active'");
    if (columns.length === 0) {
      console.log("Adding is_product_gst_active column...");
      await connection.query("ALTER TABLE products ADD COLUMN is_product_gst_active TINYINT(1) DEFAULT 1 AFTER product_gst");
      console.log("Column added successfully!");
    } else {
      console.log("Column already exists.");
    }
  } catch (error) {
    console.error("Migration error:", error);
  } finally {
    await connection.end();
  }
}

migrate();
