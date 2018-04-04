<template>
  <div class="modal fade" id="confirmDialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-body">
                  <div class="text-center" v-if="!loading">
                      {{title}}
                        <button class="btn btn-default btn-sm" @click="proceed" >Okay</button>
                        <button class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
                  </div>
                  <div class="text-center" v-if="loading">
                      <loading label="Please wait, loading.."></loading>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import $ from "jquery";
import Loading from './LoadingInline.vue';

export default {
  components : {Loading},
  props : ['title','callback'],
  data(){
      return {loading : false};
  },
  methods : {
      proceed(){
          this.loading = true;
          this.$emit("proceed",() => {
              $("#confirmDialog").modal("hide");
              this.loading = false;
          });
      }
  }
}
</script>

