<template>
  <v-form @submit.prevent="login()">
    <v-card-text>
      <v-row justify="center" class="mb-5">
        <div class="text-center">
          <v-avatar size="125">
            <v-img 
              height="125"
              width="125"
              src="/icon.png"
            ></v-img>
          </v-avatar>
        </div>
      </v-row>
      <div class="title text-center mb-10">
        <div 
          class="font-weight-regular">
          Welcome to
        </div>
        <div class="display-1">
          Laranuxt7 Admin Dashboard
        </div>
      </div>
      
      <v-slide-x-transition hide-on-leave>
        <v-card v-if="type === null">
          <v-toolbar class="d-flex justify-center" color="transparent" flat>
            <v-toolbar-title>Login with...</v-toolbar-title>
          </v-toolbar>
          <v-list>
            <v-list-item @click="type = 'email'">
              <v-list-item-content>
                <v-list-item-title>Email Address</v-list-item-title>
              </v-list-item-content>
              <v-list-item-icon>
                <v-icon size="64">mdi-email-outline</v-icon>
              </v-list-item-icon>
            </v-list-item>
            <v-list-item @click="type = 'username'">
              <v-list-item-content>
                <v-list-item-title>Username</v-list-item-title>
              </v-list-item-content>
              <v-list-item-icon>
                <v-icon size="64">mdi-account-outline</v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card>
        <section v-else>
          <v-btn @click="type = null" class="mb-3" text>
            <v-icon left>mdi-arrow-left</v-icon>
            GO BACK
          </v-btn>
          
          <v-text-field
            v-show="type === 'username'"
            append-icon="mdi-account-outline"
            :disabled="loggingIn"
            v-model="credentials.username"
            :error="!!errors['username']"
            :error-messages="errors['username']"
            label="Username"
            solo
          ></v-text-field>
          <v-text-field
            v-show="type === 'email'"
            append-icon="mdi-email-outline"
            :disabled="loggingIn"
            v-model="credentials.email"
            :error="!!errors['email']"
            :error-messages="errors['email']"
            label="Email"
            solo
          ></v-text-field>
          <v-text-field
            label="Password"
            append-icon="mdi-lock-outline"
            :disabled="loggingIn"
            :error="!!errors['password']"
            :error-messages="errors['password']"
            v-model="credentials.password"
            type="password"
            solo
          ></v-text-field>
          <div class="text-center">
            <div 
              v-if="false"
              @click="$router.push({ name: 'register' })"
              class="mb-5 primary--text" 
              style="cursor: pointer">
              Forgot your password?
            </div>
            <div class="mb-2">
              <v-btn 
                type="submit"
                class="primary--text"
                block
                :loading="loggingIn"
                x-large
                rounded>
                Sign In
                <v-icon right>mdi-chevron-right</v-icon>
              </v-btn>
            </div>
          </div>
        </section>
      </v-slide-x-transition>
    </v-card-text>
  </v-form>
</template>

<script>
export default {
  data: () => ({
    loggingIn: false,
    type: null,
    errors: {},
    credentials: {
      username: '',
      email: '',
      password: '',
    },
  }),

  methods: {
    async login() {
      let credentials = this.credentials
      if (this.type === 'username') {
        delete credentials.email
      } else {
        delete credentials.username
      }
      
      try {
        this.loggingIn = true
        await this.$helpers.loader()
        await this.$auth.loginWith('local', {
          data: credentials
        })

        this.$helpers.notify({
          type: 'success',
          message: 'You have logged in.',
        })
        
        this.$router.push({
          name: 'home'
        })
      } catch (error) {
        console.log(error)
        let message
        if (error.response.status === 422) {
          this.errors = error.response.data.errors
          message = error.response.data.message
        }

        if (error.response.status === 403) {
          message = error.response.data.message
        }

        this.$helpers.notify({
          type: 'error',
          message: message || 'Sorry. An error has occurred, try again later.'
        })
      } finally {
        this.loggingIn = false
        await this.$helpers.loader()
      }
    },
  }
}
</script>