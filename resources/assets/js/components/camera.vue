<template>
  <div>
      <div class="modal fade" tabindex="-1" role="dialog" id="camera">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header" style="background-color:#3e3f3a;color:#fff;">
                      <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><span class="glyphicon glyphicon-camera"></span> Take Picture</h4>
                  </div>
                  <div class="modal-body">
                    <vue-webcam ref='webcam'></vue-webcam>
                    <span class="pull-right">
                    <button type="button" class="btn btn-primary" @click.prevent="takePicture">Capture</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </span>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import VueWebcam from 'vue-webcam';
import $ from 'jquery';

export default {
  props : ['show'],
  components : {VueWebcam},
  data(){
      return {
          photo : null
      };
  },
  watch : {
      show(){
          if(this.show != 0){
              $("#camera").modal("show");
          }
      }
  },
  methods : {
      takePicture(){
          this.photo = this.$refs.webcam.getPhoto();
          $("#camera").modal("hide");
          this.$emit("oncapture",this.photo);
      }
  }
}
</script>
