<template>
  <div>
    <v-navigation-drawer
      ref="drawer"
      @input="onInput($event)"
      :value="value"
      :width="width"
      hide-overlay
      floating
      temporary
      right
      app
    >
      <slot></slot>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      default: false,
    },

    width: {
      type: [Number, String],
      default: 500,
    },
  },

  methods: {
    /**
     * @param { Event } event
     */
    onInput(event) {
      this.$emit("input", event);
      console.log("[AppRightDrawer] onInput", event);

      if (!event) {
        this.$emit("closed", event);
      }
    },
  },
};
</script>