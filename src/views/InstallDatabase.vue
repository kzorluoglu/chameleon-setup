<template>
  <div class="database">
    <div v-if="response.status === false">
      Please wait, creating Database Tables...

      <div v-if="response.message !== ''">
        Error: {{ response.message }}
        <br>
        Try Again <router-link :to="{ name: 'CheckDatabase'}">Check Database</router-link>
      </div>

    </div>
    <div v-if="response.status">
      Database is created.<br>
      Now <router-link :to="{ name: 'CreateAdmin'}">Create Admin</router-link>
    </div>
   </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'InstallDatabase',
  components: {},
  data() {
    return {
      response: {
        status: false,
        message: ''
      }
    }
  },
  methods: {
  },
  computed: {
    mysql() {
      return this.$store.state.mysql;
    }
  },
  mounted() {
    fetch('https://baumit.kzorluoglu.esono.net/setup.php?step=InstallDatabase', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        mysqlHost: this.mysql.host,
        mysqlPort: this.mysql.port,
        mysqlDatabaseName: this.mysql.databaseName,
        mysqlUsername: this.mysql.username,
        mysqlPassword: this.mysql.password
      })
    })
    .then(response => response.json())
    .then(data => {
      this.response = data
    });
  }
}
</script>
