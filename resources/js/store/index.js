import Vue from 'vue';

import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import state from "./state";
import mutations from "./mutations";
import actions from "./actions";
import getters from "./getters";

Vue.use(Vuex); //использовать плагин vuex

const store = new Vuex.Store({
    state,
    mutations,
    actions,
    getters,
    plugins: [createPersistedState()],
});

export default store;
window.store = store;


