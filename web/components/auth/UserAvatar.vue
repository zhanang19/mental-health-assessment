<template>
  <v-card-text class="text-center">
    <v-avatar size="150">
      <v-img 
        height="150" 
        width="150" 
        :src="$auth.user.avatar || '/icon.png'"
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
    <h2 class="mt-3" v-text="$auth.user.full_name"></h2>
    <div v-text="$auth.user.email"></div>
    <div v-text="$auth.user.username"></div>
  </v-card-text>
</template>