import req from "../axiosInit";

export default {
    state: {
    },
    mutations: {
    },
    getters: {
    },
    actions: {

        createUser({commit}, userData) {
            console.log(userData);

            return new Promise((resolve, reject)=> {
                req.post('admin/createUser', {
                    login: userData.login,
                    password: userData.password,
                    company: userData.company,
                }).then(res => {
                    resolve(res.data);
                });
            })
        }

    }
};
