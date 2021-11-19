<template>
  <div class="check_database">
<form v-on:submit.prevent="formSubmit">
    <input type="text" placeholder="host" v-model="mysql.host" autocomplete="mysql.host"><br>
    <input type="text" placeholder="port" v-model="mysql.port" autocomplete="mysql.port"><br>
    <input type="text" placeholder="db name" v-model="mysql.databaseName" autocomplete="mysql.databaseName"><br>
    <input type="text" placeholder="db username" v-model="mysql.username" autocomplete="mysql.username"><br>
    <input type="text" placeholder="db password" v-model="mysql.password" autocomplete="mysql.password"><br>
    <br>
    <br>
    <button type="submit">Check</button>
</form>
<br>
    <div v-if="showDetail">
    <div v-if="mysql.connection.connection">
      <br>Connection is successful!<br>
      <a @click="goInstallation">Install Database</a>
    </div>
    <div v-else>
      Error: {{ mysql.connection.message }}
    </div>
    </div>
   </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'CheckDatabase',
  components: {},
  data() {
    return {
      showDetail: false
    }
  },
  computed: {
    mysql() {
      return this.$store.state.mysql;
    }
  },
  methods: {
    formSubmit() {
      fetch('https://baumit.kzorluoglu.esono.net/setup.php?step=checkDatabase', {
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
            this.showDetail = true
            this.mysql.connection = data.databaseConnection;
          });
    },
    goInstallation() {
      this.$store.commit('setMysql', this.mysql);
      this.$router.push('/installdatabase');
    }
  }
}
</script>
