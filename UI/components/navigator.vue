<template>
  <div>
    <v-app-bar dark="isDarkTheme" prominent :src="toolbarImageSrc">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"> </v-app-bar-nav-icon>

      <v-toolbar-title>Conditory</v-toolbar-title>
      <template v-slot:extension>
        <v-toolbar-item><v-btn>Home</v-btn></v-toolbar-item>
        <v-toolbar-item><v-btn>Menu</v-btn></v-toolbar-item>
      </template>

      <v-spacer></v-spacer>

      <v-btn icon> <v-icon>mdi-cart-outline</v-icon> </v-btn>
      <v-btn icon> <v-icon>mdi-account</v-icon> </v-btn>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" absolute temporary>
      <v-list nav dense>
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Menu</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Cart</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Account</v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-title
              ><a href="/control">Control Panel</a></v-list-item-title
            >
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
  module.exports = {
    data() {
      return {
        group: null,
        drawer: false,
        toolbarImageSrc:
          "https://64.media.tumblr.com/c382f41340942888ec22a3c6a76d19ab/tumblr_odzsg8FOoi1ul5fqko1_1280.png"
      }
    },
    computed: {
      isDarkTheme() {
        return window.app.$vuetify.theme.dark
      }
    },

    watch: {
      group() {
        this.drawer = false
      }
    }
  }
</script>
