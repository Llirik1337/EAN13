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
        updateStatistics({ commit }) {
            return new Promise((resolve, reject) => {
                req.post("codeean13/getStatistics").then(
                    ({ data }) => {
                        // console.log(data);
                        const updateData = data.map((item) => {
                            return {
                                code: item.code,
                                tovarname: item.tovarname,
                                free: item.statistics.free,
                                printed: item.statistics.printed,
                                inflicted: item.statistics.inflicted,
                                package: item.statistics.package,
                                invoice: item.statistics.invoice
                            }
                        })
                        // console.log(updateData);

                        commit("setStatistics", updateData);
                        resolve();
                    },
                    result => {}
                );
            });
        },
        async getAllDMCodes(ctx, codeean) {
            try {
                return (await req.post('codeean13/getAllDM', {codeean})).data.data
            }catch (e) {
                throw e;
            }
        },
        async getAllFreeDMCode(ctx) {
            try {
                return (await req.post('codeean13/getAllFreeDMCode')).data.data
            }catch (e) {
                throw e;
            }
        }
    }
};
