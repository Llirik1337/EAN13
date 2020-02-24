import req from "../axiosInit";

export default {
    state: {
        shipments: []
    },
    mutations: {
        setShipments(state, data) {
            state.shipments = data;
        }
    },
    getters: {
        getShipments(state) {
            return state.shipments;
        }
    },
    actions: {
        updateShipment({ commit }, data) {
            return new Promise((resolve, reject) => {
                console.log(data);
                req.post("invoice/get", {
                    invoice: data
                })
                    .then(({data}) => {
                        console.log(data.result);

                        if (data.result === true) {
                            console.log(data.invoice);

                            commit("setShipments", data.invoice);
                            resolve();
                        } else {
                            commit("setShipments", []);
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
