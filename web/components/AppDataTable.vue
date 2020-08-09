<template>
  <div>
    <v-card>
      <v-toolbar color="transparent" flat>
        <v-text-field
          v-model="search"
          single-line
          hide-details
          placeholder="Filter by string matching"
        ></v-text-field>
        <v-toolbar-title></v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn @click="$emit('click:create')" width="125" large>CREATE</v-btn>
      </v-toolbar>
      <v-card-text>
        <v-data-table
          :search="search"
          :headers="headers"
          :items="items"
          multi-sort
        >
          <template #item.actions="{ item }">
            <div v-if="type === 'non-archive'">
              <v-btn @click="$emit('click:view', item)" small fab>
                <v-icon>mdi-eye-outline</v-icon>
              </v-btn>
              <v-btn @click="$emit('click:edit', item)" small fab>
                <v-icon>mdi-pencil-outline</v-icon>
              </v-btn>
              <v-btn @click="$emit('click:delete', item)" small fab>
                <v-icon>mdi-delete-outline</v-icon>
              </v-btn>
            </div>
            <div v-else-if="type === 'archive'">
              <v-btn @click="$emit('click:restore', item)" small fab>
                <v-icon>mdi-restore</v-icon>
              </v-btn>
              <v-btn @click="$emit('click:deletePermanently', item)" small fab>
                <v-icon>mdi-delete-forever-outline</v-icon>
              </v-btn>
            </div>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  data: () => ({
    search: ""
  }),

  props: {
    type: {
      type: String,
      default: () => "non-archive"
    },

    headers: {
      type: Array,
      required: true,
      default: () => [
        {
          text: "ID",
          value: "id",
          align: "center"
        },
        {
          text: "Name",
          value: "name",
          align: "center"
        },
        {
          text: "Actions",
          value: "actions",
          align: "center",
          sortable: false
        }
      ]
    },

    items: {
      type: Array,
      required: true,
      default: () => [
        {
          id: 1,
          name: "carlo miguel dy"
        },
        {
          id: 2,
          name: "carlo dy"
        }
      ]
    }
  },

  methods: {}
};
</script>
