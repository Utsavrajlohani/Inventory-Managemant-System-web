// Minimal bootstrap for frontend dependencies (placeholder)
// Use dynamic import to avoid top-level import errors when npm isn't installed.
(function () {
  if (typeof window === 'undefined') return;
  import('axios')
    .then((mod) => {
      const axios = mod.default || mod;
      window.axios = axios;
      if (window.axios && window.axios.defaults) {
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
      }
    })
    .catch(() => {
      // axios not available — fine for stripped-down environments
    });
})();
