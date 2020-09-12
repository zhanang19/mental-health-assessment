<template>
  <v-tooltip top>
    <template #activator="{ on, attrs }">
      <v-btn
        style="z-index: 999"
        v-on="on"
        v-bind="attrs"
        @click="$router.back()"
        class="primary--text"
        elevation="10"
        bottom
        left
        fixed
        rounded
        x-large
      >
        <v-icon left>mdi-arrow-left</v-icon>
        <span>Back</span>
      </v-btn>
    </template>
    <span>Go back</span>
  </v-tooltip>
</template>
