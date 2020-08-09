<template>
  <div>
    
  </div>
</template>

<script>
import AppPrimaryNavigationDrawer from '@/components/layouts/AppPrimaryNavigationDrawer'
import { mapGetters } from 'vuex'
import { mapFields } from 'vuex-map-fields'

export default {
  components: {
    AppPrimaryNavigationDrawer,
  },
  
  data: () => ({
    _layout: 'classic'
  }),
  
  props: {
    color: {
      type: String,
      default: () => 'blue-grey darken-4',
    },

    dark: {
      type: Boolean,
      default: () => true,
    },

    toolbarColor: {
      type: String,
      default: () => 'primary',
    },

    toolbarDark: {
      type: Boolean,
      default: () => true,
    }
  },

  created () {
    this.initLayout()
  },

  methods: {
    initLayout () {
      this._layout = localStorage.getItem('preferences.layout') || 'classic'
    },
    
    toggleLayout (layout) {
      this._layout = layout
      console.log(this._layout)
      localStorage.setItem('preferences.layout', layout)
      window.location.reload()
    },
  },

  computed: {
    ...mapFields([
      'drawer'
    ])
  },
}
</script>