<template>
  <div class="panel panel-danger">
      <div class="panel-heading">Re-scan Donation ID</div>
      <div class="panel-body">
          <i style="font-size:12px;" class="text-danger" v-if="error">Donation ID did not match</i>
          <input type="text" id="rescan" v-model="donation_id" @keyup="donation_id = donation_id ? donation_id.toUpperCase() : null" class="form-control input-sm" maxlength="16" placeholder="Please Re-scan Donation ID to Proceed">
      </div>
      <div class="panel-footer text-right">
          <button class="btn btn-default btn-sm" @click="$emit('cancel')">Cancel</button>
      </div>
  </div>
</template>

<script>
export default {
  props : ['rescan'],
  data(){
      return {donation_id : '', error : null};
  },
  mounted(){
      $("#rescan").focus();
  },
  watch : {
    donation_id(){
        this.error = null;
        let {donation_id,rescan} = this;
        if(!donation_id){
            return;
        }else if(donation_id.length == 16){
            if(donation_id == rescan.donation_id){
                this.$emit('success',rescan);
            }else{
                this.error = true;
            }
        }
    }      
  }
}
</script>
