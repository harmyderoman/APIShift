<script>
  // This shit is made for scripting
  module.exports = {
    data() {
      return {}
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
          <h1>Main Page!</h1>
          <h2>Text about our Conditory!</h2>
          <h2>Best Conditory ever!</h2>
        </v-flex>
      </v-layout>
    </v-container>
  </v-main>
</template>

<style>
  /* Please style this crap, with style */
</style>
