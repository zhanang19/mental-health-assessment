<template>
  <v-main class="primary" app>
    <v-app-bar app extended>
      <v-btn @click="$router.back()" icon>
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title>{{ form.title }}</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn class="primary--text">Save Changes</v-btn>

      <template #extension>
        <v-tabs centered>
          <v-tab>Questions</v-tab>
          <v-tab>Responses</v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-container style="padding-left: 15rem; padding-right: 15rem;">
      <v-card class="rounded-lg mb-3">
        <v-card-title>
          <span class="display-1">
            <v-text-field label="Form Title" v-model="form.title"></v-text-field>
          </span>
        </v-card-title>
        <v-card-subtitle>
          <v-text-field label="Subtitle" v-model="form.subtitle"></v-text-field>
        </v-card-subtitle>
        <v-card-text>
          <v-textarea label="Description" hint="Optional" persistent-hint></v-textarea>
        </v-card-text>
      </v-card>

      <v-card class="rounded-lg mb-3">
        <v-card-title class="headline">
          Are you human?
          <span class="ml-1 red--text">*</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col>
              <v-text-field style="width: 60%" label="Your answer"></v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>


      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn class="blue--text text--darken-3" width="125" large>Save</v-btn>
        <v-btn class="primary--text" width="125" large>Next</v-btn>
      </v-card-actions>
    </v-container>
  </v-main>
</template>

<script>
export default {
  head() {
    return {
      title: `${process.env.appName} | Survey Create Form`,
    };
  },

  layout: "empty",

  data: () => ({
    form: {
      title: 'Untitled Form',
      subtitle: 'Subtitle',
    }
  })
};
</script>
