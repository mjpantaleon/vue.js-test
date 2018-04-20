<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="pull-right">
                    <input type="date" class="form-control" v-model="filter">
                </div>
            </div>
        </div>
        <table class="table table-condensed table-bordered" style="font-size:12px;">
            <thead>
                <tr>
                    <th>DATE</th>
                    <th>AGENCY</th>
                    <th>DONOR ID NUMBER</th>
                    <th>NAME</th>
                    <th>AGE</th>
                    <th>GENDER</th>
                    <th>ADDRESS</th>
                    <th>CIVIL STATUS</th>
                    <th>NATIONALITY</th>
                    <th>TYPE OF DONOR</th>
                    <th>HBV</th>
                    <th>HCV</th>
                    <th>HIV</th>
                    <th>SYP</th>
                    <th>MAL</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(d,i) in donations" :key="i" v-if="!loading" :class="isReactive(d.test)">
                    <td nowrap>{{d.donation_dt.substr(0,10)}}</td>
                    <td>{{d.agency_name}}</td>
                    <td>{{d.donation_id}}</td>
                    <td>{{d.donor ? d.donor.fname + ' ' + d.donor.mname + ' ' + d.donor.lname : null}}</td>
                    <td v-if="!d.donor">N/A</td>
                    <td v-if="d.donor">{{d.donor.bdate | age}}</td>
                    <td v-if="!d.donor">N/A</td>
                    <td v-if="d.donor">{{d.donor.gender | gender}}</td>
                    <td v-if="!d.donor">N/A</td>
                    <td v-if="d.donor">{{d.donor.home_no_st_blk}} , {{d.donor.barangay ? d.donor.barangay.bgyname : ''}} , {{d.donor.city ? d.donor.city.cityname : ''}} , {{d.donor.province ? d.donor.province.provname : ''}} , {{d.donor.region ? d.donor.region.regname : ''}}</td>
                    <td v-if="d.donor">{{d.donor.civil_stat | civilStatus}}</td>
                    <td v-if="!d.donor">N/A</td>
                    <td v-if="d.donor">{{d.donor.nation ? d.donor.nation.nationality : null}}</td>
                    <td v-if="!d.donor">N/A</td>
                    <td v-if="d.donor" nowrap>{{d.donor.donations.length}} | {{lastDonationDt(d.donor.donations)}} </td>
                    <td v-if="!d.donor">N/A</td>
                    <td v-if="!d.test"></td>
                    <td v-if="!d.test"></td>
                    <td v-if="!d.test"></td>
                    <td v-if="!d.test"></td>
                    <td v-if="!d.test"></td>
                    <td v-if="d.test">{{ resultFor('HBSAG',d.test.details).result_int | uppercase }}</td>
                    <td v-if="d.test">{{ resultFor('HCV',d.test.details).result_int | uppercase }}</td>
                    <td v-if="d.test">{{ resultFor('HIV',d.test.details).result_int | uppercase }}</td>
                    <td v-if="d.test">{{ resultFor('MALA',d.test.details).result_int | uppercase }}</td>
                    <td v-if="d.test">{{ resultFor('RPR',d.test.details).result_int | uppercase }}</td>
                </tr>
                <tr v-if="!loading && donations.length == 0">
                    <td class="text-center" colspan="15">No Donations</td>
                </tr>
                <tr v-if="loading">
                    <td class="text-center" colspan="15"><loading label="Please Wait.."></loading></td>
                </tr>
            </tbody>
        </table>
        
    </div>
</template>

<script>
import Loading from './LoadingInline.vue';
import Sha2 from './Sha2.vue';
import _ from 'lodash';
import filters from './../filters';
export default {
  filters,
  components : {Sha2,Loading},
  data(){
      return {donations : [], loading : false, filter : '2017-05-28' };
  },
  watch : {
      filter(){
          this.doSearch(this);
      }
  },
  mounted(){
      this.doSearch(this);
  },
  methods : {
      dateToday(){
          let today = new Date();
            let dd = today.getDate();
            let mm = today.getMonth()+1; //January is 0!

            let yyyy = today.getFullYear();
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            return yyyy+'-'+mm+'-'+dd;
      },
      doSearch : _.debounce((that) => {
          that.loading = true;
          that.$http.post(that,"sha",{
              filter : that.filter, facility_cd : that.$session.get('user').facility_cd
          }).then(({data}) => {
              that.donations = data;
              that.loading = false;
          });
      },1300),
      resultFor(test,details){
          return _.find(details,{exam_cd : test});
      },
      lastDonationDt(donations){
          donations = _.sortBy(donations,['created_dt']);
          let d = donations.pop();
          if(d.mbd){
              return d.mbd.donation_dt.substr(0,10);
          }else{
              return d.created_dt.substr(0,10);
          }
      },
      isReactive(test){
          if(!test){
              return "";
          }

          if(test.result.toUpperCase() == 'R'){
              return "bg-danger";
          }

          return "";
      }
  }
}
</script>
