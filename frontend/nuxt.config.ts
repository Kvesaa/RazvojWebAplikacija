export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      apiBase: 'http://127.0.0.1:8000/api/v1',
      basicAuth: 'basic_user@example.com:basic_pass',
    },
  },
  devtools: { enabled: false },
  nitro: {
    compatibilityDate: '2025-09-14',
  },
  css: ['~/assets/css/global.css'],
})