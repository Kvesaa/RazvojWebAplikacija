export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      apiBase: 'https://5e41-77-77-217-199.ngrok-free.app/', // Your Laravel backend URL
    },
  },
  devtools: { enabled: true },
  compatibilityDate: '2025-05-15',
})
