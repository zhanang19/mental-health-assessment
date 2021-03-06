<template>
  <div>
    <v-form ref="form" @submit.prevent="save({ notify: false })">
      <!-- START: Survey Question Group v-for questions -->
      <v-card
        class="rounded-lg mb-10"
        v-for="(questionItem, questionIndex) in questions"
        :key="questionIndex"
        :id="`question-${questionItem.id}`"
      >
        <v-card-title class="headline">
          <v-row>
            <v-col lg="4" md="6" sm="10" xs="12">
              <v-text-field
                label="Question Identifer"
                v-model="questionItem.identifier"
                hint="e.g. #17 or ABC-01"
                persistent-hint
                @blur="onBlur($event)"
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
                @blur="onBlur($event)"
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
                @blur="onBlur($event)"
                outlined
              ></v-select>
            </v-col>
          </v-row>
        </v-card-title>
        <v-card-text>
          <!-- form options -->
          <v-row>
            <v-col lg="12" md="12" sm="12" xs="12">
              <section
                v-if="inputTypesEnum.shortAnswer === questionItem.input_type"
              >
                <v-text-field label="Short answer text" disabled></v-text-field>
              </section>
              <section
                v-else-if="inputTypesEnum.paragraph === questionItem.input_type"
              >
                <v-textarea label="Long answer text" disabled></v-textarea>
              </section>
              <section
                v-else-if="
                  inputTypesEnum.multipleChoice === questionItem.input_type
                "
              >
                <v-row>
                  <!-- option group A -->
                  <v-col>
                    <v-text-field
                      label="Option Group Label"
                      v-model="questionItem.option_group_a.label"
                      @blur="onBlur($event)"
                    ></v-text-field>
                    <v-radio-group column>
                      <v-radio
                        v-for="(choiceA, choiceIndex) in questionItem
                          .option_group_a.options"
                        :key="choiceIndex"
                      >
                        <template #label>
                          <v-text-field
                            v-model="choiceA.text"
                            :label="
                              !!choiceA.text
                                ? choiceA.text
                                : `Option ${choiceIndex + 1}`
                            "
                            @click:append="
                              deleteSurveyQuestionChoice({
                                questionIndex,
                                choiceIndex,
                                field: 'option_group_a'
                              })
                            "
                            @blur="onBlur($event)"
                            append-icon="mdi-close"
                          ></v-text-field>
                        </template>
                      </v-radio>
                      <div>
                        <v-btn
                          @click="
                            addSurveyQuestionOption({
                              questionIndex,
                              field: 'option_group_a'
                            })
                          "
                          class="primary--text"
                          >Add Option</v-btn
                        >
                      </div>
                    </v-radio-group>
                  </v-col>
                  <!-- option group B -->
                  <v-col
                    v-if="
                      !isObjectEmpty(questionItem.option_group_b) &&
                        !Array.isArray(questionItem.option_group_b)
                    "
                  >
                    <v-text-field
                      label="Option Group Label"
                      v-model="questionItem.option_group_b.label"
                      @blur="onBlur($event)"
                    ></v-text-field>
                    <v-radio-group column>
                      <v-radio
                        v-for="(choiceB, choiceBIndex) in questionItem
                          .option_group_b.options"
                        :key="choiceBIndex"
                      >
                        <template #label>
                          <v-text-field
                            v-model="choiceB.text"
                            :label="
                              !!choiceB.text
                                ? choiceB.text
                                : `Option ${choiceBIndex + 1}`
                            "
                            @click:append="
                              deleteSurveyQuestionChoice({
                                questionIndex,
                                choiceIndex,
                                field: 'option_group_a'
                              })
                            "
                            @blur="onBlur($event)"
                            append-icon="mdi-close"
                          ></v-text-field>
                        </template>
                      </v-radio>
                      <div>
                        <v-btn
                          @click="
                            addSurveyQuestionOption({
                              questionIndex,
                              field: 'option_group_b'
                            })
                          "
                          class="primary--text"
                          >Add Option</v-btn
                        >
                        <v-btn
                          @click="
                            deleteSurveyQuestionOptionGroup({
                              questionIndex,
                              field: 'option_group_b'
                            })
                          "
                          >Remove Option Group</v-btn
                        >
                      </div>
                    </v-radio-group>
                  </v-col>
                </v-row>
              </section>
              <section
                v-else-if="
                  inputTypesEnum.checkboxes === questionItem.input_type
                "
              >
                <v-row>
                  <!-- checkbox option group A -->
                  <v-col>
                    <v-text-field
                      label="Option Group Label"
                      v-model="questionItem.option_group_a.label"
                      @blur="onBlur($event)"
                    ></v-text-field>
                    <v-checkbox
                      v-for="(choiceA, choiceIndex) in questionItem
                        .option_group_a.options"
                      :key="choiceIndex"
                    >
                      <template #label>
                        <v-text-field
                          v-model="choiceA.text"
                          :label="
                            !!choiceA.text
                              ? choiceA.text
                              : `Option ${choiceIndex + 1}`
                          "
                          @click:append="
                            deleteSurveyQuestionChoice({
                              questionIndex,
                              choiceIndex,
                              field: 'option_group_a'
                            })
                          "
                          @blur="onBlur($event)"
                          append-icon="mdi-close"
                        ></v-text-field>
                      </template>
                    </v-checkbox>
                    <div>
                      <v-btn
                        @click="
                          addSurveyQuestionOption({
                            questionIndex,
                            field: 'option_group_a'
                          })
                        "
                        class="primary--text"
                        >Add Option</v-btn
                      >
                    </div>
                  </v-col>
                  <!-- checkbox option group B -->
                  <v-col
                    v-if="
                      !isObjectEmpty(questionItem.option_group_b) &&
                        !Array.isArray(questionItem.option_group_b)
                    "
                  >
                    <v-text-field
                      label="Option Group Label"
                      v-model="questionItem.option_group_b.label"
                      @blur="onBlur($event)"
                    ></v-text-field>
                    <v-checkbox
                      v-for="(choiceA, choiceIndex) in questionItem
                        .option_group_b.options"
                      :key="choiceIndex"
                    >
                      <template #label>
                        <v-text-field
                          v-model="choiceA.text"
                          :label="
                            !!choiceA.text
                              ? choiceA.text
                              : `Option ${choiceIndex + 1}`
                          "
                          @click:append="
                            deleteSurveyQuestionChoice({
                              questionIndex,
                              choiceIndex,
                              field: 'option_group_b'
                            })
                          "
                          @blur="onBlur($event)"
                          append-icon="mdi-close"
                        ></v-text-field>
                      </template>
                    </v-checkbox>
                    <div>
                      <v-btn
                        @click="
                          addSurveyQuestionOption({
                            questionIndex,
                            field: 'option_group_b'
                          })
                        "
                        class="primary--text"
                        >Add Option</v-btn
                      >
                      <v-btn
                        @click="
                          deleteSurveyQuestionOptionGroup({
                            questionIndex,
                            field: 'option_group_b'
                          })
                        "
                        >Remove Option Group</v-btn
                      >
                    </div>
                  </v-col>
                </v-row>
              </section>
              <section
                v-else-if="inputTypesEnum.dropdown === questionItem.input_type"
              >
                <!-- dropdown select options -->
                <div>
                  <v-text-field
                    v-for="(choiceA, choiceIndex) in questionItem.option_group_a
                      .options"
                    :key="choiceIndex"
                    v-model="choiceA.text"
                    :label="
                      !!choiceA.text
                        ? choiceA.text
                        : `Option ${choiceIndex + 1}`
                    "
                    @click:append="
                      deleteSurveyQuestionChoice({
                        questionIndex,
                        choiceIndex,
                        field: 'option_group_a'
                      })
                    "
                    @blur="onBlur($event)"
                    append-icon="mdi-close"
                  ></v-text-field>
                  <div>
                    <v-btn
                      @click="
                        addSurveyQuestionOption({
                          questionIndex,
                          field: 'option_group_a'
                        })
                      "
                      class="primary--text"
                      >Add Option</v-btn
                    >
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
                  @click="
                    duplicateSurveyQuestion({
                      questionGroupId: questionGroup.id,
                      questionId: questionItem.id
                    })
                  "
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
                  @click="deleteSurveyQuestion(questionItem)"
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
                <v-switch
                  @change="onBlur($event)"
                  v-on="on"
                  v-model="questionItem.required"
                  label="Required"
                ></v-switch>
              </template>
              <span>Make this question mandatory</span>
            </v-tooltip>
          </div>
        </v-card-actions>
      </v-card>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="addSurveyQuestion({ questionGroupId: questionGroup.id })"
          >Add Question</v-btn
        >
      </v-card-actions>
      <!-- END: Survey Question Group v-for questions -->
    </v-form>
  </div>
</template>

<script>
import { Survey, colorThemes, surveyValidations } from "../../../models/Survey";
import {
  SurveyQuestionGroup,
  surveyQuestionGroupValidations
} from "../../../models/SurveyQuestionGroup";
import {
  SurveyQuestion,
  surveyQuestionValidations,
  surveyQuestionOptionValidations,
  inputTypes,
  inputTypesEnum,
  Option
} from "../../../models/SurveyQuestion";
import { SurveyActions, SurveyMutations } from "../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";
import { sanitizeObject } from "../../../utils/Util";

export default {
  created() {
    this.setQuestionsState();

    console.log("AppSurveyQuestion Component", this.questions);
  },

  props: {
    questionGroupIndex: {
      type: [Number, String],
      required: true
    },

    questionGroup: {
      type: Object,
      required: true
    }
  },

  data: () => ({
    questions: []
  }),

  watch: {
    questions(value) {
      console.log("watching questions field", value);
    }
  },

  computed: {
    ...mapState("surveys", {
      survey: state => state.survey
    }),

    /**
     * Validation rules in form.
     *
     * @returns { Object }
     */
    rules() {
      return {
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
    }
  },

  methods: {
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
      } else {
        return await this.$helpers.notify({
          type: "error",
          message: "Please fill in the required fields."
        });
      }
    },

    /**
     * Set the state data onBlur event.
     *
     * @param { Event } even
     * @return { Void }
     */
    async onBlur(event) {
      await this.$store.commit(SurveyMutations.SET_QUESTION_GROUP_QUESTIONS, {
        index: this.questionGroupIndex,
        questions: this.questions
      });

      await this.setQuestionsState();

      // await this.$store.dispatch(SurveyActions.UPDATE, {
      //   surveyId: this.survey.id,
      // });

      console.log(
        "onBlur() have set questions in index ",
        this.questionGroupIndex
      );
    },

    /**
     * Copy the set of questions based on quetion group.
     *
     * @return { Void }
     */
    setQuestionsState() {
      this.questions = JSON.parse(
        JSON.stringify(
          this.survey?.question_groups[this.questionGroupIndex]?.questions || []
        )
      );

      console.log(this.questions);
    },

    /**
     * @param { Object } payload
     */
    async addSurveyQuestion({ questionGroupId }) {
      await this.$store.dispatch(SurveyActions.UPDATE, {
        surveyId: this.survey.id
      });

      const res = await this.$store.dispatch(SurveyActions.CREATE_QUESTION, {
        surveyId: this.survey.id,
        questionGroupId
      });

      await this.$store.dispatch(SurveyActions.FETCH, {
        surveyId: this.$route.params.surveyId
      });

      await this.setQuestionsState();
    },

    /**
     * Remove survey question from group.
     *
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     */
    async deleteSurveyQuestion(item) {
      const response = await this.$store.dispatch(
        SurveyActions.DELETE_QUESTION_BY_ID,
        {
          surveyId: this.$route.params.surveyId,
          questionGroupId: item.survey_question_group_id,
          questionId: item.id
        }
      );

      if (response.status === 200) {
        const trashIndex = this.questions.findIndex(
          question => question.id === item.id
        );

        this.questions.splice(trashIndex, 1);

        await this.$store.dispatch(SurveyActions.FETCH, {
          surveyId: this.$route.params.surveyId
        });
      }
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     */
    async duplicateSurveyQuestion({ questionGroupId, questionId }) {
      await this.save({ notify: false });

      const res = await this.$store.dispatch(SurveyActions.DUPLICATE_QUESTION, {
        surveyId: this.survey.id,
        questionGroupId,
        questionId
      });

      const response = await this.$store.dispatch(SurveyActions.FETCH, {
        surveyId: this.$route.params.surveyId
      });

      await this.setQuestionsState();
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     */
    addSurveyQuestionOption({ questionIndex, field }) {
      console.log(this.questions[questionIndex][field]);

      const isString = typeof this.questions[questionIndex][field] === "string";

      if (isString) {
        console.log("addSurveyQuestionOption() isString yes");

        this.questions[questionIndex][field] = JSON.parse(
          this.questions[questionIndex][field].options.push(new Option())
        );
      } else {
        console.log("addSurveyQuestionOption() not isString");

        this.questions[questionIndex][field].options.push(new Option());
      }
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     * @param choiceIndex question index
     */
    deleteSurveyQuestionChoice({ questionIndex, choiceIndex, field }) {
      this.questions[questionIndex][field].splice(choiceIndex, 1);

      // if (field === "option_group_a") {
      //   this.form.groups[surveyQuestionGroupIndex].questions[
      //     questionIndex
      //   ].option_group_a.options.splice(choiceIndex, 1);
      // } else {
      //   this.form.groups[surveyQuestionGroupIndex].questions[
      //     questionIndex
      //   ].option_group_b.options.splice(choiceIndex, 1);
      // }
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     * @param choiceAIndex question index
     */
    deleteSurveyQuestionOptionGroup({ questionIndex, field }) {
      console.log(
        "deleteSurveyQuestionOptionGroup()",
        this.questions[questionIndex][field]
      );
      this.questions[questionIndex][field] = {};
      this.onBlur();
    }
  }
};
</script>
