export const state = () => ({
  timezones: [],
})

export const mutations = {
  SET_TIMEZONES: (state, payload) => 
    state.timezones = payload,
}

export const actions = {
  /**
   * Fetch all resources.
   * 
   * @param { Object } context 
   */
  async fetchAll({ commit }) {
    try {
      const data = await this.$axios.$get('/api/timezones')

      commit('SET_TIMEZONES', data)
    } catch (error) {
      console.log(error)
      return await this.$helpers.notify({
        type: 'error',
        message: 'Unable to retrieve data.'
      })
    }
  },
}