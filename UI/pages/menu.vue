<script>
  // This shit is made for scripting
  module.exports = {
    name: "Menu",
    components: {
      GridContainer: APIShift.API.getComponent("vue-grid/GridContainer", true)
    },
    data() {
      return {
        desserts: []
      }
    },
    created() {
      app.apishift.setSubtitle("Menu")

      APIShift.API.request(
        "Conditory\\Desserts",
        "getAllDesserts",
        {},
        (res) => (this.desserts = res.data)
      )
    }
  }
</script>

<template>
  <v-main>
    <grid-container centered>
      <v-card
        v-for="item in desserts"
        :key="item.id"
        :loading="false"
        class="grid-item"
        max-width="374"
      >
        <template slot="progress">
          <v-progress-linear
            color="deep-purple"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>

        <v-img height="250" :src="item.image"></v-img>

        <v-card-title>{{ item.name }}</v-card-title>

        <v-card-text>
          <div>Dessert description...</div>
        </v-card-text>

        <v-divider class="mx-4"></v-divider>

        <v-card-actions>
          <v-btn color="deep-purple lighten-2" text> Add to cart </v-btn>
          <v-btn color="deep-purple lighten-2" text> Buy now </v-btn>
        </v-card-actions>
      </v-card>
    </grid-container>
  </v-main>
</template>

<style>
  /* Please style this crap, with style */
</style>
