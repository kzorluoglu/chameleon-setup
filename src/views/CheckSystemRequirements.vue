<template>
  <div class="hello">
    <div>
      Required PHP VErsion: {{ phpVersion.required }} {{ phpVersion.installed }}<br>
      Installed PHP VErsion: {{ phpVersion.installed_version }}<hr>
    </div>
    <PhpSystemRequirement
        v-for="(phpExtension, index) in installedPhpExtensions"
        :phpExtension="phpExtension"
        :key="index"/>
<br>
    <div v-if="installable">
      <router-link :to="{ name: 'Licence'}">to Licence</router-link>
    </div>
    <div v-else>
      Please check and install the required PHP version and extensions.
    </div>
  </div>
</template>

<script>
import PhpSystemRequirement from '../components/PhpSystemRequirements'
export default {
  name: 'CheckSystemRequirements',
  components: {
    PhpSystemRequirement
  },
  props: {
    msg: String
  },
  data () {
    return {
      installedPhpExtensions : {},
      phpVersion : {},
      installable: false
    }
  },
  created() {
    fetch('https://baumit.kzorluoglu.esono.net/setup.php?step=CheckSystemRequirements')
        .then(response => response.json())
        .then(data => {
          this.installedPhpExtensions = data.installedPhpExtensions;
          this.phpVersion = data.phpVersion;

          if(this.phpVersion.installed) {
            this.installable = true;
          }

          for (let phpExtension of this.installedPhpExtensions) {
            if(!phpExtension.installed) {
              this.installable = false;
            }
          }
        });
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
