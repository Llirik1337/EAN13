import req from "../axiosInit";

export default {
    state: {
        statistics: null
    },
    mutations: {
        setStatistics(state, val) {
            state.statistics = val;
        }
    },
    getters: {
        getStatistics(state) {
            return state.statistics;
        }
    },
    actions: {
        updateStatistics({ commit, getters }) {
            return new Promise((resolve, reject) => {
                const cargo_id =
                    parseInt(getters.getSelectedCargo) === -1
                        ? null
                        : parseInt(getters.getSelectedCargo);

                console.log(cargo_id);
                req.post("codeean13/getStatistics", {
                    cargo_id
                }).then(
                    ({ data }) => {
                        // console.log(data);
                        const updateData = data.map(item => {
                            console.log('item -> ',item);
                            return {
                                code: item.code,
                                tovarname: item.tovarname,
                                free: item.statistics.free,
                                description: item.description,
                                innerCode: item.innerCode,
                                Certification: item.Certification,
                                printed: item.statistics.printed,
                                inflicted: item.statistics.inflicted,
                                package: item.statistics.package,
                                invoice: item.statistics.invoice
                            };
                        });
                        // console.log(updateData);

                        commit("setStatistics", updateData);
                        resolve();
                    },
                    result => {}
                );
            });
        },
        async getAllDMCodes({ getters }, { codeean, count = null }) {
            try {
                console.log(codeean);
                const cargo_id =
                    parseInt(getters.getSelectedCargo) === -1
                        ? null
                        : parseInt(getters.getSelectedCargo);
                return (
                    await req.post("codeean13/getAllDM", {
                        codeean,
                        cargo_id,
                        count
                    })
                ).data.data;
            } catch (e) {
                throw e;
            }
        },
        async getAllFreeDMCode({ getters }) {
            try {
                const cargo_id =
                    parseInt(getters.getSelectedCargo) === -1
                        ? null
                        : parseInt(getters.getSelectedCargo);
                return (
                    await req.post("codeean13/getAllFreeDMCode", { cargo_id })
                ).data.data;
            } catch (e) {
                throw e;
            }
        }
    }
};
