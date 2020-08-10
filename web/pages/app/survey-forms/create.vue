<template>
  <v-main :class="form.survey.color_theme" app>
    <v-app-bar app extended>
      <v-btn @click="$router.back()" icon>
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title>{{ form.title }}</v-toolbar-title>
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
                <v-sheet :class="`${color} pa-3 rounded-lg`"></v-sheet>
              </v-list-item-action>
              <v-list-item-content>{{ color }}</v-list-item-content>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-btn color="primary">Save Changes</v-btn>
      </div>

      <template #extension>
        <v-tabs centered>
          <v-tab>Questions</v-tab>
          <v-tab>Responses</v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-container class="survey-form-body">
      <v-card class="rounded-lg" style="margin-bottom: 5rem">
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

      <!-- question groups v-for loop -->
      <v-container class="pa-0 mb-10" v-for="(group, groupIndex) in form.groups" :key="groupIndex">
        <!-- survey question group header -->
        <v-card class="rounded-lg mb-3">
          <v-card-title class="headline">
            <v-text-field label="Group Label" v-model="group.label"></v-text-field>
            <v-spacer></v-spacer>
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
          </v-card-title>
          <v-card-text>
            <v-textarea
              label="Instructions"
              v-model="group.instructions"
              hint="Optional"
              persistent-hint
            ></v-textarea>
          </v-card-text>
        </v-card>

        <!-- survey question group v-for questions -->
        <v-card
          class="rounded-lg ml-5 mb-3"
          v-for="(question, questionIndex) in group.questions"
          :key="questionIndex"
        >
          <v-card-title class="headline">
            <span>Are you human?</span>
            <span class="ml-1 red--text">*</span>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
              <template #activator="{ on, attrs }">
                <v-btn
                  v-on="on"
                  v-bind="attrs"
                  @click="deleteSurveyQuestion(groupIndex, questionIndex)"
                  elevation="0"
                  small
                  fab
                >
                  <v-icon>mdi-delete-outline</v-icon>
                </v-btn>
              </template>
              <span>Delete this question</span>
            </v-tooltip>
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
          <v-btn @click="addSurveyQuestion(groupIndex)">Add Question</v-btn>
        </v-card-actions>
      </v-container>
      <div class="text-center">
        <v-btn class="primary--text" rounded x-large @click="addSurveyQuestionGroup()">
          <span>Add Question Group</span>
          <v-icon right>mdi-plus</v-icon>
        </v-btn>
      </div>
    </v-container>
  </v-main>
</template>

<script>
import { Survey, colorThemes } from "../../../models/Survey";
import { SurveyQuestionGroup } from "../../../models/SurveyQuestionGroup";
import { SurveyQuestion } from "../../../models/SurveyQuestion";

export default {
  head() {
    return {
      title: `${process.env.appName} | Survey Create Form`,
    };
  },

  layout: "empty",

  data: () => ({
    form: {
      survey: new Survey(),
      groups: [new SurveyQuestionGroup()],
    },
    colorThemes,
  }),

  methods: {
    selectColorTheme(color) {
      this.form.survey.color_theme = color;
    },

    addSurveyQuestionGroup() {
      this.form.groups.push(new SurveyQuestionGroup());
    },

    /**
     * @param index
     */
    deleteSurveyQuestionGroup(index) {
      this.form.groups.splice(index, 1);
    },

    /**
     * @param index survey question group index
     */
    addSurveyQuestion(index) {
      this.form.groups[index].questions.push(new SurveyQuestion());
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
  },
};
</script>
