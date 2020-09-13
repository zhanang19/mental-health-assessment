<template>
  <v-main :class="isLoading ? 'primary' : color_theme" app>
    <!-- side bar -->
    <v-navigation-drawer
      color="white"
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
              <v-icon>mdi-arrow-collapse-left</v-icon>
            </v-btn>
          </template>
          <span>Close drawer</span>
        </v-tooltip>

        <v-toolbar-title v-if="!isLoading">{{
          title || "Untitled Survey Form"
        }}</v-toolbar-title>
        <v-toolbar-title v-else>
          ...
        </v-toolbar-title>
      </v-app-bar>

      <v-container>
        <v-form
          v-if="!isLoading"
          ref="form"
          @submit.prevent="save({ notify: true })"
        >
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
        <div v-else>
          <v-card-text>
            <v-skeleton-loader type="list-item"></v-skeleton-loader>
            <v-skeleton-loader type="list-item"></v-skeleton-loader>
            <v-skeleton-loader type="image"></v-skeleton-loader>
          </v-card-text>
        </div>
      </v-container>

      <v-card-title class="subtitle-2">
        <span>Question Groups</span>
        <v-spacer></v-spacer>
        <v-tooltip top>
          <template #activator="{on, attrs}">
            <v-icon v-on="on" v-bind="attrs">mdi-information-outline</v-icon>
          </template>
          <span
            >Click on a question group down below and it will redirect you to
            its questions</span
          >
        </v-tooltip>
      </v-card-title>

      <v-list v-if="!isLoading" nav>
        <v-menu
          offset-y
          v-for="(group, groupIndex) in survey.question_groups"
          :key="groupIndex"
        >
          <template #activator="{on, attrs}">
            <v-list-item
              v-on="on"
              v-bind="attrs"
              :color="currentGroup === group.id ? 'primary' : ''"
              nav
            >
              <v-list-item-content>
                <v-list-item-title v-text="group.label"></v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-tooltip right>
                  <template #activator="{on, attrs}">
                    <v-chip
                      v-on="on"
                      v-bind="attrs"
                      v-text="group.questions.length || 0"
                    ></v-chip>
                  </template>
                  <span
                    >There are {{ group.questions.length || 0 }} items in this
                    question group.</span
                  >
                </v-tooltip>
              </v-list-item-action>
            </v-list-item>
          </template>
          <v-list dense>
            <!-- view question group -->
            <v-list-item @click="redirectTo(group)">
              <v-list-item-content>
                <v-list-item-title>View</v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-icon>mdi-eye-outline</v-icon>
              </v-list-item-action>
            </v-list-item>

            <!-- duplicate question group -->
            <v-list-item
              @click="
                duplicateSurveyQuestionGroup({ questionGroupId: group.id })
              "
            >
              <v-list-item-content>
                <v-list-item-title>Duplicate</v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-icon>mdi-content-copy</v-icon>
              </v-list-item-action>
            </v-list-item>

            <!-- delete question group -->
            <v-list-item @click="destroy(group)">
              <v-list-item-content>
                <v-list-item-title>Delete</v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-icon>mdi-delete-outline</v-icon>
              </v-list-item-action>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-list>
      <v-list v-else>
        <v-skeleton-loader
          v-for="(group, groupIndex) in 10"
          :key="groupIndex"
          type="list-item"
        ></v-skeleton-loader>
      </v-list>
    </v-navigation-drawer>
    <!-- end of side bar -->

    <!-- content top nav bar -->
    <v-app-bar color="white" app extended>
      <div>
        <!-- toggle drawer button -->
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

        <!-- color theme selector -->
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

        <!-- refresh button -->
        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn
              :loading="isRefreshing"
              @click="getSurveyById({ refresh: true })"
              v-on="on"
              v-bind="attrs"
              icon
            >
              <v-icon>mdi-refresh</v-icon>
            </v-btn>
          </template>
          <span>Reload data</span>
        </v-tooltip>

        <!-- preview button -->
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
        <v-btn
          @click="$router.replace({ name: 'app-surveys' })"
          class="primary--text"
          >Back to Dashboard</v-btn
        >

        <v-btn @click="save({ notify: true })" color="primary"
          >Save Changes</v-btn
        >
      </div>
    </v-app-bar>
    <!-- end of content top nav bar -->

    <!-- delete confirmation dialog -->
    <app-confirmation-dialog
      v-model="dialogController.destroy"
      @confirmed="confirmDestroy(questionGroup)"
    ></app-confirmation-dialog>

    <!-- content -->
    <v-container class="my-16">
      <v-row justify="center" align="center">
        <v-col lg="8" md="10" sm="11" xs="12">
          <nuxt-child
            :key="$route.params.surveyId"
            :keep-alive="false"
            :is-loading="isLoading"
            @confirm-destroy="getSurveyById({ refresh: false })"
            @refresh="getSurveyById({ refresh: false })"
          ></nuxt-child>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import { colorThemes, surveyValidations } from "../../../models/Survey";
import { SurveyActions } from "../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";

import AppFloatingBackButton from "@/components/AppFloatingBackButton";
import AppConfirmationDialog from "@/components/alerts/AppConfirmationDialog";

export default {
  head() {
    return {
      title: `${process.env.appName} | ${this.title || "Untitled Survey Form"}`
    };
  },

  components: {
    AppFloatingBackButton,
    AppConfirmationDialog
  },

  layout: "empty",

  async created() {
    await this.getSurveyById({ refresh: false });
  },

  data: () => ({
    isLoading: false,
    isRefreshing: false,
    leftDrawer: true,
    currentGroup: null,
    questionGroup: {},
    dialogController: {
      destroy: false
    }
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
    async confirmDestroy(item) {
      await this.deleteSurveyQuestionGroup({
        questionGroupId: item.id
      });

      await this.getSurveyById({ refresh: false });

      this.dialogController.destroy = !this.dialogController.destroy;
    },

    destroy(item) {
      this.questionGroup = item;

      this.dialogController.destroy = !this.dialogController.destroy;
    },

    async getSurveyById({ refresh }) {
      if (refresh) {
        this.isRefreshing = true;
      }

      this.isLoading = true;

      await this.$store.dispatch(SurveyActions.FETCH, {
        surveyId: this.$route.params.surveyId
      });

      await setTimeout(() => {
        this.isLoading = false;
        this.isRefreshing = false;
      }, 500);
    },

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
    },

    redirectTo(group) {
      if (this.$route.name === "surveys-edit-surveyId-groups-questionGroupId") {
        this.$router
          .replace({
            name: "surveys-edit-surveyId",
            params: { surveyId: this.$route.params.surveyId }
          })
          .then(() => {
            this.$router.push({
              name: "surveys-edit-surveyId-groups-questionGroupId",
              params: {
                surveyId: this.$route.params.surveyId,
                questionGroupId: group.id
              }
            });
          });
      } else {
        this.$router.push({
          name: "surveys-edit-surveyId-groups-questionGroupId",
          params: {
            surveyId: this.$route.params.surveyId,
            questionGroupId: group.id
          }
        });
      }
    },

    /**
     * @param { Object } Payload
     */
    async deleteSurveyQuestionGroup({ questionGroupId }) {
      const res = await this.$store.dispatch(
        SurveyActions.DELETE_QUESTION_GROUP_BY_ID,
        {
          surveyId: this.survey.id,
          questionGroupId
        }
      );

      await this.getSurveyById({ refresh: false });

      console.log("deleteSurveyQuestionGroup()", res);
    },

    /**
     * @param { Object } payload
     */
    async duplicateSurveyQuestionGroup({ questionGroupId }) {
      const res = await this.$store.dispatch(
        SurveyActions.DUPLICATE_QUESTION_GROUP,
        {
          surveyId: this.survey.id,
          questionGroupId
        }
      );

      await this.getSurveyById({ refresh: false });

      console.log("duplicateSurveyQuestionGroup()", res);
    }
  }
};
</script>
