<template>
  <select class="form-select" :disabled="data.disabled" style="width:150px" @change="update" v-model="model.result">
    <option disabled>-</option>
    <option value="1">Win</option>
    <option value="2">=</option>
    <option value="3">Lose</option>
  </select>
</template>

<script>
import Loader from "./loader.vue";
import axios from "axios";
import $ from "jquery";

export default {
  data() {
    return {
      flagShowLoader: false,
      model: {
        result: this.data.result,
      },
    };
  },
  components: {
    Loader,
  },
  props: ["data"],
  mounted() {},
  methods: {
    update() {
      let that = this;
      $(".loading-div").removeClass("hidden");
      axios
        .put(that.data.urlAction, {
          _token: Laravel.csrfToken,
          result: that.model.result
        })
        .then(function (response) {
          that.flagShowLoader = false;
          $(".loading-div").addClass("hidden");
          that
            .$swal({
              title: 'Update Success',
              icon: "success",
              confirmButtonText: "OK",
            })
            .then(function () {
            //   location.reload();
            });
        });
    },
  },
};
</script>
