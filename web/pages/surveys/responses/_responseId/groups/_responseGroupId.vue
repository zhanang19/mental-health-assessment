<template>
  <v-container>
    <v-row justify="center" align="center">
      <v-col lg="8" md="10" sm="11" xs="12">
        <v-form ref="form" @submit.prevent="save()">
          <!-- START: Survey Question Group v-for questions -->
          <v-card
            class="rounded-lg mb-10"
            v-for="(answerItem, answerIndex) in answers"
            :key="answerIndex"
          >
            <v-card-title class="headline" v-text="answerItem.question">
              <!-- <v-row>
                <v-col lg="4" md="6" sm="10" xs="12">
                  <span v-text="answerItem.identifier"></span>
                </v-col>
              </v-row>-->
            </v-card-title>
            <v-card-text>
              <!-- form options -->
              <v-row>
                <v-col lg="12" md="12" sm="12" xs="12">
                  <section v-if="inputTypesEnum.shortAnswer === answerItem.input_type">
                    <v-text-field label="Your answer here"></v-text-field>
                  </section>
                  <section v-else-if="inputTypesEnum.paragraph === answerItem.input_type">
                    <v-textarea label="Your answer here"></v-textarea>
                  </section>
                  <section v-else-if="inputTypesEnum.multipleChoice === answerItem.input_type">
                    <v-row>
                      <!-- option group A -->
                      <v-col>
                        <v-text-field
                          label="Option Group Label"
                          v-model="answerItem.option_group_a.label"
                        ></v-text-field>
                        <v-radio-group column>
                          <v-radio
                            v-for="(choiceA, choiceIndex) in answerItem.option_group_a.options"
                            :key="choiceIndex"
                          >
                            <template #label>
                              <v-text-field
                                v-model="choiceA.text"
                                :label="!!choiceA.text ? choiceA.text : `Option ${choiceIndex + 1}`"
                                append-icon="mdi-close"
                              ></v-text-field>
                            </template>
                          </v-radio>
                          <div>
                            <v-btn class="primary--text">Add Option</v-btn>
                          </div>
                        </v-radio-group>
                      </v-col>
                      <!-- option group B -->
                      <v-col
                        v-if="!isObjectEmpty(answerItem.option_group_b) && !Array.isArray(answerItem.option_group_b)"
                      >
                        <v-text-field
                          label="Option Group Label"
                          v-model="answerItem.option_group_b.label"
                        ></v-text-field>
                        <v-radio-group column>
                          <v-radio
                            v-for="(choiceB, choiceBIndex) in answerItem.option_group_b.options"
                            :key="choiceBIndex"
                          >
                            <template #label>
                              <v-text-field
                                v-model="choiceB.text"
                                :label="!!choiceB.text ? choiceB.text : `Option ${choiceBIndex + 1}`"
                                append-icon="mdi-close"
                              ></v-text-field>
                            </template>
                          </v-radio>
                        </v-radio-group>
                      </v-col>
                    </v-row>
                  </section>
                  <section v-else-if="inputTypesEnum.checkboxes === answerItem.input_type">
                    <v-row>
                      <!-- checkbox option group A -->
                      <v-col>
                        <v-text-field
                          label="Option Group Label"
                          v-model="answerItem.option_group_a.label"
                        ></v-text-field>
                        <v-checkbox
                          v-for="(choiceA, choiceIndex) in answerItem.option_group_a.options"
                          :key="choiceIndex"
                        >
                          <template #label>
                            <v-text-field
                              v-model="choiceA.text"
                              :label="!!choiceA.text ? choiceA.text : `Option ${choiceIndex + 1}`"
                              append-icon="mdi-close"
                            ></v-text-field>
                          </template>
                        </v-checkbox>
                        <div>
                          <v-btn class="primary--text">Add Option</v-btn>
                        </div>
                      </v-col>
                      <!-- checkbox option group B -->
                      <v-col
                        v-if="!isObjectEmpty(answerItem.option_group_b) && !Array.isArray(answerItem.option_group_b)"
                      >
                        <v-text-field
                          label="Option Group Label"
                          v-model="answerItem.option_group_b.label"
                        ></v-text-field>
                        <v-checkbox
                          v-for="(choiceA, choiceIndex) in answerItem.option_group_b.options"
                          :key="choiceIndex"
                        >
                          <template #label>
                            <v-text-field
                              v-model="choiceA.text"
                              :label="!!choiceA.text ? choiceA.text : `Option ${choiceIndex + 1}`"
                              append-icon="mdi-close"
                            ></v-text-field>
                          </template>
                        </v-checkbox>
                        <div>
                          <v-btn class="primary--text">Add Option</v-btn>
                          <v-btn>Remove Option Group</v-btn>
                        </div>
                      </v-col>
                    </v-row>
                  </section>
                  <section v-else-if="inputTypesEnum.dropdown === answerItem.input_type">
                    <!-- dropdown select options -->
                    <div>
                      <v-text-field
                        v-for="(choiceA, choiceIndex) in answerItem.option_group_a.options"
                        :key="choiceIndex"
                        v-model="choiceA.text"
                        :label="!!choiceA.text ? choiceA.text : `Option ${choiceIndex + 1}`"
                        append-icon="mdi-close"
                      ></v-text-field>
                      <div>
                        <v-btn class="primary--text">Add Option</v-btn>
                      </div>
                    </div>
                  </section>
                  <section class="text-center" v-else>
                    <h4 class="headline red--text">Must select an input type!</h4>
                  </section>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { inputTypesEnum } from "../../../../../models/SurveyQuestion";
import { SurveyResponseActions } from "../../../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";

export default {
  async fetch({ store, params }) {
    await store.dispatch(SurveyResponseActions.FETCH_RESPONSE_GROUP_BY_ID, {
      responseId: params.responseId,
      responseGroupId: params.responseGroupId,
    });
  },

  computed: {
    survey() {
      return this.response;
    },

    // answers() {
    //   return this.responseGroup.answers;
    // },

    ...mapState("responses", {
      response: (state) => state.response,

      responseGroup: (state) => state.response_group,
    }),

    ...mapMultiRowFields("responses", ["response_group.answers"]),

    /**
     * Enum for input types.
     *
     * @returns { Object }
     */
    inputTypesEnum() {
      return inputTypesEnum;
    },
  },

  methods: {
    /**
     * Set the state data onBlur event.
     *
     * @param { Event } even
     * @return { Void }
     */
    async onBlur(event) {},
  },
};
</script>
