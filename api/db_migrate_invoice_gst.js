const mysql = require('mysql2/promise');

async function migrate() {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    database: 'crackers_db',
    password: ''
  });

  try {
    console.log("Checking orders table for GST columns...");
    const [ordersCols] = await connection.query("SHOW COLUMNS FROM orders LIKE 'is_gst_applied'");
    if (ordersCols.length === 0) {
      await connection.query("ALTER TABLE orders ADD COLUMN is_gst_applied TINYINT(1) DEFAULT 0");
      await connection.query("ALTER TABLE orders ADD COLUMN total_gst DECIMAL(10,2) DEFAULT 0");
      console.log("Added is_gst_applied and total_gst to orders");
    } else {
      console.log("GST columns already exist in orders");
    }

    console.log("Checking product_slots table for GST columns...");
    const [slotsCols] = await connection.query("SHOW COLUMNS FROM product_slots LIKE 'is_gst_applied'");
    if (slotsCols.length === 0) {
      await connection.query("ALTER TABLE product_slots ADD COLUMN is_gst_applied TINYINT(1) DEFAULT 0");
      await connection.query("ALTER TABLE product_slots ADD COLUMN item_gst DECIMAL(10,2) DEFAULT 0");
      await connection.query("ALTER TABLE product_slots ADD COLUMN product_gst_rate DECIMAL(5,2) DEFAULT 0");
      console.log("Added is_gst_applied, item_gst, product_gst_rate to product_slots");
    } else {
      console.log("GST columns already exist in product_slots");
    }

    console.log("Migration successful.");
  } catch (error) {
    console.error("Migration error:", error);
  } finally {
    await connection.end();
  }
}

migrate();
