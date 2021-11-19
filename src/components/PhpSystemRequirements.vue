<template>
  <div class="hello">
    {{ phpExtension.name}}
    {{ phpExtension.installed}}
  </div>
</template>

<script>
export default {
  name: 'PhpSystemRequirement',
  props: {
    phpExtension: Object
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
