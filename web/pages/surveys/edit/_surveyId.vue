<template>
  <v-main :class="color_theme" app>
    <v-navigation-drawer
      color="grey lighten-4"
      v-model="leftDrawer"
      :width="drawerWidth"
      :permanent="leftDrawer && onDesktop"
      app
    >
      <v-app-bar color="transparent" flat>
        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn
              @click="leftDrawer = !leftDrawer"
              v-on="on"
              v-bind="attrs"
              icon
            >
              <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
          </template>
          <span>Close drawer</span>
        </v-tooltip>

        <v-toolbar-title>{{ title || "Untitled Survey Form" }}</v-toolbar-title>
      </v-app-bar>

      <v-container>
        <v-form ref="form" @submit.prevent="save({ notify: true })">
          <v-card-text>
            <v-text-field
              hint="Required"
              persistent-hint
              label="Form Title"
              v-model="title"
              :rules="rules.survey.title"
              outlined
            ></v-text-field>

            <v-text-field
              hint="Optional"
              persistent-hint
              label="Subtitle"
              v-model="subtitle"
              outlined
            ></v-text-field>

            <v-textarea
              v-model="description"
              label="Description"
              hint="Optional"
              outlined
              persistent-hint
            ></v-textarea>
          </v-card-text>
        </v-form>
      </v-container>
    </v-navigation-drawer>

    <v-app-bar app extended>
      <div>
        <v-tooltip v-if="!leftDrawer" bottom>
          <template #activator="{ on, attrs }">
            <v-btn
              @click="leftDrawer = !leftDrawer"
              v-on="on"
              v-bind="attrs"
              icon
            >
              <v-icon>mdi-menu</v-icon>
            </v-btn>
          </template>
          <span>Toggle left drawer</span>
        </v-tooltip>

        <v-menu transition="slide-y-transition" offset-y>
          <template #activator="{ on: menu, attrs }">
            <v-tooltip bottom>
              <template #activator="{ on: tooltip }">
                <v-btn v-on="{ ...tooltip, ...menu }" v-bind="attrs" icon>
                  <v-icon>mdi-palette-outline</v-icon>
                </v-btn>
              </template>
              <span>Select a color theme</span>
            </v-tooltip>
          </template>
          <v-list>
            <v-list-item
              @click="selectColorTheme(color)"
              v-for="(color, index) in colorThemes"
              :key="index"
            >
              <v-list-item-action>
                <v-sheet
                  :class="`${color} pa-3 rounded-lg elevation-3`"
                ></v-sheet>
              </v-list-item-action>
              <v-list-item-content>{{ color }}</v-list-item-content>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn
              @click="
                $router.push({
                  name: 'surveys-preview-surveyId',
                  params: { surveyId: $route.params.surveyId }
                })
              "
              v-on="on"
              v-bind="attrs"
              icon
            >
              <v-icon>mdi-eye-outline</v-icon>
            </v-btn>
          </template>
          <span>Preview</span>
        </v-tooltip>
      </div>

      <v-toolbar-title></v-toolbar-title>
      <v-spacer></v-spacer>
      <div>
        <v-btn @click="save({ notify: true })" color="primary"
          >Save Changes</v-btn
        >
      </div>

      <template #extension>
        <v-tabs centered>
          <v-tab>Questions Groups</v-tab>
          <v-tab>Responses</v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-container class="my-16">
      <v-row justify="center" align="center">
        <v-col lg="8" md="10" sm="11" xs="12">
          <nuxt-child :key="$route.params.surveyId"></nuxt-child>
        </v-col>
      </v-row>
    </v-container>

    <app-floating-back-button></app-floating-back-button>
  </v-main>
</template>

<script>
import { colorThemes, surveyValidations } from "../../../models/Survey";
import { SurveyActions } from "../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";

import AppFloatingBackButton from "@/components/AppFloatingBackButton";

export default {
  head() {
    return {
      title: `${process.env.appName} | ${this.title || "Untitled Survey Form"}`
    };
  },

  components: {
    AppFloatingBackButton
  },

  layout: "empty",

  async fetch({ store, params }) {
    await store.dispatch(SurveyActions.FETCH, {
      surveyId: params.surveyId
    });
  },

  data: () => ({
    refreshing: false,
    leftDrawer: true
  }),

  computed: {
    ...mapState("surveys", {
      survey: state => state.survey
    }),

    ...mapFields("surveys", [
      "survey.title",
      "survey.subtitle",
      "survey.description",
      "survey.color_theme",
      "survey.question_groups.questions"
    ]),

    /**
     * Validation rules in form.
     *
     * @returns { Object }
     */
    rules() {
      return {
        survey: surveyValidations
      };
    },

    /**
     * List of available colors for color theming.
     *
     * @returns { Array }
     */
    colorThemes() {
      return colorThemes;
    },

    drawerWidth() {
      const breakpoint = this.$vuetify.breakpoint;

      if (breakpoint.xl) return "500";
      if (breakpoint.lg) return "425";
      if (breakpoint.md) return "400";
      if (breakpoint.sm) return "100%";
      if (breakpoint.xs) return "100%";
    },

    onDesktop() {
      const breakpoint = this.$vuetify.breakpoint;

      return breakpoint.xl || breakpoint.lg;
    }
  },

  methods: {
    async save({ notify = true }) {
      const response = await this.$store.dispatch(SurveyActions.UPDATE, {
        surveyId: this.survey.id
      });

      if (notify) {
        await this.$helpers.notify({
          type: "success",
          message: response?.message || "No message."
        });
      }
    },

    /**
     * @param color string
     */
    selectColorTheme(color) {
      this.color_theme = color;
    }
  }
};
</script>
