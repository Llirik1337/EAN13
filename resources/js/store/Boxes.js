import req from "../axiosInit";

export default {
    state: {},
    mutations: {},
    getters: {},
    actions: {
        addBox({ commit }, data) {
            return new Promise((resolve, reject) => {
                console.log(data);

                req.post("box/add", {
                    codeean13: data
                })
                    .then(result => {
                        const data = result.data.result;
                        console.log(data);

                        const status = data.result;
                        if (status !== false) {
                            const code = data.EAN13;
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
