<template>
  <div>
      <div class="row" v-if="!loading">
          <div class="col-lg-6">
              <div class="panel panel-success">
                  
                  <div class="panel-heading">
                      <span class="glyphicon glyphicon-user"></span> Donor Details
                      <span class="pull-right">
                        <router-link :to="('./../Verifier')" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-arrow-left"></span> Back to List
                        </router-link>
                        <router-link :to="('./'+seqno+'/update')" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-pencil"></span> Update Info
                        </router-link>
                        <button class="btn btn-default btn-xs" 
                            :disabled="(donor.donation_stat == 'N')"
                            @click.prevent="confirmNewWalkin">
                            <span class="glyphicon glyphicon-plus"></span> New Walk-in
                        </button>

                      </span>
                  </div>
                  <table class="table table-condensed table-bordered">
                      <tbody>
                          <tr v-if="donor.donor_photo" style="height:150px;">
                              <th></th>
                              <td class="text-center">
                                  <img class="img img-thumb" :src="('data:image/jpeg;base64,'+donor.donor_photo)" alt="Donor Photo" style="width:400px;height:250px;" v-if="donor.donor_photo !== true" />
                              </td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Donor ID</th>
                              <td class="col-lg-8">{{donor.donor_id}}</td>
                          </tr>
                          <tr>
                              <th>Donation Status</th>
                              <td style="font-size:30px !important;">
                                  <b class="text-success" v-if="(donor.donation_stat != 'N')">May Donate</b>
                                  <b class="text-danger" v-if="(donor.donation_stat == 'N')">Cannot Donate</b>
                              </td>
                          </tr>
                          <tr>
                              <th>Donor Name</th>
                              <td>
                                  {{donor.fname}} {{donor.mname}} {{donor.lname}}
                              </td>
                          </tr>
                          <tr>
                              <th>Name Suffix</th>
                              <td>{{donor.name_suffix}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Gender</th>
                              <td class="col-lg-8">{{donor.gender | gender}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Birth Date</th>
                              <td class="col-lg-8">{{donor.bdate}} ({{donor.bdate | age}} years old)</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Civil Status</th>
                              <td class="col-lg-8">{{donor.civil_stat | civilStatus}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Nationality</th>
                              <td class="col-lg-8">{{donor.nation ? donor.nation.nationality : null}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Telephone No.</th>
                              <td class="col-lg-8">{{donor.tel_no}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Mobile No.</th>
                              <td class="col-lg-8">{{donor.mobile_no}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Email</th>
                              <td class="col-lg-8">{{donor.email}}</td>
                          </tr>
                          <tr>
                              <td class="bg-success" colspan="2">Home Address</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Region</th>
                              <td class="col-lg-8">{{donor.region | novalue('regname') | nye}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Province</th>
                              <td class="col-lg-8">{{donor.province | novalue('provname') | nye}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">City/Municipality</th>
                              <td class="col-lg-8">{{donor.city | novalue('cityname') | nye}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Barangay</th>
                              <td class="col-lg-8">{{ donor.barangay | novalue('bgyname') | nye}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">House No. / Street / Block</th>
                              <td class="col-lg-8">{{donor.home_no_st_blk}}</td>
                          </tr>
                          <tr>
                              <td class="bg-success" colspan="2">Office Address</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Region</th>
                              <td class="col-lg-8">{{donor.officeregion | novalue('regname') | nye}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Province</th>
                              <td class="col-lg-8">{{donor.officeprovince | novalue('provname') | nye}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">City/Municipality</th>
                              <td class="col-lg-8">{{donor.officecity | novalue('cityname') | nye}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">Barangay</th>
                              <td class="col-lg-8">{{donor.officebarangay | novalue('bgyname') | nye}}</td>
                          </tr>
                          <tr>
                              <th class="col-lg-4">House No. / Street / Block</th>
                              <td class="col-lg-8">{{donor.office_no_st_blk}}</td>
                          </tr>
                          <!-- tr>th.col-lg-4+td.col-lg-8 -->
                      </tbody>
                  </table>
              </div>
          </div>

          <div class="col-lg-6">
              <div class="panel panel-success">
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
      <confirm title="Review Details before procedding." @proceed="walkInDonation"></confirm>
  </div>
</template>

<script>
import $ from "jquery";
import loading from './../Loading.vue';
import confirm from './../Confirm.vue';
import filters from './../../filters';

export default {
  filters,
  props : ['sched_id','seqno'],
  components : {loading,confirm},
  data(){
      return {
          mbd : null, donor : null,loading : true
      }
  },
  mounted(){
      this.$http.get(this,"donor/"+this.seqno)
      .then(({data}) => {
          this.donor = data;
          this.donor.donations = _.orderBy(this.donor.donations,['created_dt'],['desc']);
          this.loading = false;
          this.fetchPhoto();
      })
      .catch(error => {
          this.$store.state.error = error;
      });
  },
  methods : {
      fetchPhoto(){
          if(this.donor.donor_photo){
              this.$http.get(this,'donor/'+this.donor.seqno+'/photo')
              .then(({data}) => {
                  this.donor.donor_photo = data;
              })
              .catch(error => {
                  this.$store.state.error = error;
              });
          }
      },
      confirmNewWalkin(){
          $("#confirmDialog").modal("show");
      },
      walkInDonation(c){
          //   Proceed to walk-in
        this.$router.replace("./"+this.seqno+"/donate");
        c();
      }
  }
}
</script>
