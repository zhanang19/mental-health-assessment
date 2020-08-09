<template>
  <div>
    <v-snackbar
      :elevation="elevation"
      :transition="transition"
      :color="$vuetify.theme.dark ? 'dark' : color"
      :bottom="bottom"
      :top="top"
      :right="right"
      :left="left"
      :timeout="timeout"
      :centered="centered"
      rounded="lg"
      v-model="show"
    >
      <v-icon
        size="32"
        :color="type == 'success' 
          ? 'success' 
          : type == 'error'
          ? 'error'
          : type == 'info' 
          ? 'blue' 
          : '' "
        v-text="type == 'success' 
          ? 'mdi-check-circle' 
          : type == 'error'
          ? 'mdi-alert-circle'
          : type == 'info' 
          ? 'mdi-alert-circle-outline' 
          : '' "
        left
      ></v-icon>
      <span :class="$vuetify.theme.dark ? 'white--text' : 'black--text'" v-text="message"></span>

      <template v-slot:action="{ attrs }">
        <v-btn v-bind="attrs" @click="show = false" text>
          <span :class="$vuetify.theme.dark ? 'white--text' : 'black--text'">CLOSE</span>
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import { mapFields } from "vuex-map-fields";
export default {
  computed: {
    ...mapFields("alerts", [
      "position.bottom",
      "position.top",
      "position.right",
      "position.left",
      "show",
      "message",
      "color",
      "type",
      "timeout",
      "transition",
      "elevation",
      "centered",
    ]),
  },
};
</script>