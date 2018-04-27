<template>
  <div>
    <div class="form-group">
        <div class="col-lg-7 col-lg-offset-3">
            <camera :show="cameraVisible" @oncapture="getPhoto"></camera>
            <img :src="donor_photo" alt="Donor Photo" v-if="donor_photo" style="width:200px;height:150px;">
        </div>
        <label for="" class="control-label col-lg-3">Profile Picture</label>
        <div class="col-lg-5">
            <button class="col-lg-12 btn btn-xs btn-default" @click.prevent="(cameraVisible++)"><span class="glyphicon glyphicon-camera"></span> Take Photo</button>
        </div>
        <div class="col-lg-4">
        </div>
    </div>
  </div>
</template>

<script>

export default {
  data(){
      return {
          donor_photo : null, cameraVisible : 0
      }
  },
  methods : {
      getPhoto(photo){
          this.donor_photo = photo;
          this.$emit("oncomplete",photo);
      }
  }
}
</script>
