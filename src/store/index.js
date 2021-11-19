import { createStore } from 'vuex'

export default createStore({
  state: {
    licenceAccepted: false,
    mysql: {
      host: 'mysql',
      port: '3306',
      databaseName: 'test-koray',
      username: 'test-koray',
      password: 'test-koray',
      connection: {
        connection: false,
        message: ''
      },
    },
  },
  mutations: {
    setMysql(state, mysqlObject) {
      state.mysql = mysqlObject
    },
    setLicenceAccepted(state, licenceAcceptRequest) {
      state.licenceAccepted = licenceAcceptRequest
    }
  },
  actions: {
  },
  modules: {
  }
})
