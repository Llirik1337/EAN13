import req from "../axiosInit";

export default {
    state: {
        user: null,
        loading: false,
        initiated: false,
        selectedCargo: null,
    },
    mutations: {
        setIsLogin(state) {
            state.isLogin = true;
            // console.log(state);
        },
        setUser(state, user) {
            state.user = user;
        },
        setInit(state, data) {
            state.user = data.user;
            state.loading = false;
            state.initiated = true;
        },
        setLogOut(state) {
            state.user = null;
            state.loading = false;
            state.initiated = false;
        },
        setSelectedCargo(state, cargo) {
            state.selectedCargo = cargo;
        },
    },
    getters: {
        getUser(state) {
            return state.user;
        },
        getLoading(state) {
            return state.loading;
        },
        getInitiated(state) {
            return state.initiated;
        },
        getReq() {
            return state.req;
        },
        getSelectedCargo(state) {
            return state.selectedCargo;
        },
    },
    actions: {
        updateSelectedCargo({ commit }, cargo) {
            commit("setSelectedCargo", cargo);
        },
        Init(ctx) {
            return new Promise((resolve, reject) => {
                req.post("auth/init").then((response) => {
                    // console.log('Init');
                    // console.log(response.data);
                    console.log(response.data);

                    ctx.commit("setInit", response.data);
                    resolve();
                });
            });
        },
        LoginIn(ctx, data) {
            return new Promise((resolve, reject) => {
                ctx.dispatch("LogOut").then(() => {
                    // console.log('LoginIn');
                    // console.log(data);
                    req.post("auth/login", {
                        name: data.name,
                        password: data.password,
                    }).then(
                        (response) => {
                            // console.log(response);

                            ctx.commit("setUser", response.data);
                            ctx.commit("setIsLogin");
                            resolve(true);
                        },
                        (response) => {
                            reject();
                        }
                    );
                });
            });
        },
        LogOut({ commit }) {
            return new Promise((resolve, reject) => {
                // console.log('LogOut');
                commit("setSelectedCargo", null);
                req.post("auth/logout")
                    .then((response) => {
                        commit("setLogOut");
                        // console.log(response);
                        resolve(true);
                    })
                    .catch((e) => {
                        // console.log(e);
                    });
            });
        },
    },
};
