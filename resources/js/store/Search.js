import req from "../axiosInit";

export default {
    state: {
        EAN13: ""
    },
    mutations: {
        setEAN13(state, code) {
            state.EAN13 = code;
        }
    },
    getters: {},
    actions: {
        async searchCodeEan13({ commit, getters }, { code }) {
            try {
                const cargo_id =
                    parseInt(getters.getSelectedCargo) === -1
                        ? null
                        : parseInt(getters.getSelectedCargo);
                const Code = code.substring(0, 13);
                const response = await req.post("codeean13/by", {
                    code: Code,
                    cargo_id
                });
                const codeean13 = response.data.codeean13;
                commit("setEAN13", codeean13);
                if (codeean13 !== null) {
                    return codeean13;
                }
            } catch (e) {
                throw e;
            }
        },
        searchCodeDM({ commit, getters }, codeean13_id) {
            return new Promise((resolve, reject) => {
                const cargo_id =
                    parseInt(getters.getSelectedCargo) === -1
                        ? null
                        : parseInt(getters.getSelectedCargo);
                req.post("codedm/by", {
                    codeean13_id,
                    cargo_id
                }).then(response => {
                    const codedm = response.data.codedm;
                    if (codedm !== null) {
                        resolve(codedm);
                    } else reject("did’t find free DM");
                });
            });
        },
        searchCodeDMByCode(ctx, code) {
            return new Promise((resolve, reject) => {
                // console.log('searchCodeDMByCode');
                console.log(code);
                req.post("codedm/byCode", {
                    code: code
                }).then(response => {
                    // let msg;
                    console.log(response);
                    resolve(response);
                });
            });
        }

        // getBarcode(ctx, codedm) {
        //     return new Promise((resolve, reject) => {
        //         console.log('getBarcode');
        //         console.log(codedm);

        //         req.post('barcode/get', {
        //             codedm: codedm
        //         }).then(
        //             result => {
        //                 console.log(result);
        //                 resolve(result);
        //             },
        //             result => {
        //                 reject(result);
        //             })

        //     })
        // }
    }
};
