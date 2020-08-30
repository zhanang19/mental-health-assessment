<template>
  <v-container>
    <v-row justify="center" align="center">
      <v-col xl="6" lg="7" md="8" sm="12" xs="12">
        <v-container>
          <h1 class="white--text">
            <span>Hi there, {{ $auth.user.full_name || 'Anonymous User' }}</span>
          </h1>
          <v-btn @click="isLoading = !isLoading">Loading</v-btn>
        </v-container>
        <div v-if="!isLoading && hasSurveys">
          <v-card
            class="my-3 rounded-lg"
            elevation="5"
            min-height="150"
            v-for="(item, index) in surveys"
            :key="index"
          >
            <v-card-text>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title class="headline mb-3" v-text="item.title"></v-list-item-title>
                  <v-list-item-subtitle v-text="item.subtitle"></v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                  <v-btn
                    @click="takeSurvey(item)"
                    class="rounded-lg"
                    color="primary"
                    large
                    depressed
                  >Take Survey</v-btn>
                </v-list-item-action>
              </v-list-item>
              <v-card-actions></v-card-actions>
            </v-card-text>
          </v-card>
        </div>
        <div v-else-if="!isLoading && !hasSurveys">
          <v-card class="my-3 rounded-lg" min-height="260">
            <v-card-text>There are no survey forms available yet.</v-card-text>
          </v-card>
        </div>
        <div v-else>
          <v-card
            v-for="(item, index) in 5"
            elevation="5"
            min-height="150"
            :key="index"
            class="rounded-lg my-3"
          >
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
                <v-list-item-action>
                  <v-btn
                    class="rounded-lg"
                    :disabled="true"
                    color="primary"
                    large
                    depressed
                  >Take Survey</v-btn>
                </v-list-item-action>
              </v-list-item>
            </v-card-text>
          </v-card>
        </div>
      </v-col>
    </v-row>
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

