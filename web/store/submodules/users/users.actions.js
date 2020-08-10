export const actions = {
  /**
   * Fetch all resources from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   * @usage this.$store.dispatch('users/FETCH_ALL')
   */
  'FETCH_ALL': async ({ dispatch, state, commit }, payload) => {
    console.log('[Users] fetch users', payload)

    try {
      const response = await $nuxt.$axios.$get('/api/users')

      await commit('SET_STATE', {
        field: 'users',
        data: response.data
      })
    } catch (error) {
      console.log(error)
      let message
      if (error.response.status >= 403) {
        message = error.response.data.message
      }

      await $nuxt.$helpers.notify({
        type: 'error',
        message: message || 'Unknown error.'
      })
    }
  },

  /**
   * Fetch a single resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   * @usage this.$store.dispatch('users/FETCH', {
   *  id: item.id | $route.params.id
   * })
   */
  'FETCH': async ({ dispatch, state, commit }, payload) => {
    console.log('[Users] fetch user', payload)

    try {

      await $nuxt.$helpers.notify({
        type: 'success',
        message: response.message || 'No message.'
      })
    } catch (error) {
      let message
      if (error.response.status >= 403) {
        message = error.response.data.message
      }

      await $nuxt.$helpers.notify({
        type: 'error',
        message: message || 'Unknown error.'
      })
    }
  },

  /**
   * Request to create a new record in API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   * @usage this.$store.dispatch('users/ADD', {
   *  data: this.form
   * })
   */
  'ADD': async ({ dispatch, state, commit }, payload) => {
    console.log('[Users] add user', payload)

    try {

      await $nuxt.$helpers.notify({
        type: 'success',
        message: response.message || 'No message.'
      })
    } catch (error) {
      let message
      if (error.response.status >= 403) {
        message = error.response.data.message
      }

      await $nuxt.$helpers.notify({
        type: 'error',
        message: message || 'Unknown error.'
      })
    }
  },

  /**
   * Request to update an existing record from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   * @usage this.$store.dispatch('users/UPDATE', {
   *  data: this.form
   * })
   */
  'UPDATE': async ({ dispatch, state, commit }, payload) => {
    console.log('[Users] update user', payload)

    try {

      await $nuxt.$helpers.notify({
        type: 'success',
        message: response.message || 'No message.'
      })
    } catch (error) {
      let message
      if (error.response.status >= 403) {
        message = error.response.data.message
      }

      await $nuxt.$helpers.notify({
        type: 'error',
        message: message || 'Unknown error.'
      })
    }
  },

  /**
   * Delete a resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   * @usage this.$store.dispatch('users/DELETE', {
   *  id: item.id | $route.params.id
   * })
   */
  'DELETE': async ({ dispatch, state, commit }, payload) => {
    console.log('[Users] delete user', payload)

    try {

      await $nuxt.$helpers.notify({
        type: 'success',
        message: response.message || 'No message.'
      })
    } catch (error) {
      let message
      if (error.response.status >= 403) {
        message = error.response.data.message
      }

      await $nuxt.$helpers.notify({
        type: 'error',
        message: message || 'Unknown error.'
      })
    }
  },

  /**
   * Restore a deleted resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   * @usage this.$store.dispatch('users/RESTORE', {
   *  id: item.id | $route.params.id
   * })
   */
  'RESTORE': async ({ dispatch, state, commit }, payload) => {
    console.log('[Users] restore user', payload)

    try {

      await $nuxt.$helpers.notify({
        type: 'success',
        message: response.message || 'No message.'
      })
    } catch (error) {
      let message
      if (error.response.status >= 403) {
        message = error.response.data.message
      }

      await $nuxt.$helpers.notify({
        type: 'error',
        message: message || 'Unknown error.'
      })
    }
  },

  /**
   * Permanently delete a resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   * @usage this.$store.dispatch('users/PERMANENTLY_DELETE', {
   *  id: item.id | $route.params.id
   * })
   */
  'PERMANENTLY_DELETE': async ({ dispatch, state, commit }, payload) => {
    console.log('[Users] permanently user', payload)

    try {

      await $nuxt.$helpers.notify({
        type: 'success',
        message: response.message || 'No message.'
      })
    } catch (error) {
      let message
      if (error.response.status >= 403) {
        message = error.response.data.message
      }

      await $nuxt.$helpers.notify({
        type: 'error',
        message: message || 'Unknown error.'
      })
    }
  },
}
