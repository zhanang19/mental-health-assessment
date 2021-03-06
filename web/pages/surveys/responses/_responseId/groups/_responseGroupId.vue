<template>
  <div>
    <v-container>
      <v-row justify="center" align="center">
        <v-col lg="8" md="10" sm="11" xs="12">
          <v-alert
            class="rounded-lg mb-10"
            type="info"
            border="left"
            colored-border
            color="cyan"
            elevation="2"
          >
            <div class="title">Instructions</div>
            <v-card flat color="transparent" min-height="250">
              <v-card-text class="pa-5">
                <div
                  style="text-decoration: none"
                  v-html="
                    responseGroup.instructions ||
                      `There aren't any instructions.`
                  "
                ></div>
              </v-card-text>
            </v-card>
          </v-alert>

          <v-form ref="form" @submit.prevent="save()">
            <!-- START: Survey Question Group v-for questions -->
            <v-card
              class="rounded-lg mb-10"
              v-for="(answerItem, answerIndex) in answers"
              :key="answerIndex"
            >
              <div class="headline pa-3">
                <span v-text="answerItem.question"></span>
                <v-tooltip v-if="answerItem.required" bottom>
                  <template #activator="{ on, attrs }">
                    <span v-on="on" v-bind="attrs" class="error--text">*</span>
                  </template>
                  <span>This field is required.</span>
                </v-tooltip>
              </div>
              <v-card-text>
                <!-- form options -->
                <v-row>
                  <v-col lg="12" md="12" sm="12" xs="12">
                    <section
                      v-if="
                        inputTypesEnum.shortAnswer === answerItem.input_type
                      "
                    >
                      <v-text-field
                        v-model="answerItem.answer_a"
                        label="Your answer here"
                        :rules="
                          answerItem.required
                            ? [v => !!v || 'This field is required.']
                            : [v => true]
                        "
                      ></v-text-field>
                    </section>
                    <section
                      v-else-if="
                        inputTypesEnum.paragraph === answerItem.input_type
                      "
                    >
                      <v-textarea
                        v-model="answerItem.answer_a"
                        label="Your answer here"
                        :rules="
                          answerItem.required
                            ? [v => !!v || 'This field is required.']
                            : [v => true]
                        "
                      ></v-textarea>
                    </section>
                    <section
                      v-else-if="
                        inputTypesEnum.multipleChoice === answerItem.input_type
                      "
                    >
                      <v-row>
                        <!-- option group A -->
                        <v-col>
                          <div
                            class="headline"
                            v-text="answerItem.option_group_a.label"
                          ></div>
                          <v-radio-group
                            v-model="answerItem.answer_a"
                            :rules="
                              answerItem.required
                                ? [v => !!v || 'This field is required.']
                                : [v => true]
                            "
                            column
                          >
                            <v-radio
                              :value="choiceA.text"
                              v-for="(choiceA, choiceIndex) in answerItem
                                .option_group_a.options"
                              :label="
                                !!choiceA.text
                                  ? choiceA.text
                                  : `Option ${choiceIndex + 1}`
                              "
                              :key="choiceIndex"
                            ></v-radio>
                          </v-radio-group>
                        </v-col>
                        <!-- option group B -->
                        <v-col
                          v-if="
                            !isObjectEmpty(answerItem.option_group_b) &&
                              !Array.isArray(answerItem.option_group_b)
                          "
                        >
                          <div v-text="answerItem.option_group_b.label"></div>
                          <v-radio-group
                            v-model="answerItem.answer_b"
                            :rules="
                              answerItem.required
                                ? [v => !!v || 'This field is required.']
                                : [v => true]
                            "
                            column
                          >
                            <v-radio
                              :value="choiceB.text"
                              v-for="(choiceB, choiceBIndex) in answerItem
                                .option_group_b.options"
                              :label="
                                !!choiceB.text
                                  ? choiceB.text
                                  : `Option ${choiceBIndex + 1}`
                              "
                              :key="choiceBIndex"
                            ></v-radio>
                          </v-radio-group>
                        </v-col>
                      </v-row>
                    </section>
                    <section
                      v-else-if="
                        inputTypesEnum.checkboxes === answerItem.input_type
                      "
                    >
                      <v-row>
                        <!-- checkbox option group A -->
                        <v-col>
                          <div v-text="answerItem.option_group_a.label"></div>
                          <v-checkbox
                            v-model="answerItem.answer_a"
                            :value="choiceA.text"
                            v-for="(choiceA, choiceIndex) in answerItem
                              .option_group_a.options"
                            :label="
                              !!choiceA.text
                                ? choiceA.text
                                : `Option ${choiceIndex + 1}`
                            "
                            :rules="
                              answerItem.required
                                ? [v => !!v || 'This field is required.']
                                : [v => true]
                            "
                            :key="choiceIndex"
                          ></v-checkbox>
                        </v-col>
                        <!-- checkbox option group B -->
                        <v-col
                          v-if="
                            !isObjectEmpty(answerItem.option_group_b) &&
                              !Array.isArray(answerItem.option_group_b)
                          "
                        >
                          <div v-text="answerItem.option_group_b.label"></div>
                          <v-checkbox
                            v-model="answerItem.answer_b"
                            :value="choiceB.text"
                            v-for="(choiceB, choiceIndex) in answerItem
                              .option_group_b.options"
                            :label="
                              !!choiceB.text
                                ? choiceB.text
                                : `Option ${choiceIndex + 1}`
                            "
                            :rules="
                              answerItem.required
                                ? [v => !!v || 'This field is required.']
                                : [v => true]
                            "
                            :key="choiceIndex"
                          ></v-checkbox>
                        </v-col>
                      </v-row>
                    </section>
                    <section
                      v-else-if="
                        inputTypesEnum.dropdown === answerItem.input_type
                      "
                    >
                      <!-- dropdown select options -->
                      <div>
                        <v-select
                          :items="answerItem.option_group_a.options"
                          item-text="text"
                          item-value="text"
                          v-model="answerItem.answer_a"
                          :rules="
                            answerItem.required
                              ? [v => !!v || 'This field is required.']
                              : [v => true]
                          "
                          :label="
                            !!answerItem.option_group_a.label
                              ? answerItem.option_group_a.label
                              : `Option ${choiceIndex + 1}`
                          "
                        ></v-select>
                      </div>
                    </section>
                    <section class="text-center" v-else>
                      <span class="subtitle-2">Sorry some error occurred.</span>
                    </section>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn large min-width="125" type="submit">Submit</v-btn>
            </v-card-actions>
          </v-form>
        </v-col>
      </v-row>
    </v-container>

    <!-- next response group dialog -->
    <app-confirmation-dialog
      v-model="dialogController.next"
      max-width="500"
      :color-theme="colorTheme"
      @confirmed="
        $router.replace({
          name: `surveys-responses-responseId-groups-responseGroupId`,
          params: {
            responseId: $route.params.responseId,
            responseGroupId: nextResponseGroup.id
          }
        })
      "
    >
      <template #confirmation-text>
        You have completed answering this sub-scale. Do you wish to continue to
        the next sub-scale test?
      </template>
      <template #confirmed-text>
        Redirecting...
      </template>
    </app-confirmation-dialog>

    <!-- app dialog response group description -->
    <app-dialog
      v-model="dialogController.description"
      :color-theme="colorTheme"
      @confirmed="dialogController.description = !dialogController.description"
    >
      <template #text>
        <div v-html="responseGroup.description || `No description.`"></div>
      </template>
    </app-dialog>
  </div>
</template>

<script>
import { inputTypesEnum } from "../../../../../models/SurveyQuestion";
import { SurveyResponseActions } from "../../../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";

import AppConfirmationDialog from "@/components/alerts/AppConfirmationDialog";
import AppDialog from "@/components/AppDialog";

export default {
  props: {
    colorTheme: String
  },

  components: { AppConfirmationDialog, AppDialog },

  data: () => ({
    nextResponseGroup: {},
    dialogController: {
      next: false,
      description: true
    }
  }),

  async fetch({ store, params }) {
    await store.dispatch(SurveyResponseActions.FETCH_RESPONSE_GROUP_BY_ID, {
      responseId: params.responseId,
      responseGroupId: params.responseGroupId
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
      response: state => state.response,

      responseGroup: state => state.response_group
    }),

    ...mapMultiRowFields("responses", ["response_group.answers"]),

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
    /**
     * Set the state data onBlur event.
     *
     * @param { Event } even
     * @return { Void }
     */
    async onBlur(event) {},

    async save() {
      if (this.$refs.form.validate()) {
        const response = await this.$store.dispatch(
          SurveyResponseActions.UPDATE_RESPONSE_GROUP_BY_ID,
          {
            responseId: this.$route.params.responseId,
            responseGroupId: this.$route.params.responseGroupId
          }
        );

        console.log(
          response,
          this.responseGroup,
          new Array(...this.response.response_groups)
        );

        await this.next();

        return this.$helpers.notify({
          type: "success",
          message: response?.message
        });
      } else {
        return this.$helpers.notify({
          type: "error",
          message:
            "Please fill in the required fields annotated via red apostrophe."
        });
      }
    },

    /**
     * Get the next response group based on the current response group.
     *
     * @var SurveyResponseGroup
     */
    next(responseGroup) {
      const responseGroups = new Array(...this.response.response_groups).filter(
        item => !item.is_completed
      );

      const currentIndex = responseGroups.findIndex(
        item => item.id === this.responseGroup.id
      );

      let nextResponseGroup = responseGroups[currentIndex + 1];

      if (!(nextResponseGroup === undefined)) {
        this.nextResponseGroup = nextResponseGroup;

        this.dialogController.next = !this.dialogController.next;

        console.log("HAS NEXT INDEX", nextResponseGroup);
      } else {
        console.log("DONT HAVE NEXT INDEX");
      }
    }
  }
};
</script>
