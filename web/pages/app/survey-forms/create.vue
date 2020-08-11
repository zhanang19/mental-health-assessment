<template>
  <v-main :class="form.survey.color_theme" app>
    <v-app-bar app extended>
      <v-btn @click="$router.back()" icon>
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title>{{ form.survey.title || 'Untitled Survey Form' }}</v-toolbar-title>
      <v-spacer></v-spacer>
      <div>
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
                <v-sheet :class="`${color} pa-3 rounded-lg elevation-3`"></v-sheet>
              </v-list-item-action>
              <v-list-item-content>{{ color }}</v-list-item-content>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-btn @click="save()" color="primary">Save Changes</v-btn>
      </div>

      <template #extension>
        <v-tabs centered>
          <v-tab>Questions</v-tab>
          <v-tab>Responses</v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-container>
      <v-row justify="center" align="center">
        <v-col lg="8" md="10" sm="11" xs="12">
          <v-form ref="form" @submit.prevent="save()">
            <v-card class="rounded-lg" style="margin-bottom: 5rem">
              <v-card-title>
                <span class="display-1">
                  <v-text-field
                    hint="Required"
                    persistent-hint
                    label="Form Title"
                    v-model="form.survey.title"
                    :rules="rules.survey.title"
                  ></v-text-field>
                </span>
              </v-card-title>
              <v-card-subtitle>
                <v-text-field
                  hint="Optional"
                  persistent-hint
                  label="Subtitle"
                  v-model="form.survey.subtitle"
                ></v-text-field>
              </v-card-subtitle>
              <v-card-text>
                <v-textarea
                  v-model="form.survey.description"
                  label="Description"
                  hint="Optional"
                  outlined
                  persistent-hint
                ></v-textarea>
              </v-card-text>
            </v-card>

            <!-- question groups v-for loop -->
            <v-container
              class="pa-0 mb-10"
              v-for="(group, groupIndex) in form.groups"
              :key="groupIndex"
            >
              <!-- survey question group header -->
              <v-card class="rounded-lg mb-3">
                <v-card-title class="headline">
                  <v-text-field
                    hint="Required"
                    persistent-hint
                    label="Group Label"
                    v-model="group.label"
                    :rules="rules.group.label"
                  ></v-text-field>
                  <v-spacer></v-spacer>
                  <div>
                    <v-tooltip bottom>
                      <template #activator="{ on, attrs }">
                        <v-btn
                          v-on="on"
                          v-bind="attrs"
                          @click="duplicateSurveyQuestionGroup(groupIndex)"
                          elevation="0"
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
                          @click="deleteSurveyQuestionGroup(groupIndex)"
                          elevation="0"
                          small
                          fab
                        >
                          <v-icon>mdi-delete-outline</v-icon>
                        </v-btn>
                      </template>
                      <span>Delete this question group</span>
                    </v-tooltip>
                  </div>
                </v-card-title>
                <v-card-text>
                  <v-textarea
                    label="Instructions"
                    v-model="group.instructions"
                    hint="Optional"
                    persistent-hint
                    outlined
                  ></v-textarea>
                </v-card-text>
              </v-card>

              <!-- survey question group v-for questions -->
              <v-card
                class="rounded-lg ml-5 mb-3"
                v-for="(questionItem, questionIndex) in group.questions"
                :key="questionIndex"
              >
                <v-card-title class="headline">
                  <v-row>
                    <v-col lg="4" md="6" sm="10" xs="12">
                      <v-text-field
                        label="Question Identifer"
                        v-model="questionItem.identifier"
                        hint="e.g. #17 or ABC-01"
                        persistent-hint
                      ></v-text-field>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col lg="8" md="6" sm="12" xs="12">
                      <v-textarea
                        label="Question"
                        hint="Required"
                        persistent-hint
                        v-model="questionItem.question"
                        :rules="rules.question.question"
                        outlined
                      ></v-textarea>
                    </v-col>
                    <v-col lg="4" md="6" sm="12" xs="12">
                      <v-select
                        label="Input Type"
                        v-model="questionItem.input_type"
                        :items="inputTypes"
                        :rules="rules.question.input_type"
                        hint="Required"
                        persistent-hint
                        outlined
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-card-title>
                <v-card-text>
                  <!-- form options -->
                  <v-row>
                    <v-col lg="12" md="12" sm="12" xs="12">
                      <section v-if="inputTypesEnum.shortAnswer === questionItem.input_type">
                        <v-text-field label="Short answer text" disabled></v-text-field>
                      </section>
                      <section v-else-if="inputTypesEnum.paragraph === questionItem.input_type">
                        <v-textarea label="Long answer text" disabled></v-textarea>
                      </section>
                      <section
                        v-else-if="inputTypesEnum.multipleChoice === questionItem.input_type"
                      >
                        <v-row>
                          <!-- option group A -->
                          <v-col>
                            <v-text-field
                              label="Option Group Label"
                              v-model="questionItem.option_group_a.label"
                            ></v-text-field>
                            <v-radio-group column>
                              <v-radio
                                v-for="(choiceA, choiceAIndex) in questionItem.option_group_a.options"
                                :key="choiceAIndex"
                              >
                                <template #label>
                                  <v-text-field
                                    v-model="choiceA.text"
                                    :label="!!choiceA.text ? choiceA.text : `Option ${choiceAIndex + 1}`"
                                    @click:append="deleteSurveyQuestionChoice(groupIndex, questionIndex, choiceAIndex, 'option_group_a')"
                                    append-icon="mdi-close"
                                  ></v-text-field>
                                </template>
                              </v-radio>
                              <div>
                                <v-btn
                                  @click="addSurveyQuestionOption(groupIndex, questionIndex, 'option_group_a')"
                                  class="primary--text"
                                >Add Option</v-btn>
                              </div>
                            </v-radio-group>
                          </v-col>
                          <!-- option group B -->
                          <v-col v-if="!isObjectEmpty(questionItem.option_group_b)">
                            <v-text-field
                              label="Option Group Label"
                              v-model="questionItem.option_group_b.label"
                            ></v-text-field>
                            <v-radio-group column>
                              <v-radio
                                v-for="(choiceB, choiceBIndex) in questionItem.option_group_b.options"
                                :key="choiceBIndex"
                              >
                                <template #label>
                                  <v-text-field
                                    v-model="choiceB.text"
                                    :label="!!choiceB.text ? choiceB.text : `Option ${choiceBIndex + 1}`"
                                    @click:append="deleteSurveyQuestionChoice(groupIndex, questionIndex, choiceBIndex, 'option_group_b')"
                                    append-icon="mdi-close"
                                  ></v-text-field>
                                </template>
                              </v-radio>
                              <div>
                                <v-btn
                                  @click="addSurveyQuestionOption(groupIndex, questionIndex, 'option_group_b')"
                                  class="primary--text"
                                >Add Option</v-btn>
                                <v-btn
                                  @click="deleteSurveyQuestionOptionGroup(groupIndex, questionIndex, 'option_group_b')"
                                >Remove Option Group</v-btn>
                              </div>
                            </v-radio-group>
                          </v-col>
                        </v-row>
                      </section>
                      <section v-else-if="inputTypesEnum.checkboxes === questionItem.input_type">
                        <v-row>
                          <!-- checkbox option group A -->
                          <v-col>
                            <v-text-field
                              label="Option Group Label"
                              v-model="questionItem.option_group_a.label"
                            ></v-text-field>
                            <v-checkbox
                              v-for="(choiceA, choiceAIndex) in questionItem.option_group_a.options"
                              :key="choiceAIndex"
                            >
                              <template #label>
                                <v-text-field
                                  v-model="choiceA.text"
                                  :label="!!choiceA.text ? choiceA.text : `Option ${choiceAIndex + 1}`"
                                  @click:append="deleteSurveyQuestionChoice(groupIndex, questionIndex, choiceAIndex, 'option_group_a')"
                                  append-icon="mdi-close"
                                ></v-text-field>
                              </template>
                            </v-checkbox>
                            <div>
                              <v-btn
                                @click="addSurveyQuestionOption(groupIndex, questionIndex, 'option_group_a')"
                                class="primary--text"
                              >Add Option</v-btn>
                            </div>
                          </v-col>
                          <!-- checkbox option group B -->
                          <v-col v-if="!isObjectEmpty(questionItem.option_group_b)">
                            <v-text-field
                              label="Option Group Label"
                              v-model="questionItem.option_group_b.label"
                            ></v-text-field>
                            <v-checkbox
                              v-for="(choiceA, choiceAIndex) in questionItem.option_group_b.options"
                              :key="choiceAIndex"
                            >
                              <template #label>
                                <v-text-field
                                  v-model="choiceA.text"
                                  :label="!!choiceA.text ? choiceA.text : `Option ${choiceAIndex + 1}`"
                                  @click:append="deleteSurveyQuestionChoice(groupIndex, questionIndex, choiceAIndex, 'option_group_b')"
                                  append-icon="mdi-close"
                                ></v-text-field>
                              </template>
                            </v-checkbox>
                            <div>
                              <v-btn
                                @click="addSurveyQuestionOption(groupIndex, questionIndex, 'option_group_b')"
                                class="primary--text"
                              >Add Option</v-btn>
                              <v-btn
                                @click="deleteSurveyQuestionOptionGroup(groupIndex, questionIndex, 'option_group_b')"
                              >Remove Option Group</v-btn>
                            </div>
                          </v-col>
                        </v-row>
                      </section>
                      <section v-else-if="inputTypesEnum.dropdown === questionItem.input_type">
                        <div>
                          <v-text-field
                            v-for="(choiceA, choiceAIndex) in questionItem.option_group_a.options"
                            :key="choiceAIndex"
                            v-model="choiceA.text"
                            :label="!!choiceA.text ? choiceA.text : `Option ${choiceAIndex + 1}`"
                            @click:append="deleteSurveyQuestionChoice(groupIndex, questionIndex, choiceAIndex, 'option_group_a')"
                            append-icon="mdi-close"
                          ></v-text-field>
                          <div>
                            <v-btn
                              @click="addSurveyQuestionOption(groupIndex, questionIndex, 'option_group_a')"
                              class="primary--text"
                            >Add Option</v-btn>
                          </div>
                        </div>
                      </section>
                      <section class="text-center" v-else>
                        <h4 class="headline red--text">Must select an input type!</h4>
                      </section>
                    </v-col>
                  </v-row>
                </v-card-text>
                <v-divider class="mx-5"></v-divider>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <div class="mx-3">
                    <v-tooltip bottom>
                      <template #activator="{ on, attrs }">
                        <v-btn
                          v-on="on"
                          v-bind="attrs"
                          @click="duplicateSurveyQuestion(groupIndex, questionIndex)"
                          elevation="3"
                          small
                          fab
                        >
                          <v-icon>mdi-content-copy</v-icon>
                        </v-btn>
                      </template>
                      <span>Duplicate this question</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                      <template #activator="{ on, attrs }">
                        <v-btn
                          v-on="on"
                          v-bind="attrs"
                          @click="deleteSurveyQuestion(groupIndex, questionIndex)"
                          elevation="3"
                          small
                          fab
                        >
                          <v-icon>mdi-delete-outline</v-icon>
                        </v-btn>
                      </template>
                      <span>Delete this question</span>
                    </v-tooltip>
                  </div>
                  <v-divider vertical></v-divider>
                  <div class="mx-3">
                    <v-tooltip bottom>
                      <template #activator="{ on }">
                        <v-switch v-on="on" v-model="questionItem.required" label="Required"></v-switch>
                      </template>
                      <span>Make this question mandatory</span>
                    </v-tooltip>
                  </div>
                </v-card-actions>
              </v-card>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="addSurveyQuestion(groupIndex)">Add Question</v-btn>
              </v-card-actions>
            </v-container>
            <div class="text-center">
              <v-btn class="primary--text" x-large @click="addSurveyQuestionGroup()">
                <span>Add Question Group</span>
                <v-icon right>mdi-plus</v-icon>
              </v-btn>
            </div>
          </v-form>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import { Survey, colorThemes, surveyValidations } from "../../../models/Survey";
import {
  SurveyQuestionGroup,
  surveyQuestionGroupValidations,
} from "../../../models/SurveyQuestionGroup";
import {
  SurveyQuestion,
  surveyQuestionValidations,
  surveyQuestionOptionValidations,
  inputTypes,
  inputTypesEnum,
  Option,
} from "../../../models/SurveyQuestion";

export default {
  head() {
    return {
      title: `${process.env.appName} | Survey Create Form`,
    };
  },

  layout: "empty",

  data: () => ({
    form: {
      survey: new Survey({
        title: "Untitled Survey Form",
        color_theme: "blue darken-2",
      }),
      groups: [
        new SurveyQuestionGroup({
          label: "Untitled Question Group",
        }),
      ],
    },
  }),

  computed: {
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
        option: surveyQuestionOptionValidations,
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
    },
  },

  methods: {
    save() {
      if (this.$refs.form.validate()) {
        console.log("saved");
      } else {
        return this.$helpers.notify({
          type: "error",
          message: "Please fill in the required fields.",
        });
      }
    },

    /**
     * @param color string
     */
    selectColorTheme(color) {
      this.form.survey.color_theme = color;
    },

    addSurveyQuestionGroup() {
      this.form.groups.push(
        new SurveyQuestionGroup({
          label: "Untitled Question Group",
        })
      );
    },

    /**
     * @param index
     */
    deleteSurveyQuestionGroup(index) {
      this.form.groups.splice(index, 1);
    },

    /**
     * @param index
     */
    duplicateSurveyQuestionGroup(index) {
      this.form.groups.push({ ...this.form.groups[index] });
    },

    /**
     * @param index survey question group index
     */
    addSurveyQuestion(index) {
      const totalQuestions = this.form.groups[index].questions.length;

      this.form.groups[index].questions.push(
        new SurveyQuestion({
          identifier: (totalQuestions + 1),
          input_type: "short answer",
          required: false,
        })
      );
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
    duplicateSurveyQuestion(surveyQuestionGroupIndex, questionIndex) {
      this.form.groups[surveyQuestionGroupIndex].questions.push({
        ...this.form.groups[surveyQuestionGroupIndex].questions[questionIndex],
      });
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
          message: "Must have a set of options. Cannot delete option set A.",
        });
      } else {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_b = {};
      }
    },
  },
};
</script>
