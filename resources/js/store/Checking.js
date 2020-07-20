import req from "../axiosInit";

export default {
    state: {
    },
    mutations: {
    },
    getters: {},
    actions: {
        async setStatus(ctx, {codedm_id, status}) {
            try {
                return (await req.post('codedm/setStatus', {codedm_id, status})).data.data
            } catch (e) {
                throw e;
            }
        },
        async checkingDMCode(ctx, {codeean_id, codedm}) {
            try {
                return (await req.post('codedm/checking', {codeean_id, codedm})).data.data
            } catch (e) {
                console.log(e.massage)
            }
        }
    }
};
