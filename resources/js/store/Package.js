import req from "../axiosInit";

export default {
    state: {},
    mutations: {},
    getters: {},
    actions: {
        addPackage({ commit }, data) {
            return new Promise((resolve, reject) => {
                console.log(data);

                req.post("package/add", {
                    codedms: data
                })
                    .then(result => {
                        console.log(result);
                        const data = result.data;
                        const status = data.result.result;
                        const code = data.result.result;
                        if (status !== false) {
                            resolve(code);
                        } else {
                            reject(data.msg);
                        }
                    })
                    .then(result => {
                        reject(result);
                    });
            });
        }
    }
};
