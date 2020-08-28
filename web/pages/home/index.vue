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
        <div v-if="!isLoading">
          <v-card class="my-3 rounded-lg" v-for="item in surveys" :key="item">
            <v-card-text>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title class="headline mb-3" v-text="item.title"></v-list-item-title>
                  <v-list-item-subtitle v-text="item.subtitle"></v-list-item-subtitle>
                  <div class="subtitle-1" v-text="item.description || 'No description.'"></div>
                </v-list-item-content>
              </v-list-item>
              <v-card-actions>
                <v-btn class="rounded-lg" color="primary" width="225" large depressed>Take Survey</v-btn>
              </v-card-actions>
            </v-card-text>
          </v-card>
        </div>
        <div v-else>
          <v-card v-for="(item, index) in 5" :key="index" class="rounded-lg my-3">
            <v-card-text>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title class="headline mb-3">
                    <v-skeleton-loader type="heading"></v-skeleton-loader>
                  </v-list-item-title>
                  <div class="subtitle-1">
                    <v-skeleton-loader type="paragraph"></v-skeleton-loader>
                    <v-skeleton-loader type="paragraph"></v-skeleton-loader>
                  </div>
                </v-list-item-content>
              </v-list-item>
              <v-card-actions>
                <v-btn
                  class="rounded-lg"
                  :disabled="true"
                  color="primary"
                  width="225"
                  large
                  depressed
                >Take Survey</v-btn>
              </v-card-actions>
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

  data: () => ({
    isLoading: false,
  }),

  computed: {
    ...mapState("surveys", {
      surveys: (state) => state.surveys,
    }),
  },

  async created() {
    this.isLoading = true;

    await this.$store.dispatch(SurveyActions.FETCH_ALL);

    setTimeout(() => {
      this.isLoading = false;
    }, 500);
  },

  components: {
    AppConfirmationDialog,
  },
};
</script>

