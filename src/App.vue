<template>
  <div id="nav">
    <a :class="[currentRouteName === 'Home' ? 'router-link-exact-active' : '']">Home</a> |
    <a :class="[currentRouteName === 'CheckSystemRequirements' ? 'router-link-exact-active' : '']">Check System Requirements</a> |
    <a :class="[currentRouteName === 'Licence' ? 'router-link-exact-active' : '']">Licence</a> |
    <a :class="[currentRouteName === 'CheckDatabase' ? 'router-link-exact-active' : '']">Check Database</a> |
    <a :class="[currentRouteName === 'InstallDatabase' ? 'router-link-exact-active' : '']">Database Installation</a> |
    <a :class="[currentRouteName === 'CreateAdmin' ? 'router-link-exact-active' : '']">Create Admin</a> |
    <a :class="[currentRouteName === 'Completed' ? 'router-link-exact-active' : '']">Completed</a>
  </div>
  <router-view/>
</template>
<script>

export default {
  name: 'App',
  computed: {
    currentRouteName() {
      return this.$route.name;
    }
  }
}
</script>
<style scoped>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>
