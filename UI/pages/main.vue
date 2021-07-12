<script>
  // This shit is made for scripting
  module.exports = {
    vuetify: new Vuetify({
      theme: {
        dark: false,
        themes: {
          light: {
            primary: "#1976D2"
          },
          dark: {
            primary: "#1976D2"
          }
        }
      }
    }),
    data() {
      return {
        drawer: null
      }
    },
    created() {
      app.apishift.setSubtitle("Welcome!")
    }
  }
</script>

<template>
  <v-main>
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex>
          <h1>Welcome! :)</h1>
          <hr />
          <p>
            Go to <a href="/control">Control Panel</a> to start working with the
            system
          </p>
        </v-flex>
      </v-layout>
    </v-container>
  </v-main>
</template>

<style>
  /* Please style this crap, with style */
</style>
