<template>
  <v-main class="primary" app>
    <v-app-bar app>
      <v-toolbar-title>MHA</v-toolbar-title>
    </v-app-bar>

    <v-container style="padding-left: 15rem; padding-right: 15rem;">
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

      <v-card class="rounded-lg mb-3">
        <v-card-title class="headline">
          If not human, what are you?
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

      <v-card class="rounded-lg mb-3">
        <v-card-title class="headline">
          If you have ate pizza, rate it
          <span class="ml-1 red--text">*</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-radio-group>
                <v-radio label="Not Satisfied" value="radio-1"></v-radio>
                <v-radio label="Satisfied" value="radio-2"></v-radio>
                <v-radio label="Just Cool" value="radio-3"></v-radio>
                <v-radio label="Nah" value="radio-4"></v-radio>
                <v-radio label="Greatly" value="radio-5"></v-radio>
              </v-radio-group>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="rounded-lg mb-3">
        <v-card-title class="headline">
          Do you like burgers?
          <span class="ml-1 red--text">*</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col>
              <v-checkbox label="Yes" value="Yes"></v-checkbox>
              <v-checkbox label="No" value="No"></v-checkbox>
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
      title: `${process.env.appName} | Survey`,
    };
  },

  layout: "empty",
};
</script>
