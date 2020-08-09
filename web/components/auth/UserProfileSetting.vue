<template>
  <v-form @submit.prevent="submit()">
    <v-card color="transparent" flat>
      <v-toolbar color="transparent" flat>
        <v-toolbar-title>Profile</v-toolbar-title>
      </v-toolbar>
      <v-divider></v-divider>
      <v-card-text>
        <div class="text-center mb-3">
          <v-avatar 
            @click="$refs.avatar.click()"
            style="cursor: pointer" 
            size="225">
            <v-img
              height="225"
              width="225"
              :src="!!avatar ? avatar : '/icon.png'"
            ></v-img>
            <input 
            ref="avatar" 
            hidden 
            type="file" 
            accept="image/*" 
            @change="onFileChange($event)">
          </v-avatar>
        </div>
        <v-text-field
          label="Username"
          v-model="username"
          hint="Required"
          :error="!!errors['username']"
          :error-messages="errors['username']"
          persistent-hint
          filled
        ></v-text-field>
        <v-text-field
          label="Email"
          v-model="email"
          hint="Required"
          :error="!!errors['email']"
          :error-messages="errors['email']"
          persistent-hint
          filled
        ></v-text-field>
        <v-text-field
          label="First Name"
          v-model="first_name"
          hint="Required"
          :error="!!errors['first_name']"
          :error-messages="errors['first_name']"
          persistent-hint
          filled
        ></v-text-field>
        <v-text-field
          label="Middle Name"
          v-model="middle_name"
          :error="!!errors['middle_name']"
          :error-messages="errors['middle_name']"
          persistent-hint
          filled
        ></v-text-field>
        <v-text-field
          label="Last Name"
          v-model="last_name"
          hint="Required"
          :error="!!errors['last_name']"
          :error-messages="errors['last_name']"
          persistent-hint
          filled
        ></v-text-field>
        <v-autocomplete
          label="Time Zone"
          v-model="time_zone" 
          :items="timezones"
          item-text="name"
          item-value="raw"
          :error="!!errors['time_zone']"
          :error-messages="errors['time_zone']"
          filled
        ></v-autocomplete>
      </v-card-text>
      
      <v-card-actions class="justify-center">
        <v-btn 
          type="submit" 
          color="primary" 
          depressed 
          large 
          width="225">
          SAVE
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>

<script>
import { mapFields } from 'vuex-map-fields'
import { mapState } from 'vuex'

export default {
  data: () => ({
    loading: false,
  }),
  
  async created() {
    this.loading = true
    await this.$store.dispatch('timezones/fetchAll')
    await setTimeout(() => {
      this.loading = false
    }, 100)
  },
  
  computed: {
    ...mapState({
      timezones: state => state.timezones.timezones
    }),
    
    ...mapFields([
      'auth.user.avatar',
      'auth.user.username',
      'auth.user.full_name',
      'auth.user.first_name',
      'auth.user.last_name',
      'auth.user.middle_name',
      'auth.user.email',
      'auth.user.time_zone',
      'errors'
    ]),
  },

  methods: {
    async onFileChange (e) {
      const file = e.target.files[0]
      if (file == null) {
        return
      }

      this.avatar = await this.base64Encode(file)
    },

    submit () {
      this.$store.dispatch('updateProfile')
    }
  }
}
</script>