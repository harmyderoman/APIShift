<script>
  // This shit is made for scripting
  module.exports = {
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
    <h1>Menu Page!</h1>
    <div class="grid-container">
      <!-- <v-layout align-center justify-center> -->
      <v-card
        v-for="item in desserts"
        :key="item.id"
        :loading="false"
        class="mx-auto my-12 grid-item"
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
          <v-row align="center" class="mx-0">
            <v-rating
              :value="4.5"
              color="amber"
              dense
              half-increments
              readonly
              size="14"
            ></v-rating>

            <div class="grey--text ms-4">4.5 (413)</div>
          </v-row>

          <div class="my-4 text-subtitle-1">$ • Italian, Cafe</div>

          <div>
            Small plates, salads & sandwiches - an intimate setting with 12
            indoor seats plus patio seating.
          </div>
        </v-card-text>

        <v-divider class="mx-4"></v-divider>

        <v-card-title>Tonight's availability</v-card-title>

        <v-card-actions>
          <v-btn color="deep-purple lighten-2" text> Reserve </v-btn>
        </v-card-actions>
      </v-card>
      <!-- </v-layout> -->
    </div>
  </v-main>
</template>

<style>
  /* Please style this crap, with style */
  .grid-container {
    grid-template-columns: 1fr 1fr 1fr;
    /* grid-template-rows: 1fr 1fr 1fr; */
    display: grid;
    column-gap: 15px;
    row-gap: 100px;
    justify-items: center;
    align-items: center;
  }
  .grid-item {
  }
</style>
