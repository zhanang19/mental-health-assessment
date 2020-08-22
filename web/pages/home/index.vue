<template>
  <v-container>
    <v-container>
      <h1 class="white--text">
        <span>Hi there, {{ $auth.user.full_name || 'Anonymous User' }}</span>
      </h1>
    </v-container>
    <v-row justify="center" align="center">
      <v-col>
        <v-card class="my-3 rounded-lg" v-for="item in 5" :key="item">
          <v-card-text>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="headline mb-3">Survey Number One</v-list-item-title>
              <div class="subtitle-1">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat atque quae vel, laborum iure ipsam sint natus at, dolor laudantium non provident nostrum, voluptatibus accusantium in! Deleniti, et sapiente! Perferendis.</div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
            <v-btn class="rounded-lg" color="primary" width="225" large depressed>Take Survey</v-btn>
          </v-card-actions>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AppConfirmationDialog from "@/components/alerts/AppConfirmationDialog";
import { mapState } from "vuex";

export default {
  head() {
    return {
      title: `${process.env.appName} | Home`,
    };
  },

  components: {
    AppConfirmationDialog,
  },
};
</script>

