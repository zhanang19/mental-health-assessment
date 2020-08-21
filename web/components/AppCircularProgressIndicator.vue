<template>
  <div>
    <v-card-text class="d-flex justify-center align-center fill-height">
      <div class="text-center pa-4 mt-1">
        <v-progress-circular indeterminate :color="colorTheme === 'white' ? 'primary' : 'white'"></v-progress-circular>
      </div>
    </v-card-text>
  </div>
</template>

<script>
export default {
  props: {
    colorTheme: {
      type: String,
      required: true,
    },
  },
};
</script>
