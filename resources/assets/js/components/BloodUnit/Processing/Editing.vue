<template>
  <div>
      <div class="row" v-if="!verify">
          <div class="col-lg-12">
              <div class="panel panel-success">
                  <div class="panel-heading">
                      Blood Typing
                  </div>
                  <table class="table table-bordered table-condensed">
                      <thead>
                          <tr>
                              <th width="30">#</th>
                              <th width="150">Donation ID</th>
                              <th>Blood Type</th>
                              <th>Blood Bag</th>
                              <th v-for="(cn,cd) in components" :key="cd" style="font-size:10px;" class="text-center">{{cn}}</th>
                          </tr>
                      </thead>
                      <tbody>
                          <row v-for="(donation,i) in donations" 
                                :key="donation.donation_id" 
                                :no="(i+1)" 
                                :bloodBags="blood_bags" 
                                :components="components" 
                                :donation="donation"
                                :rules="rules"></row>
                      </tbody>
                      <tfoot>
                          <tr>
                              <td :colspan="(4+Object.keys(components).length)" class="text-right">
                                  <loadingInline v-if="loading" label="Please wait, loading.."></loadingInline>
                                <button class="btn btn-default" :disabled="checkData || loading" @click="validateForm">Save Changes</button>
                                <button class="btn btn-danger" :disabled="loading" @click.prevent="donations = []; $emit('cancel',null)">Cancel</button>
                              </td>
                          </tr>
                      </tfoot>
                  </table>
              </div>
          </div>
      </div>
      <verifier v-if="verify" @cancel="verify = false" @proceed="submitForm"></verifier>
  </div>
</template>

<script>
import Row from './Row.vue';
export default {
  components : {Row},
  props : ['donationids'],
  data(){
      let donations = [], components = this.$session.get('components');
      this.donationids.forEach(d => {
          d.units = _.clone(components);
          for(let u in d.units){
              d.units[u] = null;
          }
          donations.push(d);
      });
      return {
          donations, components, loading : false, verify : false, blood_bags : this.$session.get('blood_bags'), rules : null
      };
  },
  mounted(){
      this.$http.get(this,"bloodbag/components")
      .then(({data}) => {
          this.rules = data;
      });
  },
  computed : {
      checkData(){
          let noABO = _.filter(this.donations,{abo : null});
          let noRH = _.filter(this.donations,{rh : null});
          let incomplete = noABO.length + noRH.length;
          return incomplete > 0;
      }
  },
  methods : {
      validateForm(){
          if(this.checkData){
              return;
          }
          this.loading = true;
          this.verify = true;
      },
      submitForm(verifier){
          this.verify = false;
          let {donations} = this;
          let user = this.$session.get('user');
          let {user_id,facility_cd} = user;
          this.$http.post(this,"typing/save",{
              donations,user_id,facility_cd,verifier
          })
          .then(({data}) => {
              this.$store.state.msg = {
                  content : 'Blood Typing has been saved successfully',
                  type : 'success'
              };
              this.$emit("cancel");
          });
      }
  }
}
</script>

<style scoped>
select:focus{
    background: #f1f1f1;
}
</style>
