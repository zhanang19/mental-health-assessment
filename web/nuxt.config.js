import colors from 'vuetify/es5/util/colors'

// your app title
const title = 'CMS'

// your API baseURL
const baseURL = 'http://localhost:8000'

export default {
  /*
  ** Nuxt rendering mode
  ** See https://nuxtjs.org/api/configuration-mode
  */
  mode: 'spa',
  /*
  ** Nuxt target
  ** See https://nuxtjs.org/api/configuration-target
  */
  target: 'static',
  /*
  ** Headers of the page
  ** See https://nuxtjs.org/api/configuration-head
  */
  head: {
    title,
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: process.env.npm_package_description || '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' }
    ]
  },
  /*
  ** Customize the progress-bar color
  */
  // loading: '~/components/loading.vue',
  loading: { 
    height: '3px',
    color: colors.blue.darken2,
    throttle: 0,
    continuous: true,
  },

  loadingIndicator: '~/loading/app.html',
  // loadingIndicator: {
  //   name: 'cube-grid',
  //   color: 'white',
  //   background: '#2B9CAE'
  // },
  /*
  ** Global CSS
  */
  css: [
    '@/assets/app.css',
    '@/assets/fonts/google-sans/style.css'
  ],
  /*
  ** Plugins to load before mounting the App
  ** https://nuxtjs.org/guide/plugins
  */
  plugins: [
    { src: '@/plugins/mdi' },
    { src: '@/plugins/main' },
    { src: '@/plugins/helpers' },
  ],
  /*
  ** Auto import components
  ** See https://nuxtjs.org/api/configuration-components
  */
  components: true,
  /*
  ** Nuxt.js dev-modules
  */
  buildModules: [
    '@nuxtjs/vuetify',
  ],
  /*
  ** Nuxt.js modules
  */
  modules: [
    // Doc: https://axios.nuxtjs.org/usage
    '@nuxtjs/auth',
    '@nuxtjs/axios',
    '@nuxtjs/pwa',
  ],
  /*
  ** Axios module configuration
  ** See https://axios.nuxtjs.org/options
  */
  axios: {
    baseURL
  },
  /*
  ** Auth module configuration
  ** See https://auth.nuxtjs.org/
  */
  auth: {
    strategies: {
      local: {
        endpoints: {
          login: { url: '/api/auth/login', method: 'post', propertyName: 'access_token' },
          logout: { url: '/api/auth/logout', method: 'get' },
          user: { url: '/api/auth/user', method: 'get', propertyName: false }
        },
        tokenType: 'Bearer',
        autoFetchUser: true
      }
    },

    redirect: {
      login: '/',
      logout: '/',
      callback: '/',
      home: '/home',
    }
  },

  router: {
    middleware: ['auth'],
  },
  /*
  ** vuetify module configuration
  ** https://github.com/nuxt-community/vuetify-module
  */
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    treeShake: true,
    options: {
      customProperties: true
    },
    theme: {
      dark: false,
      themes: {
        light: {
          primary: colors.indigo,
        },
        dark: {
          primary: colors.indigo,
        },
      }
    }
  },

  /*
  ** PWA Module
  ** See https://github.com/nuxt-community/pwa-module
  */
  manifest: {
    name: 'My App',
    short_name: 'My App',
    description: 'My awesome Nuxt PWA project.',
    display: 'fullscreen'
  },
  /*
  ** Build configuration
  ** See https://nuxtjs.org/api/configuration-build/
  */
  build: {
  }
}
