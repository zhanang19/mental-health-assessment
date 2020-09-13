<template>
  <div>
    <v-form v-if="!isLoading" ref="form">
      <!-- START: Question Groups v-for loop -->
      <v-container>
        <!-- survey question group header -->
        <v-card
          class="rounded-lg mb-10"
          v-for="(group, groupIndex) in question_groups"
          :id="`question-group-${group.id}`"
          :key="groupIndex"
        >
          <v-card-title class="headline pt-10">
            <v-text-field
              hint="Required"
              persistent-hint
              label="Group Label"
              v-model="group.label"
              :rules="rules.group.label"
              @change="save({ notify: false })"
              outlined
            ></v-text-field>
          </v-card-title>
          <v-card-text>
            <quill-editor
              v-model="group.instructions"
              :options="editorOptions"
            />

            <!-- <v-textarea
              label="Instructions"
              v-model="group.instructions"
              hint="Optional"
              persistent-hint
              @change="save({ notify: false })"
              outlined
            ></v-textarea> -->
          </v-card-text>
          <v-divider class="mx-5"></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <div class="mx-3 py-3">
              <v-tooltip bottom>
                <template #activator="{ on, attrs }">
                  <v-btn
                    v-on="on"
                    v-bind="attrs"
                    @click="redirectTo(group)"
                    elevation="3"
                    small
                    fab
                  >
                    <v-icon>mdi-eye-outline</v-icon>
                  </v-btn>
                </template>
                <span
                  >View all questions that belong to this question group</span
                >
              </v-tooltip>

              <v-tooltip bottom>
                <template #activator="{ on, attrs }">
                  <v-btn
                    v-on="on"
                    v-bind="attrs"
                    @click="
                      duplicateSurveyQuestionGroup({
                        questionGroupId: group.id
                      })
                    "
                    elevation="3"
                    small
                    fab
                  >
                    <v-icon>mdi-content-copy</v-icon>
                  </v-btn>
                </template>
                <span>Duplicate this question group</span>
              </v-tooltip>

              <v-tooltip bottom>
                <template #activator="{ on, attrs }">
                  <v-btn
                    v-on="on"
                    v-bind="attrs"
                    @click="destroy(group)"
                    elevation="3"
                    small
                    fab
                  >
                    <v-icon>mdi-delete-outline</v-icon>
                  </v-btn>
                </template>
                <span>Delete this question group</span>
              </v-tooltip>
            </div>
          </v-card-actions>
        </v-card>
      </v-container>
      <!-- END: Question Groups v-for loop -->
    </v-form>
    <div v-else>
      <v-container>
        <!-- survey question group header -->
        <v-card
          class="rounded-lg mb-10"
          v-for="(group, groupIndex) in 10"
          :key="groupIndex"
        >
          <v-card-title class="headline pt-10">
            <v-text-field
              label="Group Label"
              placeholder="..."
              outlined
              disabled
            ></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-skeleton-loader type="image"></v-skeleton-loader>
          </v-card-text>
          <v-divider class="mx-5"></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <div class="mx-3 py-3">
              <v-btn disabled elevation="3" small fab>
                <v-icon>mdi-eye-outline</v-icon>
              </v-btn>

              <v-btn disabled elevation="3" small fab>
                <v-icon>mdi-content-copy</v-icon>
              </v-btn>

              <v-btn disabled elevation="3" small fab>
                <v-icon>mdi-delete-outline</v-icon>
              </v-btn>
            </div>
          </v-card-actions>
        </v-card>
      </v-container>
    </div>

    <!-- delete confirmation dialog -->
    <app-confirmation-dialog
      v-model="dialogController.destroy"
      @confirmed="confirmDestroy(questionGroup)"
    ></app-confirmation-dialog>

    <!-- floating action button -->
    <v-btn
      class="primary--text"
      x-large
      @click="addSurveyQuestionGroup()"
      :loading="isLoading"
      rounded
      bottom
      right
      fixed
    >
      <span>Add Question Group</span>
      <v-icon right>mdi-plus</v-icon>
    </v-btn>
  </div>
</template>

<script>
import {
  Survey,
  colorThemes,
  surveyValidations
} from "../../../../models/Survey";
import {
  SurveyQuestionGroup,
  surveyQuestionGroupValidations
} from "../../../../models/SurveyQuestionGroup";
import {
  SurveyQuestion,
  surveyQuestionValidations,
  surveyQuestionOptionValidations,
  inputTypes,
  inputTypesEnum,
  Option
} from "../../../../models/SurveyQuestion";
import { SurveyActions, SurveyMutations } from "../../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";

import AppConfirmationDialog from "@/components/alerts/AppConfirmationDialog";
import AppSurveyQuestion from "@/components/surveys/forms/AppSurveyQuestion";
import AppCircularProgressIndicator from "@/components/AppCircularProgressIndicator";

export default {
  components: {
    AppSurveyQuestion,
    AppCircularProgressIndicator,
    AppConfirmationDialog
  },

  layout: "empty",

  props: {
    isLoading: Boolean
  },

  data: () => ({
    // isLoading: false,
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

    ...mapMultiRowFields("surveys", ["survey.question_groups"]),

    editorOptions() {
      return {
        modules: {
          toolbar: [
            ["bold", "italic", "underline", "strike"], // toggled buttons
            ["blockquote", "code-block"],

            [{ header: 1 }, { header: 2 }], // custom button values
            [{ list: "ordered" }, { list: "bullet" }],
            [{ script: "sub" }, { script: "super" }], // superscript/subscript
            [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
            [{ direction: "rtl" }], // text direction

            [{ header: [1, 2, 3, 4, 5, 6, false] }],

            [{ color: [] }, { background: [] }], // dropdown with defaults from theme
            [{ font: [] }],
            [{ align: [] }],

            ["clean"] // remove formatting button
          ]
        }
      };
    },

    /**
     * Validation rules in form.
     *
     * @returns { Object }
     */
    rules() {
      return {
        survey: surveyValidations,
        group: surveyQuestionGroupValidations,
        question: surveyQuestionValidations,
        option: surveyQuestionOptionValidations
      };
    },

    /**
     * Input types,
     * e.g. short answer, paragraph, checkboxes
     *
     * @returns { Array }
     */
    inputTypes() {
      return inputTypes;
    },

    /**
     * Enum for input types.
     *
     * @returns { Object }
     */
    inputTypesEnum() {
      return inputTypesEnum;
    },

    /**
     * List of available colors for color theming.
     *
     * @returns { Array }
     */
    colorThemes() {
      return colorThemes;
    }
  },

  methods: {
    async confirmDestroy(item) {
      const res = await this.deleteSurveyQuestionGroup({
        questionGroupId: item.id
      });

      await this.$store.commit(SurveyMutations.REMOVE_QUESTION_GROUP, res.data);

      this.dialogController.destroy = !this.dialogController.destroy;
    },

    destroy(item) {
      this.questionGroup = item;

      this.dialogController.destroy = !this.dialogController.destroy;
    },

    async refresh() {
      await this.$emit("refresh");
    },

    async redirectTo(group) {
      await this.$emit("is-loading", true);
      await this.$router.push({
        name: "surveys-edit-surveyId-groups-questionGroupId",
        params: {
          surveyId: this.$route.params.surveyId,
          questionGroupId: group.id
        }
      });
      await this.$emit("is-loading", false);
    },

    async save({ notify = true }) {
      if (await this.$refs.form.validate()) {
        console.log("saved");
        const response = await this.$store.dispatch(SurveyActions.UPDATE, {
          surveyId: this.survey.id
        });

        if (notify) {
          await this.$helpers.notify({
            type: "success",
            message: response?.message || "No message."
          });
        }

        // await `this.$router.replace({
        //   name: "surveys-edit-surveyId",
        //   params: {
        //     surveyId: response.data.surveyId
        //   }
        // });`
      } else {
        return await this.$helpers.notify({
          type: "error",
          message: "Please fill in the required fields."
        });
      }
    },

    /**
     * @param color string
     */
    selectColorTheme(color) {
      this.color_theme = color;
    },

    async addSurveyQuestionGroup() {
      const res = await this.$store.dispatch(
        SurveyActions.CREATE_QUESTION_GROUP,
        {
          surveyId: this.survey.id
        }
      );

      await this.$store.commit(SurveyMutations.APPEND_QUESTION_GROUP, res.data);

      await this.$vuetify.goTo(`#question-group-${res.data.id}`);

      console.log(`addSurveyQuestionGroup()`, res);
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

      console.log("deleteSurveyQuestionGroup()", res);

      return res;
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

      console.log(res);

      await this.$store.commit(SurveyMutations.APPEND_QUESTION_GROUP, res.data);

      await this.$vuetify.goTo(`#question-group-${res.data.id}`);

      console.log("duplicateSurveyQuestionGroup()", res);
    },

    /**
     * @param { Object } payload
     */
    async addSurveyQuestion({ questionGroupId }) {
      const res = await this.$store.dispatch(SurveyActions.CREATE_QUESTION, {
        surveyId: this.survey.id,
        questionGroupId
      });

      await this.refresh();

      console.log("addSurveyQuestion()", res);
    },

    /**
     * Remove survey question from group.
     *
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     */
    deleteSurveyQuestion(surveyQuestionGroupIndex, questionIndex) {
      this.form.groups[surveyQuestionGroupIndex].questions.splice(
        questionIndex,
        1
      );
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     */
    addSurveyQuestionOption(surveyQuestionGroupIndex, questionIndex, field) {
      if (field === "option_group_a") {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_a.options.push(new Option());
      } else {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_b.options.push(new Option());
      }
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     * @param choiceAIndex question index
     */
    deleteSurveyQuestionChoice(
      surveyQuestionGroupIndex,
      questionIndex,
      choiceAIndex,
      field
    ) {
      if (field === "option_group_a") {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_a.options.splice(choiceAIndex, 1);
      } else {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_b.options.splice(choiceAIndex, 1);
      }
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     * @param choiceAIndex question index
     */
    deleteSurveyQuestionOptionGroup(
      surveyQuestionGroupIndex,
      questionIndex,
      field
    ) {
      if (field === "option_group_a") {
        return this.$helpers.notify({
          type: "info",
          message: "Must have a set of options. Cannot delete option set A."
        });
      } else {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_b = {};
      }
    }
  }
};
</script>
