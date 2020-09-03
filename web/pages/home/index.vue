<template>
  <v-container class="px-10">
    <div v-if="!isLoading && hasFilteredSurveys">
      <v-card
        :color="item.color_theme"
        :dark="!item.color_theme.includes(['white'])"
        class="my-3"
        outlined
        min-height="150"
        v-for="(item, index) in filteredSurveys"
        :key="index"
      >
        <v-card-text>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="headline mb-3" v-text="item.title"></v-list-item-title>
              <v-list-item-subtitle v-text="item.subtitle"></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-card-text>
        <v-card-actions class="pa-5">
          <v-spacer></v-spacer>

          <v-btn class="rounded-lg" @click="takeSurvey(item)" light large bottom right>
            <span>Start</span>
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>

    <!-- if responses are available but filtered surveys are not -->
    <div v-else-if="!isLoading && hasSurveys && !hasFilteredSurveys">
      <v-card-text>
        <div class="text-center">
          <img src="/illustrations/survey.svg" class="mb-3" height="300" alt srcset />
          <div
            class="py-3 subtitle-2"
          >You have already started out the other survey forms. Click the button to proceed.</div>
          <v-btn
            :to="{ name: 'home-your-responses' }"
            class="rounded-lg"
            color="primary"
            width="125"
            large
            depressed
          >Proceed</v-btn>
        </div>
      </v-card-text>
    </div>

    <!-- if responses are empty -->
    <div v-else-if="!isLoading && !hasSurveys">
      <v-card-text>
        <div class="text-center">
          <img src="/illustrations/survey-empty.svg" class="mb-3" height="300" alt srcset />
          <div class="py-3 subtitle-2">There are no survey forms available yet.</div>
        </div>
      </v-card-text>
    </div>

    <!-- loading skeleton placeholder -->
    <div v-else>
      <v-card v-for="(item, index) in 5" outlined min-height="150" :key="index" class="my-3">
        <v-card-text>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                <v-skeleton-loader type="heading"></v-skeleton-loader>
              </v-list-item-title>
              <v-list-item-subtitle>
                <v-skeleton-loader type="list-item"></v-skeleton-loader>
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-card-text>
        <v-card-actions class="pa-5">
          <v-spacer></v-spacer>

          <v-btn class="rounded-lg" disabled light large bottom right>
            <span>Start</span>
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>
  </v-container>
</template>

<script>
import AppConfirmationDialog from "@/components/alerts/AppConfirmationDialog";
import { mapState } from "vuex";
import { SurveyActions } from "../../utils/StoreTypes";

export default {
  head() {
    return {
      title: `${process.env.appName} | Home`,
    };
  },

  components: {
    AppConfirmationDialog,
  },

  async created() {
    this.isLoading = true;

    await this.$store.dispatch(SurveyActions.FETCH_ALL);

    setTimeout(() => {
      this.isLoading = false;
    }, 500);
  },

  data: () => ({
    isLoading: false,
  }),

  computed: {
    hasFilteredSurveys() {
      return this.filteredSurveys.length > 0;
    },

    filteredSurveys() {
      return this.surveys.filter(
        (item) =>
          !this.$auth.user.responses
            .map((response) => response.survey_id)
            .includes(item.id)
      );
    },

    hasSurveys() {
      return this.surveys.length > 0;
    },

    ...mapState("surveys", {
      surveys: (state) => state.surveys,
    }),
  },

  methods: {
    async takeSurvey(item) {
      const response = await this.$store.dispatch(SurveyActions.TAKE_SURVEY, {
        surveyId: item.id,
        slug: item.slug,
      });

      await this.$router.push({
        name: "surveys-slug",
        params: { slug: item.slug },
      });
    },
  },
};
</script>

