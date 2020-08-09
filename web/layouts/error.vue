<template>
  <v-main app>
    <v-container fill-height>
      <v-row justify="center" align="center">
        <v-col>
          <v-card-text>
            <div class="text-center">
              <img src="/errors/void.svg" class="mb-5" style="height: 40vh" width="60%" />
              <p v-if="error.statusCode === 404">The page you are requesting doesn't exist.</p>
              <p v-else>Sorry. An error has occured.</p>
              <v-btn large @click="$router.go(-1)" text>
                <v-icon left>mdi-arrow-left</v-icon>
                GO BACK
              </v-btn>
            </div>
          </v-card-text>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
export default {
  props: {
    error: {
      type: Object,
      default: null
    }
  },

  data () {
    return {
      pageNotFound: '404 Not Found',
      otherError: 'An error occurred'
    }
  },

  head () {
    const title =
      this.error.statusCode === 404 ? this.pageNotFound : this.otherError
    return {
      title
    }
  }
}
</script>

<style scoped>
h1 {
  font-size: 20px;
}
</style>
