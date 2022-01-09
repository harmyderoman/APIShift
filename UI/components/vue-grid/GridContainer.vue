<template>
  <div
    :style="gridStyles"
    class="grid-container"
    :class="{ 'centered-items': centered }"
  >
    <slot></slot>
  </div>
</template>

<script>
  module.exports = {
    props: {
      centered: {
        type: Boolean,
        required: false,
        default: true
      },
      itemWidth: {
        type: String,
        required: true
      },
      gap: {
        type: Number,
        required: false,
        default: 0
      }
    },
    computed: {
      gridStyles() {
        return {
          "grid-template-columns": `repeat(auto-fill, minmax(${this.itemWidth}, 1fr))`,
          gap: this.gap
        }
      }
    }
  }
</script>

<style scoped>
  .grid-container {
    display: grid;
  }
  .centered-items {
    justify-items: center;
    align-items: center;
  }
</style>
