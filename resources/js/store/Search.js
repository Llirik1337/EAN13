import req from '../axiosInit'


export default {
    state: {
        EAN13: '',

    },
    mutations: {
        setEAN13(state, code) {
            state.EAN13 = code;
        }
    },
    getters: {
    },
    actions: {
        searchCodeEan13({ commit }, code) {
            return new Promise((resolve, reject) => {
                const codeEan13 = code.substring(0, 13);
                // console.log('getCodeEan13');
                req.get('codeean13/by/' + codeEan13).then(response => {
                    // console.log(response.data);
                    
                    const codeean13 = response.data.codeean13;
                    commit('setEAN13', codeean13);
                    if (codeean13 !== null) {
                        resolve(codeean13);
                    } else {
                        reject('this EAN is not registered')
                    }
                })
            })
        },
        searchCodeDM({ commit }, codeean13_id) {
            return new Promise((resolve, reject) => {
                // console.log('searchCodeDM');
                // console.log(codeean13_id);

                req.get('codedm/by/' + codeean13_id).then(response => {
                    const codedm = response.data.codedm;
                    // console.log(codedm);
                    if (codedm !== null) {
                        resolve(codedm);
                        // req.post('status/set', {
                        //     id: codedm.status_id,
                        //     statusText: 'Print'
                        // }).then(result => {
                        //     resolve(codedm);
                        // }, result => {
                        //     reject('did’t find free DM');
                        // });
                    }
                    else
                        reject('did’t find free DM');
                })
            })
        },
        searchCodeDMByCode(ctx, code) {
            return new Promise((resolve, reject) => {
                // console.log('searchCodeDMByCode');
                console.log(code);

                req.post('codedm/byCode', {
                    code: code
                }).then(response => {
                    // let msg;
                    console.log(response);
                    resolve(response);

                // resolve(msg);
                    // const codedm = response.data.codedm;
                    // console.log(codedm);
                    // if (codedm !== null) {
                    //     resolve(codedm);
                    //     // req.post('status/set', {
                    //     //     id: codedm.status_id,
                    //     //     statusText: 'Print'
                    //     // }).then(result => {
                    //     //     resolve(codedm);
                    //     // }, result => {
                    //     //     reject('did’t find free DM');
                    //     // });
                    // }
                    // else
                    //     reject('did’t find free DM');
                })
            })
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
}