import req from '../axiosInit'

export default {
    state: {
        user: null,
        loading: false,
        initiated: false,
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
        }
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
        }
    },
    actions: {
        Init(ctx) {
            return new Promise((resolve, reject) => {
                req.get('auth/init').then(response => {
                    // console.log('Init');
                    // console.log(response.data);
                    ctx.commit('setInit', response.data)
                    resolve();
                })
            });
        },
        LoginIn(ctx, data) {
            return new Promise((resolve, reject) => {

                ctx.dispatch('LogOut').then(() => {
                    // console.log('LoginIn');
                    // console.log(data);
                    req.post('auth/login', {
                        name: data.name,
                        password: data.password
                    }).then(response => {
                        // console.log(response);
                        ctx.commit('setUser', response.data);
                        ctx.commit('setIsLogin');
                        resolve(true);
                    }, response => {
                        reject();
                    })
                });
            });

        },
        LogOut({commit}) {
            return new Promise((resolve, reject) => {
                // console.log('LogOut');
                req.post('auth/logout').then(response => {
                    commit('setLogOut');
                    // console.log(response);
                    resolve(true);
                }).catch(e => {
                    // console.log(e);
                })
            });
        }
    }
}