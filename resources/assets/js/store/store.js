/**
 * Created by chain on 2017/10/19.
 */

import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
export default new Vuex.Store({
   state:{
      permission:99
   },
   mutations: {
      setPermission (state, n) {
         state.permission = n
      }
   }
})