<template>
  <v-main app>
    <v-container>
      <v-toolbar color="transparent" flat extended>
        <v-toolbar-title>
          <h2>Favorites</h2>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn class="primary--text" rounded large>
          <v-icon left>mdi-plus</v-icon>
          ADD
        </v-btn>

        <template v-slot:extension>
          <v-text-field></v-text-field>
        </template>
      </v-toolbar>

      <v-row justify="center" align="center">
        <v-col>
          <v-list style="right: 0;" class="rounded-xl" three-line>
            <v-list-item three-line v-for="(item, i) in 20" :key="i">
              <v-list-item-avatar size="70">
                <v-img src="/icon-tile.png"></v-img>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title>Title</v-list-item-title>
                <v-list-item-subtitle>Cool</v-list-item-subtitle>
                <v-list-item-subtitle>Cool Enough</v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
                <v-dialog origin="50px 50px" scrollable max-width="500">
                  <template v-slot:activator="{ on }">
                    <v-btn :id="`dialog-${i}`" v-on="on" class="primary--text">DIALOG</v-btn>
                  </template>
                  <v-card>
                    <v-toolbar>
                      <v-toolbar-title>Amazing Dialog</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>AMAZING</v-card-text>
                    <v-card-actions>
                      <v-btn>Just Amazing</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-list-item-action>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import AppNavbar from "@/components/layouts/AppNavbar";

export default {
  head() {
    return {
      title: `App | Favorites`
    };
  }
};
</script>