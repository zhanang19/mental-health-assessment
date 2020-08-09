<template>
  <v-main :class="$vuetify.theme.dark ? 'bg' : 'bg grey lighten-5'" app>
    <v-container fill-height>
      <v-row 
        :class="{
          'mr-16': !$vuetify.breakpoint.sm 
            && !$vuetify.breakpoint.xs
            && !$vuetify.breakpoint.md,
          'pr-16': $vuetify.breakpoint.xl,
        }"
        justify="center" 
        align="center">
        <v-col 
          class="d-none d-lg-flex d-md-flex"
          xl="8"
          lg="7" 
          md="6" 
          sm="12"
          cols="12">
          <v-container fill-height fluid>
            <v-row align="center"
              justify="center">
              <v-col>
                <div class="d-flex justify-start">
                  <img 
                    src="/illustrations/login.svg" 
                    :height="$vuetify.breakpoint.xl ? '800' 
                      : $vuetify.breakpoint.lg ? '450' 
                      : $vuetify.breakpoint.md ? '450'
                      : '450'" 
                    width="100%">
                </div>
              </v-col>
            </v-row>
          </v-container>
        </v-col>
        <v-col 
          xl="4"
          lg="5"
          md="6"
          sm="10"
          cols="12">
          <SignIn />
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import SignIn from '@/components/auth/SignIn'

export default {
  auth: 'guest',

  head () {
    return {
      title: 'App | Login',
    }
  },
  
  layout: 'empty',
  
  components: {
    SignIn,
  },
}
</script>

<style scoped>
.bg {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  background: url("/waves/default/wave-7.svg") no-repeat center center;
  /* background: url("https://images.pexels.com/photos/935756/pexels-photo-935756.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940") no-repeat center center; */
  background-size: cover;
}
</style>