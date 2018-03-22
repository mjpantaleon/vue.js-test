<template>
  <div>
      <div class="row">
          <div class="col-lg-6">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      MBD Details <router-link to="../AddDonor" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-arrow-left"></span> Back to List</router-link>
                  </div>
                    <table class="table table-condensed table-bordered" v-if="mbd">
                        <tbody>
                            <tr>
                                <th class="col-lg-4">Agency</th>
                                <td>{{mbd.agency_name}}</td>
                            </tr>
                            <tr>
                                <th class="col-lg-4">Date</th>
                                <td>{{mbd.donation_dt.substr(0,10)}}</td>
                            </tr>
                        </tbody>
                    </table>
              </div>
          </div>
      </div>
      <div class="row" v-if="!loading">
          <div class="col-lg-6">
              <div class="panel panel-primary">
                  
                  <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> Donor Details</div>
                  <table class="table table-condensed table-bordered">
                      <tbody>
                          <tr>
                              <th class="col-lg-4">Donor ID</th>
                              <td class="col-lg-8">{{donor.donor_id}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Donation Status</th>
                              <td class="col-lg-8">
                                  <b class="text-success" v-if="(donor.donation_stat != 'N')">May Donate</b>
                                  <b class="text-danger" v-if="(donor.donation_stat == 'N')">Cannot Donate</b>
                              </td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Donor Name</th>
                              <td class="col-lg-8">
                                  {{donor.fname}} {{donor.mname}} {{donor.lname}}
                              </td>
                          </tr>
                          <!-- tr>th.col-lg-4+td.col-lg-8 -->
                      </tbody>
                  </table>
              </div>
          </div>

          <div class="col-lg-6">
              <div class="panel panel-primary">
                  <div class="panel-heading">Donation History</div>
                <table class="table table-condensed table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Facility</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="d in donor.donations" :key="d.seqno"  v-if="donor.donations.length">
                            <td>{{d.facility.facility_name}}</td>
                            <td>{{d.created_dt.substr(0,10)}}</td>
                            <td>{{d.remarks}}</td>
                        </tr>
                        <tr v-if="!donor.donations.length">
                            <td class="text-center" colspan="3">No Donations Yet</td>
                        </tr>
                    </tbody>
                </table>
              </div>
          </div>
      </div>
      <loading v-if="loading"></loading>
  </div>
</template>

<script>
import loading from './../../Loading.vue';

export default {
  props : ['sched_id','seqno'],
  components : {loading},
  data(){
      return {
          mbd : null, donor : null,loading : true
      }
  },
  mounted(){
      this.$http.get(this,"mbd/shortinfo/"+this.sched_id)
      .then(({data}) => {
          this.mbd = data;
      })
      .catch(error => {
          this.$store.state.error = error;
      });

      this.$http.get(this,"donor/"+this.seqno)
      .then(({data}) => {
          this.donor = data;
          this.donor.donations = _.orderBy(this.donor.donations,['created_dt'],['desc']);
          this.loading = false;
      })
      .catch(error => {
          this.$store.state.error = error;
      });
  }
}
</script>
