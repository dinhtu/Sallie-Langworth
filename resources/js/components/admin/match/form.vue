<template>
  <div class="container">
    <div class="fade-in">
      <CRow>
        <CCol :sm="12">
          <CCard>
            <VeeForm
              as="div"
              v-slot="{ handleSubmit }"
              @invalid-submit="onInvalidSubmit"
            >
              <form
                method="POST"
                @submit="handleSubmit($event, onSubmit)"
                :action="data.urlStore"
                ref="formData"
              >
                <Field type="hidden" :value="csrfToken" name="_token" />
                <Field
                  type="hidden"
                  v-if="data.isEdit"
                  value="PUT"
                  name="_method"
                />
                <CCardHeader>
                  <CFormLabel>Match Form</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >Team A</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        as="select"
                        name="country_1"
                        v-model="model.country_1"
                        class="form-select"
                        rules="required"
                      >
                        <option value="" selected></option>
                        <option
                          v-for="item in data.countries"
                          :key="item.id"
                          :value="item.id"
                        >
                          {{ item.name }}
                        </option>
                      </Field>
                      <ErrorMessage class="error" name="country_1" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >Team B</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        as="select"
                        name="country_2"
                        v-model="model.country_2"
                        class="form-select"
                        rules="required"
                      >
                        <option value="" selected></option>
                        <option
                          v-for="item in data.countries"
                          :key="item.id"
                          :value="item.id"
                        >
                          {{ item.name }}
                        </option>
                      </Field>
                      <ErrorMessage class="error" name="country_2" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >match day</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        as="div"
                        name="match_day"
                        v-model="model.match_day"
                        rules="required"
                      >
                        <datepicker
                          autoApply
                          keepActionRow
                          :closeOnAutoApply="false"
                          v-model="model.match_day"
                          :monthChangeOnScroll="false"
                          locale="ja"
                          name="match_day"
                          selectText="選択"
                          cancelText="閉じる"
                          class="width-200"
                          format="yyyy/MM/dd HH:mm"
                        />
                      </Field>
                      <ErrorMessage class="error" name="match_day" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" for="knockout"
                      >knockout</CFormLabel
                    >
                    <div class="col-sm-6">
                      <input
                        type="checkbox"
                        name="knockout"
                        id="knockout"
                        v-model="model.knockout"
                        :checked="model.knockout == 1"
                        value="1"
                      />
                    </div>
                  </CRow>
                </CCardBody>
                <CCardFooter>
                  <div class="col-md-12 text-center btn-box">
                    <CButton type="submit" class="btn-primary btn-w-100">
                      登録
                    </CButton>
                    <a :href="data.urlBack" class="btn btn-default btn-w-100">
                      キャンセル
                    </a>
                  </div>
                </CCardFooter>
              </form>
            </VeeForm>
          </CCard>
        </CCol>
      </CRow>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>

<script>
import Loader from "../../common/loader";
import {
  Form as VeeForm,
  Field,
  ErrorMessage,
  defineRule,
  configure,
} from "vee-validate";
import { localize } from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import $ from "jquery";
import axios from "axios";

export default {
  setup() {
    Object.keys(rules).forEach((rule) => {
      if (rule != "default") {
        defineRule(rule, rules[rule]);
      }
    });
  },
  components: {
    Loader,
    VeeForm,
    Field,
    ErrorMessage,
    Datepicker,
  },
  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: {},
    };
  },
  mounted() {
      if (this.data.isEdit) {
        this.model = this.data.match;
      }
  },
  created() {
    let messError = {
      en: {
        fields: {
          name: {
            required: "ユーザー名を入力してください。",
          },
          email: {
            required: "ユーザーのメールを入力してください。",
            unique_custom: "このメールアドレスは既に登録されています。",
          },
          password: {
            password_rule:
              "パスワードは半角英数字で、大文字、小文字、数字で入力してください",
            required: "パスワードを入力してください。",
            max: "パスワードは15文字以内で入力してください。",
            min: "パスワードは8文字以上で入力してください。",
          },
          password_confirmation: {
            required: "パスワード確認 を入力してください。",
            confirmed: "パスワード確認が入力されたものと異なります。",
          },
        },
      },
    };
    configure({
      generateMessage: localize(messError),
    });

    let that = this;
    defineRule("unique_custom", (value) => {
      return axios
        .post(that.data.urlCheckEmail, {
          _token: Laravel.csrfToken,
          value: value,
        })
        .then(function (response) {
          return response.data.valid;
        })
        .catch((error) => {});
    });
  },
  methods: {
    onInvalidSubmit({ values, errors, results }) {
      let firstInputError = Object.entries(errors)[0][0];
      let ele = $('[name="' + firstInputError + '"]');
      if (
        $('[name="' + firstInputError + '"]').hasClass("hidden") ||
        $('[name="' + firstInputError + '"]').attr("type") == "hidden"
      ) {
        ele = $('[name="' + firstInputError + '"]').closest("div");
      }
      ele.focus();
      $("html, body").animate(
        {
          scrollTop: ele.offset().top - 150 + "px",
        },
        500
      );
    },
    onSubmit() {
      this.flagShowLoader = true;
      this.$refs.formData.submit();
    },
  },
};
</script>
