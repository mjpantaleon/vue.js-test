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
                      <loadingInline label="Please wait, loading.."></loadingInline>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>

export default {
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

