const { clearFrontendCache } = require('../utils/frontendCache');

const MUTATION_METHODS = new Set(['POST', 'PUT', 'PATCH', 'DELETE']);
const FRONTEND_DATA_PATH = /^\/(?:banners|categories|products|settings|charges)(?:\/|$)/i;

const invalidateFrontendCache = (req, res, next) => {
  if (!MUTATION_METHODS.has(req.method) || !FRONTEND_DATA_PATH.test(req.path)) {
    return next();
  }

  res.once('finish', () => {
    if (res.statusCode >= 200 && res.statusCode < 400) {
      clearFrontendCache().catch((error) => {
        console.error('Unable to invalidate frontend cache:', error.message);
      });
    }
  });

  return next();
};

module.exports = invalidateFrontendCache;
