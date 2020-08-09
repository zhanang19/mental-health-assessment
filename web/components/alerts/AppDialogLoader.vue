<template>
  <div>
    <v-dialog v-model="loading" :persistent="!dismissable" :max-width="maxWidth">
      <v-card>
        <v-toolbar color="transparent" width="100%" absolute flat>
          <v-toolbar-title></v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn v-if="dismissable" @click="loading = !loading" icon>
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text class="d-flex justify-center align-center fill-height">
          <div class="text-center pa-4 mt-1">
            <div 
              class="text-center headline mb-2" 
              v-text="message"
            ></div>
            <v-progress-circular
              indeterminate
              color="primary"
              :size="size"
            ></v-progress-circular>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapFields } from 'vuex-map-fields'

export default {
  computed: {
    ...mapFields([
      'loader.loading',
      'loader.dismissable'
    ])
  },
  
  props: {
    maxWidth: {
      type: String,
      default: () => '250'
    },

    message: {
      type: String,
      default: () => 'Loading...'
    },
    
    size: {
      type: String,
      default: () => '32'
    }
  }
}
</script>

<style lang="sass" scoped>
$dialog-elevation: 0
</style>