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
                        const code = result.data.result;
                        if (code !== false) {
                            resolve(code);
                        } else {
                            reject(result.data.msg);
                        }
                    })
                    .then(result => {
                        reject(result);
                    });
            });
        }
    }
};
