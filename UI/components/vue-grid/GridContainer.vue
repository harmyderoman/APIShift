<template>
  <div class="grid-container" :class="{ 'centered-items': centered }">
    <slot></slot>
  </div>
</template>

<script>
  module.exports = {
    props: {
      centered: {
        type: Boolean,
        required: false
      }
    }
  }
</script>

<style scoped>
  .grid-container {
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    display: grid;
    gap: 1rem;
  }
  .centered-items {
    justify-items: center;
    align-items: center;
  }
</style>
