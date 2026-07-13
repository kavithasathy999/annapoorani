const pool = require('../config/db');

const FRONTEND_CACHE_KEY_PATTERNS = [
  '%-cache-home.%',
  '%-cache-estimate.%',
  '%-cache-layout.%',
  '%-cache-about.%',
  '%-cache-legal.%',
  '%-cache-locations.%',
  '%-cache-seo.%',
];

const clearMatchingTableKeys = async (tableName) => {
  const conditions = FRONTEND_CACHE_KEY_PATTERNS.map(() => '`key` LIKE ?').join(' OR ');
  await pool.query(
    `DELETE FROM \`${tableName}\` WHERE ${conditions}`,
    FRONTEND_CACHE_KEY_PATTERNS
  );
};

const clearFrontendCache = async () => {
  try {
    await clearMatchingTableKeys('cache');
    await clearMatchingTableKeys('cache_locks');
  } catch (error) {
    if (error.code === 'ER_NO_SUCH_TABLE') {
      return;
    }
    throw error;
  }
};

module.exports = { clearFrontendCache };
