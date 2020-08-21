<template>
  <v-form ref="form" @submit.prevent="submit()">
    <v-card color="transparent" flat>
      <v-toolbar color="transparent" flat>
        <v-toolbar-title>Security</v-toolbar-title>
      </v-toolbar>
      <v-divider></v-divider>
      <v-card-text>
        <v-text-field
          label="New Password"
          v-model="credentials.password"
          :rules="rules.password"
          hint="Your new password must be at least 8 characters long."
          :error="!!errors['password']"
          :error-messages="errors['password']"
          persistent-hint
          filled
        ></v-text-field>
        <v-text-field
          label="Confirmation"
          v-model="credentials.password_confirmation"
          :rules="rules.password_confirmation"
          hint="Please confirm your password"
          :error="!!errors['password_confirmation']"
          :error-messages="errors['password_confirmation']"
          persistent-hint
          filled
        ></v-text-field>
      </v-card-text>
      
      <v-card-actions class="justify-center">
        <v-btn 
          type="submit" 
          color="primary" 
          depressed 
          large 
          width="225">
          UPDATE PASSWORD
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>

<script>
import { mapFields } from 'vuex-map-fields'

export default {
  data: () => ({
    credentials: {
      password: null,
      password_confirmation: null
    },
    rules: {
      password: [
        v => !!v || 'New password is required.'
      ],
      password_confirmation: [
        v => !!v || 'Password confirmation is required.'
      ],
    },
  }),
  
  computed: {
    ...mapFields([
      'errors'
    ])
  },
  
  methods: {
    submit () {
      if (this.$refs.form.validate()) {
        this.$store.dispatch('updatePassword', this.credentials)
      }
    }
  },
}
</script>