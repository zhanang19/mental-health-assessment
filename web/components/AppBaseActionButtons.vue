<template>
  <div>
    <v-tooltip v-for="(button, index) in filteredActionButtons" :key="index" bottom>
      <template #activator="{ on, attrs }">
        <v-btn
          v-on="on"
          v-bind="attrs"
          class="mx-1"
          @click="$emit(button.event)"
          elevation="4"
          fab
          small
        >
          <v-icon color="primary">{{ button.icon }}</v-icon>
        </v-btn>
      </template>
      <span>{{ button.tooltip }}</span>
    </v-tooltip>
  </div>
</template>

<script>
const actionButtons = [
  {
    type: "non-archive",
    tooltip: "View",
    icon: "mdi-eye-outline",
    event: "click-view",
  },
  {
    type: "non-archive",
    tooltip: "Edit",
    icon: "mdi-pencil-outline",
    event: "click-edit",
  },
  {
    type: "non-archive",
    tooltip: "Delete",
    icon: "mdi-delete-outline",
    event: "click-delete",
  },
  {
    type: "archive",
    tooltip: "Restore",
    icon: "mdi-restore",
    event: "click-restore",
  },
  {
    type: "archive",
    tooltip: "Delete Permanently",
    icon: "mdi-delete-forever-outline",
    event: "click-delete-permanently",
  },
];

export default {
  data: () => ({
    actionButtons,
  }),

  props: {
    type: {
      type: String,
      default: () => "non-archive",
      required: true,
      validator: (value) => {
        return ["non-archive", "archive"].indexOf(value) !== -1;
      },
    },
  },

  computed: {
    filteredActionButtons() {
      return this.actionButtons.filter((button) => button.type === this.type);
    },
  },
};
</script>
