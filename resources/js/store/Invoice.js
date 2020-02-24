import req from "../axiosInit";

export default {
    state: {},
    mutations: {},
    getters: {},
    actions: {
        addInvoice({ commit }, data) {
            return new Promise((resolve, reject) => {
                console.log(data);
                const invoice = data.invoice;
                const codes = data.data;
                req.post("invoice/add", {
                    codeean13: codes,
                    invoice: invoice
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
