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
                                inflicted: item.statistics.inflicted
                            }
                        })
                        // console.log(updateData);

                        commit("setStatistics", updateData);
                        resolve();
                    },
                    result => {}
                );
            });
        }
    }
};
