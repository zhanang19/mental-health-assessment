<template>
  <div>
    <v-toolbar color="transparent" flat>
      <v-text-field
        v-model="search"
        single-line
        hide-details
        placeholder="Filter by string matching"
      ></v-text-field>
      <v-toolbar-title></v-toolbar-title>
      <v-spacer></v-spacer>
      <v-tooltip v-if="showCreateButton" bottom>
        <template #activator="{ on, attrs }">
          <v-btn
            v-on="on"
            v-bind="attrs"
            @click="$emit('click-create')"
            color="primary"
            width="150"
            depressed
            rounded
            x-large
          >
            <span>CREATE</span>
            <v-icon right>mdi-plus</v-icon>
          </v-btn>
        </template>
        <span>Create new record</span>
      </v-tooltip>
    </v-toolbar>
    <v-card-text>
      <v-data-table :search="search" :headers="headers" :items="items" multi-sort>
        <template #item.actions="{ item }">
          <v-tooltip v-for="(button, index) in filteredActionButtons" :key="index" bottom>
            <template #activator="{ on, attrs }">
              <v-btn
                v-on="on"
                v-bind="attrs"
                class="mx-1"
                @click="$emit(button.event, item)"
                elevation="1"
                small
                fab
              >
                <v-icon>{{ button.icon }}</v-icon>
              </v-btn>
            </template>
            <span>{{ button.tooltip }}</span>
          </v-tooltip>
        </template>
      </v-data-table>
    </v-card-text>
  </div>
</template>

<script>
export default {
  data: () => ({
    search: "",
    actionButtons: [
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
    ],
  }),

  computed: {
    filteredActionButtons() {
      return this.actionButtons.filter((button) => button.type === this.type);
    },
  },

  props: {
    type: {
      type: String,
      validator: (value) => {
        return ["archive", "non-archive"].indexOf(value) !== -1;
      },
      default: () => "non-archive",
    },

    showCreateButton: {
      type: Boolean,
      default: () => true,
    },

    headers: {
      type: Array,
      default: () => [
        {
          text: "ID",
          value: "id",
          align: "center",
        },
        {
          text: "Name",
          value: "name",
          align: "center",
        },
        {
          text: "Actions",
          value: "actions",
          align: "center",
          sortable: false,
        },
      ],
    },

    items: {
      type: Array,
      default: () => [
        {
          id: 1,
          name: "carlo miguel dy",
        },
        {
          id: 2,
          name: "carlo dy",
        },
      ],
    },
  },

  methods: {},
};
</script>
