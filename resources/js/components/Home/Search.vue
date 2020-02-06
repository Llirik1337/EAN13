<template>
  <a-form
    class="form"
    :labelCol="formCol.label"
    :wrapperCol="formCol.wrapper"
    :form="form"
    @submit="submit"
  >
    <a-form-item label="Company">{{user.company.name}}</a-form-item>
    <a-form-item label="Printing directly to the printer">
      <a-checkbox v-model="toPrint" />
    </a-form-item>
    <a-form-item label="EAN13">{{this.EAN13Msg}}</a-form-item>
    <a-form-item label="code">
      <a-input :placeholder="state" ref="code" v-model="code" @pressEnter="endInputCode" :allowClear="true" />
    </a-form-item>
    <a-form-item label="Result">
      <barcode
        v-if="viewBarcode"
        :toPrint="toPrint"
        :tovarName="EAN13.tovarname"
        :value="codedm.code"
      ></barcode>
      <p v-else>{{resultMsg}}</p>
    </a-form-item>
  </a-form>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import Barcode from "./Search/Barcode";
export default {
  name: "Search",
  data() {
    return {
      formCol: {
        label: {
          span: 3
        },
        wrapper: {
          span: 20
        }
      },

      user: null,
      toPrint: false,
      EAN13Msg: "",
      EAN13: null,
      code: "",
      resultMsg: "",
      codedm: null,
      viewBarcode: false,
      isEndInputCode: false,
      state: 'EAN13',
    //   prefixCode: 'EAN13'
    };
  },
  components: {
    Barcode
  },
  beforeMount() {
    this.user = this.getUser;
    this.form = this.$form.createForm(this, { name: "search" });
  },
  mounted() {
    this.$refs.code.focus();
  },
  computed: {
    ...mapGetters(["getUser"])
  },

  methods: {
    ...mapActions(["searchCodeEan13", "searchCodeDMByCode", "searchCodeDM"]),

    inRange(val, min, max, left = false, right = false) {
      let resultLeft;
      let resultRight;
      if (left) {
        resultLeft = min > val;
      } else {
        resultLeft = min >= val;
      }

      if (right) {
        resultRight = val < max;
      } else {
        resultRight = val <= max;
      }
      // console.log(resultLeft);
      // console.log(resultRight);

      return resultLeft && resultRight;
    },
    endInputCode() {
      if (this.inRange(this.code.length, 13, 15) && this.state === 'EAN13') {
        this.viewBarcode = true;

        this.findCodeEan13(this.code);

        this.$refs.code.focus();
        this.$refs.code.select(true);

        this.state = 'DM'
      } else if (this.code.length >= 127 && this.state === 'DM') {
        this.viewBarcode = false;
        this.findCodeDm(this.code);

        this.$refs.code.focus();
        this.$refs.code.select(true);
        this.state = 'EAN13'
      } else {
        this.viewBarcode = false;

        this.EAN13 = "";
      }
      // this.isEndInputCode = false;
      // }
    },
    findCodeDm(val) {
      // console.log('findCodeDm');

      // console.log(val);

      this.searchCodeDMByCode(val).then(result => {
        // console.log(result);
        console.log(result);
        let msg;

        let res;
        if (result.data.codedm !== null && result.data.codedm !== undefined) {

          res = result.data.codedm;
          this.EAN13Msg = res.codeean13.code;
          // console.log(response);

          if (res.status_id !== null) {
            msg = `code: ${res.code} \n\r change status to ${res.status.name}`;
          } else {
            msg = "This code is not printed.";
          }
        } else {
          msg = "I did not find the DM code";
        }

        this.resultMsg = msg;
      });
    },
    findCodeEan13(val) {
      // console.log("findCodeEan13");
      // console.log(val);
      this.searchCodeEan13(val).then(
        result => {
          // console.log(result);
          this.EAN13 = result;
          this.EAN13Msg = result.code;
          this.searchCodeDM(this.EAN13.id).then(
            result => {
              this.codedm = result;
              this.viewBarcode = true;
            },
            result => {
              this.resultMsg = result;
              this.viewBarcode = false;
            }
          );
        },
        result => {
          this.EAN13Msg = result;
        }
      );
    },
    changePrint({ target }) {
      this.toPrint = target.checked;
    },
    submit(e) {
      e.preventDefault();
      // console.log();
    }
  }
};
</script>
<style>
.form {
  background-color: #fff;
  padding: 24px;
}
.ant-form-item {
  margin-bottom: 0px;
}
</style>
