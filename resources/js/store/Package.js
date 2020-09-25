import req from "../axiosInit";

export default {
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async addPackage({ commit }, data) {
            return new Promise((resolve, reject) => {
                console.log(data);

                req.post("package/add", {
                    codedms: data
                })
                    .then(result => {
                        // console.log(result);
                        const data = result.data.result;
                        console.log(data);

                        const status = data.result;
                        if (status !== false) {
                            const code = data.EAN13;
                            resolve(code);
                        } else {
                            reject(data);
                        }
                    })
                    .then(result => {
                        reject(result);
                    });
            });
        },
        storePackage({ commit }, data) {
            return new Promise((resolve, reject) => {
                console.log(data);

                req.post("package/store", {
                    codedms: data
                })
                    .then(result => {
                        // console.log(result);
                        const data = result.data.result;
                        console.log(data);

                        const status = data.result;
                        if (status !== false) {
                            const code = data.EAN13;
                            resolve(code);
                        } else {
                            reject(data);
                        }
                    })
                    .then(result => {
                        reject(result);
                    });
            });
        },
        async findPackage({ commit }, ean13) {
            try {
                return  (await req.post("package/find", {
                    ean13
                })).data
            } catch (e) {
                console.log(e)
            }
        },
        async updatePackage({ commit }, {ean13, codedms}) {
            try {
                return  (await req.post("package/update", {
                    ean13,
                    codedms
                })).data.result
            } catch (e) {
                console.log(e)
            }
        }
    }
};
