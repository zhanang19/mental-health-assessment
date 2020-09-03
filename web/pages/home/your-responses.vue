<template>
  <v-container class="px-10">
    <div v-if="!isLoading && hasSurveys">
      <v-card
        :color="item.color_theme"
        :dark="!item.color_theme.includes(['white'])"
        class="my-3"
        outlined
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
          </v-list-item>
        </v-card-text>
        <v-card-actions class="pa-5">
          <v-spacer></v-spacer>

          <v-btn class="rounded-lg" @click="takeSurvey(item)" light large bottom right>
            <span>Continue</span>
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>
    <!-- if responses are empty -->
    <div v-else-if="!isLoading && !hasSurveys">
      <v-card class="my-3 rounded-lg" min-height="260">
        <v-card-text>There are no survey forms available yet.</v-card-text>
      </v-card>
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
            <span>Continue</span>
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

