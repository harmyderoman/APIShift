<template>
  <div>
    <v-app-bar dark="isDarkTheme" prominent :src="toolbarImageSrc">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"> </v-app-bar-nav-icon>

      <v-toolbar-title>Conditory</v-toolbar-title>
      <template v-slot:extension>
        <v-toolbar-item v-for="tab in tabs" :key="tab.name">
          <v-btn :to="tab.path">{{ tab.name }}</v-btn>
        </v-toolbar-item>
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
          <v-list-item v-for="path in paths" :key="path.name">
            <v-list-item-title>
              <v-btn :to="path.path">{{ path.name }}</v-btn>
            </v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>
              <v-btn href="/control">Control Panel</v-btn>
            </v-list-item-title>
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
        /**
         * Shows drawer
         * @param {boolean}
         */
        drawer: false,
        toolbarImageSrc:
          "https://64.media.tumblr.com/c382f41340942888ec22a3c6a76d19ab/tumblr_odzsg8FOoi1ul5fqko1_1280.png"
      }
    },
    computed: {
      /**
       * Return Boolean if the theme is dark
       * @returns {boolean}
       */
      isDarkTheme() {
        return window.app.$vuetify.theme.dark
      },
      /**
       * Return array of routes frpm global object
       * @returns {Array<{ path: string, name: string, id: number }>}
       */
      paths() {
        return window.app.paths
      },
      /**
       * Filtred tabs that its property tab is true
       * @returns {Array<{ path: string, name: string, id: number }>}
       */
      tabs() {
        return this.paths.filter((item) => item.tab)
      }
    },

    watch: {
      group() {
        this.drawer = false
      }
    }
  }
</script>
