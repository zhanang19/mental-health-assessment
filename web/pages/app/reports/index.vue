<template>
  <v-container>
    <v-container>
      <h1 class="white--text">
        <span>Reports</span>
      </h1>
    </v-container>
    <v-row justify="center" align="center">
      <v-col></v-col>
    </v-row>
  </v-container>
</template>

<script>
import AppConfirmationDialog from "@/components/alerts/AppConfirmationDialog";
import { UserActions } from "../../../utils/StoreTypes";
import { mapState } from "vuex";

export default {
  head() {
    return {
      title: `${process.env.appName} | Reports`,
    };
  },

  components: {
    AppConfirmationDialog,
  },
};
</script>

