<template>
  <div class="createadmin">
    <div v-if="!response.status">
      <div v-if="response.message">
        {{ response.message }}
      </div>
      <form v-on:submit.prevent="formSubmit">
        <input type="text" placeholder="admin email" v-model="admin.username" autocomplete="admin.username"><br>
        <input type="text" placeholder="admin password" v-model="admin.password" autocomplete="admin.password"><br>
        <br>
        <br>
        <button type="submit">Create Admin</button>
      </form>
    </div>
    <div v-if="response.status">
      Admin account created.<br>
      <router-link to="/completed">to Completed</router-link>
    </div>

   </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'CreateAdmin',
  components: {},
  data() {
    return {
      response: '',
      admin: {
        username: '',
        password: ''
      }
    }
  },
  methods: {
    formSubmit() {
      fetch('https://baumit.kzorluoglu.esono.net/setup.php?step=createAdmin', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          mysqlHost: this.mysql.host,
          mysqlPort: this.mysql.port,
          mysqlDatabaseName: this.mysql.databaseName,
          mysqlUsername: this.mysql.username,
          mysqlPassword: this.mysql.password,
          adminUsername: this.admin.username,
          adminPassword: this.admin.password,
        })
      })
          .then(response => response.json())
          .then(data => {
            this.response = data
          });
    }
  },
  computed: {
    mysql() {
      return this.$store.state.mysql;
    }
  },
}
</script>
