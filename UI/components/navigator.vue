<template>
  <v-toolbar dark="isDarkTheme" prominent :src="toolbarImageSrc">
    <v-app-bar-nav-icon></v-app-bar-nav-icon>

    <v-toolbar-title>Conditory</v-toolbar-title>

    <v-spacer></v-spacer>

    <v-btn icon>
      <v-icon>mdi-export</v-icon>
    </v-btn>
    <!-- <template v-slot:extension>
      <v-tabs align-with-title>
        <v-tab>Home</v-tab>
        <v-tab>Menu</v-tab>
        <v-tab>Stuff</v-tab>
        <v-tab>Get direction</v-tab>
      </v-tabs>
    </template> -->
  </v-toolbar>
</template>

<script>
  module.exports = {
    data() {
      return {
        toolbarImageSrc:
          "https://64.media.tumblr.com/c382f41340942888ec22a3c6a76d19ab/tumblr_odzsg8FOoi1ul5fqko1_1280.png"
      }
    },
    computed: {
      isDarkTheme() {
        return window.app.$vuetify.theme.dark
      }
    }
  }
</script>
