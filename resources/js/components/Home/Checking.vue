<template>
    <a-row class="form" justify="center" type="flex">
        <a-col :span="20">
            <a-checkbox v-model="pair">
                Pair EAN and DM
            </a-checkbox>
            <br />
            <br />
            <a-input
                placeholder="EAN13"
                ref="ean"
                addonBefore="EAN13"
                v-model="codeean"
                @pressEnter="endInputEan"
                :allowClear="true"
            >
                <!-- <span slot="addonBefore" class="input-prefix">{{state}}</span> -->
            </a-input>
            <a-alert
                v-show="eanError"
                type="error"
                message="Ean code wrong"
                banner
            />
            <br /><br />
            <a-input
                placeholder="DM"
                ref="dm"
                addonBefore="DM"
                v-model="codedm"
                @pressEnter="endInputDM"
                :allowClear="true"
            >
                <!-- <span slot="addonBefore" class="input-prefix">{{state}}</span> -->
            </a-input>
            <a-alert
                v-show="dmError"
                type="error"
                :message="dmErrorMsg"
                banner
            />
            <a-alert
                v-show="dmSuccess"
                type="success"
                message="DM code was applied successfully"
                banner
            />
            <br /><br />
        </a-col>
    </a-row>
</template>

<script>
import { mapActions } from "vuex";
import {pruneDatamatrixCode} from "../../app";

export default {
    name: "Checking",
    data: () => ({
        codedm: "",
        codeean: "",
        codeeanId: "",
        eanError: false,
        dmError: false,
        dmSuccess: false,
        dmErrorMsg: "DM code wrong",
        pair: true
    }),
    mounted() {
        this.focusEan();
    },
    methods: {
        ...mapActions([
            "checkingDMCode",
            "searchCodeEan13",
            "searchCodeDMByCode",
            "setStatus"
        ]),
        focusEan() {
            // this.dmSuccess = false;
            this.eanError = false;
            this.clearEan();
            this.$refs.ean.focus();
        },
        focusDM() {
            this.dmSuccess = false;
            this.dmError = false;
            this.clearDM();
            this.$refs.dm.focus();
        },
        clearEan() {
            this.codeean = "";
        },
        clearDM() {
            this.codedm = "";
        },
        async endInputEan() {
            try {
                const res = await this.searchCodeEan13({ code: this.codeean });
                console.log(res);
                if (res === undefined) {
                    this.eanError = true;
                    return;
                }
                this.codeeanId = res.id;
                this.focusDM();
            } catch (e) {
                this.eanError = true;
            }
        },
        async endInputDM() {
            try {

                const pruneCode = pruneDatamatrixCode(this.codedm);
                const res = await this.checkingDMCode({
                    codeean_id: this.codeeanId,
                    codedm: pruneCode
                });
                console.log(res);
                if (!res) {
                    this.dmError = true;
                    this.dmErrorMsg = "DM code wrong";
                    return;
                }
                console.log(res.status.name);
                if (res.status.name !== "Print") {
                    this.dmError = true;
                    this.dmErrorMsg = "DM code was previously applied";
                    return;
                }
                await this.setStatus({
                    codedm_id: res.id,
                    status: "Inflicted"
                });
                this.dmSuccess = true;
                if (this.pair) this.focusEan();
                else this.focusDM();
            } catch (e) {
                this.dmError = true;
            }
        }
    }
};
</script>

<style scoped></style>
