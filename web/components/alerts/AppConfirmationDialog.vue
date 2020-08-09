<template>
  <div>
    <v-dialog 
      transition="scroll-y-transition"
      @input="onChange($event)"
      :value="value"
      :max-width="maxWidth"
      ref="dialog"
      persistent
      scrollable>
      <v-card>
        <v-toolbar color="transparent" flat>
          <v-toolbar-title v-text="title"></v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn 
            elevation="1"
            @click="toggle()"
            small
            fab>
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text class="text-center">
          <slot name="illustration">
            <v-slide-x-transition hide-on-leave>
              <img 
                v-if="!action.confirmed"
                src="/illustrations/alerts/warning.svg" 
                height="250" 
                width="70%" 
                alt="warning svg">
              <img 
                v-else
                src="/illustrations/alerts/confirmed.svg" 
                height="250" 
                width="70%" 
                alt="confirmed svg">
            </v-slide-x-transition>
          </slot>
          <div>
            <slot v-if="!action.confirmed" name="confirmation-text">
              Please confirm before we proceed dispatching your action.
            </slot>
            <slot v-else name="confirmed-text">
              You have confirmed your action! Dispatching...
            </slot>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn 
            @click="toggle()"
            width="125"
            :disabled="action.confirmed"
            class="primary--text"
            large
            depressed>
            CANCEL
          </v-btn>
          <v-btn 
            @click="confirmed()"
            width="125"
            :disabled="action.confirmed"
            :color="btnColor"
            large
            depressed>
            CONFIRM
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data: () => ({
    action: {
      confirmed: false
    }
  }),
  
  props: {
    title: String,
    
    value: {
      type: Boolean,
      default: false,
    },

    maxWidth: {
      type: [Number, String],
      default: 400,
    },

    loading: {
      type: Boolean,
      default: false
    },

    btnColor: {
      type: String,
      default: () => 'primary'
    }
  },

  methods: {
    onUpdate () {
      this.$emit('update-user', true)
    },
    
    onChange (e) {
      this.$emit('input', e)
    },

    toggle () {
      this.$emit('input', !this.$refs.dialog.value)
    },

    async confirmed () {
      this.action.confirmed = true
      await setTimeout(() => {
        this.$emit('confirmed', true)
        
        setTimeout(() => this.action.confirmed = false, 1000)
      }, 1000)
    }
  },
}
</script>