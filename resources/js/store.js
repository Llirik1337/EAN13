
import Vue from 'vue'
import Vuex from 'vuex'
import App from './store/App'
import Search from './store/Search'
import Statistics from './store/Statistics'
import AdminPanel from './store/AdminPanel'
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        App,
        Search,
        Statistics,
        AdminPanel
    }
})
