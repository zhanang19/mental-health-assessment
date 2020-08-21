<template>
  <v-card-text class="text-center">
    <v-avatar size="150">
      <v-img
        height="150"
        width="150"
        :src="$auth.user.avatar || '/default/avatar.png'"
      >
        <template v-slot:placeholder>
          <v-img
            height="150"
            width="150"
            src="/icon.png"
          ></v-img>
        </template>
      </v-img>
    </v-avatar>
    <div class="headline mt-5 primary--text" v-text="$auth.user.full_name"></div>
    <div v-text="$auth.user.email"></div>
    <!-- <div v-text="$auth.user.username"></div> -->
  </v-card-text>
</template>
