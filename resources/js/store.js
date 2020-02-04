
import Vue from 'vue'
import Vuex from 'vuex'
import App from './store/App'
import Search from './store/Search'
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        App,
        Search
    }
})