<template>
  <div>
      <mbdSelector @selected="selectedMBDAgency" :walkinDates="true"></mbdSelector>
      <div class="row" v-show="!rescan && !preview">
          <div class="col-lg-12">
              <div class="panel panel-success">
                <div class="panel-heading">Blood Labeling</div>
                <div class="panel-body">
                    <div class="form-horizontal col-lg-4">
                        <div class="form-group">
                            <label for="" class="control-label col-lg-4">MBD / Walk-in</label>
                            <div class="col-lg-8 input-group">
                                <input @click.prevent="selectMBDAgency" type="text" class="form-control input-sm" placeholder="Click here to select MBD/Walk-in" readonly v-if="!sched.agency_cd" style="background-color:#fff;">
                                <div class="form-control input-sm" v-if="sched.agency_cd" @click.prevent="selectMBDAgency">
                                    <span v-if="sched.agency_name == 'Walk-in'">{{sched.agency_name}} - FROM {{sched.from}} TO {{sched.to}}</span>
                                    <span v-if="sched.agency_name != 'Walk-in'">{{sched.agency_name}} - {{sched.donation_dt.substr(0,10)}}</span>
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-default btn-sm" @click.prevent="selectMBDAgency"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label col-lg-4">Component</label>
                            <div class="col-lg-8">
                                <select class="form-control input-sm" v-model="component_cd">
                                    <option value=""></option>
                                    <option v-for="(cn,cd) in all_components" :value="cd" :key="cd">{{cn}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <button class="btn btn-default btn-sm" :disabled="!sched.sched_id && !component_cd" @click.prevent="fetchDonations">Search <span class="glyphicon glyphicon-search"></span></button>
                    </div>
                </div>
                <table class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <td :colspan="3 + Object.keys(components).length"><button class="btn btn-primary btn-sm pull-right" @click.prevent="$emit('hasSelected',selected)" :disabled="!selected.length">Proceed</button></td>
                        </tr>
                        <tr>
                            <th class="text-center" style="font-size:12px;">DONATION ID</th>
                            <th class="text-center" style="font-size:12px;">BLOOD TYPE</th>
                            <th class="text-center" style="font-size:12px;">BLOOD TEST</th>
                            <th v-for="(cn,cd) in components" :key="cd" style="font-size:10px;" class="text-center">{{cn}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!sched.agency_cd">
                            <td :colspan="3 + Object.keys(components).length" class="text-center">Please enter search criteria</td>
                        </tr>
                        <tr v-if="loading">
                            <td :colspan="3 + Object.keys(components).length" class="text-center"><loadingInline v-if="loading" label="Please wait, fetching Donation IDs"></loadingInline></td>
                        </tr>
                        <tr v-for="d in donations" :key="d.donation_id" style="font-size:12px;" v-if="!loading">
                            <td class="text-center">{{d.donation_id}}</td>
                            <td class="text-center">
                                <span v-if="d.type">{{d.type.blood_type}}</span>
                                <span v-if="!d.type" class="text-danger">PENDING</span>
                            </td>
                            <td class="text-center">
                                <span v-if="d.test">
                                    <span class="text-success" v-if="d.test.result == 'N'">NR</span>
                                    <span class="text-danger" v-if="d.test.result == 'R'">R</span>
                                </span>
                                <span v-if="!d.test" class="text-danger">PENDING</span>
                            </td>
                            <td v-for="(cn,cd) in components" :key="cd" class="text-center" @click=" hasUnit(d.units,cd) && !(!d.type || !d.test) ? selectUnit(d.donation_id,cd) :null">
                                <div v-if="!isAlreadyLabeled(d.labels,cd)">
                                    <input v-if="hasUnit(d.units,cd)" type="checkbox" v-model="selected" :value="{donation_id : d.donation_id, component_cd : cd}" :disabled="(!d.type || !d.test)">
                                </div>
                                <div v-if="isAlreadyLabeled(d.labels,cd)">
                                    <span class="glyphicon glyphicon-ok text-success"></span>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!loading && (sched.sched_id && component_cd) && !donations">
                            <td class="text-center" :colspan="3 + Object.keys(components).length">No Available Donations</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td :colspan="3 + Object.keys(components).length"><button class="btn btn-primary btn-sm pull-right" @click.prevent="$emit('hasSelected',selected)" :disabled="!selected.length">Proceed</button></td>
                        </tr>
                    </tfoot>
                </table>
              </div>
          </div>
      </div>
      <div class="row" v-if="rescan">
          <div class="col-lg-4 col-lg-offset-4" style="padding-top:50px;">
              <re-scan :rescan="rescan" @success="preview = clone(rescan); rescan = null;" @cancel="rescan=null;"></re-scan>
          </div>
      </div>
      <div class="row" v-if="preview">
          <div class="col-lg-6 col-lg-offset-3" style="margin-top:50px;">
              <preview :preview="preview"></preview>
          </div>
      </div>
  </div>
</template>

<script>
import ReScan from './ReScan.vue';
import Preview from './LabelPreview.vue';

export default {
  components : {ReScan,Preview},
  props : ['refresh'],
  data(){
      let {sched} = this.$store.state;
      sched = {"sched_id":"1300620180000299","agency_cd":"1300602181","agency_name":"NVBSP IMU","donation_dt":"2018-04-28 00:00:00"};
      let components = this.$session.get('components');
      let all_components = _.clone(components);
      return {
          sched, selected : [], donations : [], loading : false, component_cd : null, components, all_components,
          rescan : null, preview :  {donation_id : "NVSBP20180000453" , component_cd : 20}
      };
  },
  mounted(){
      this.fetchDonations();
  },
  methods : {
      selectMBDAgency(){
          $("#MBDSelector").modal("show");
      },
      selectedMBDAgency(sched){
          this.sched = sched;
          this.$store.state.sched = sched;
          $("#MBDSelector").modal("hide");
      },
      fetchDonations(){
        //   let {sched,donation_id,component_cd} = this;
        //   if(!this.sched.sched_id && !this.donation_id && !this.componetn_cd){
        //       return;
        //   }
        //   this.loading = true;
        //   this.$http.post(this,"labeling/list",{
        //       sched, component_cd, facility_cd : this.$session.get('user').facility_cd 
        //   })
        //   .then(({data}) => {
        //       this.donations = _.sortBy(data,['donation_id'],['asc']);
        //       this.loading = false;
        //   });
        this.donations = [{"seqno":"1300620180008637","donation_id":"NVBSP20185000018","donor_sn":null,"sched_id":"1300620180000299","pre_registered":"Y","donation_type":"V","collection_method":"WB","donation_stat":"A","facility_cd":"13006","mh_pe_stat":"A","mh_pe_deferral":null,"mh_pe_question":null,"mh_pe_remark":null,"collection_type":null,"collection_stat":"COL","coluns_res":null,"blood_bag":"D","created_by":"13006","created_dt":"2018-05-05 10:49:16","updated_by":null,"updated_dt":null,"type":{"bloodtyping_no":"1300620180008446","facility_cd":"13006","bloodtyping_dt":"2018-05-05 10:51:13","donation_id":"NVBSP20185000018","blood_type":"A pos","reviewed_endorsed_by":"badz","created_by":"13006","created_dt":"2018-05-05 10:51:13","updated_by":null,"updated_dt":null},"labels":[],"processing":{"facility_cd":"13006","bloodproc_no":"1300620180008495","bloodproc_dt":"2018-05-05 10:50:08","donation_id":"NVBSP20185000018","blood_bag":"D","adtl_bloodbag":null,"created_by":"13006","updated_by":null,"created_dt":"2018-05-05 10:50:08","updated_dt":null},"test":{"facility_cd":"13006","bloodtest_no":"1300620180008368","bloodtest_dt":"2018-05-05 10:52:25","donation_id":"NVBSP20185000018","result":"N","created_by":"13006","created_dt":"2018-05-05 10:52:25","updated_by":"badz","updated_dt":null},"units":[{"donation_id":"NVBSP20185000018","component_cd":20,"blood_type":"A pos","location":"13006","expiration_dt":"2018-06-02 00:00:00","component_vol":"250","comp_stat":"FBT","created_by":"13006","created_dt":"2018-05-05 10:50:08","updated_by":null,"updated_dt":null},{"donation_id":"NVBSP20185000018","component_cd":30,"blood_type":"A pos","location":"13006","expiration_dt":"2018-05-03 00:00:00","component_vol":"150","comp_stat":"FBT","created_by":"13006","created_dt":"2018-05-05 10:50:08","updated_by":null,"updated_dt":null}]},{"seqno":"1300620180008638","donation_id":"NVBSP20185000019","donor_sn":null,"sched_id":"1300620180000299","pre_registered":"Y","donation_type":"V","collection_method":"WB","donation_stat":"A","facility_cd":"13006","mh_pe_stat":"A","mh_pe_deferral":null,"mh_pe_question":null,"mh_pe_remark":null,"collection_type":null,"collection_stat":"COL","coluns_res":null,"blood_bag":"T","created_by":"13006","created_dt":"2018-05-05 10:49:16","updated_by":null,"updated_dt":null,"type":{"bloodtyping_no":"1300620180008447","facility_cd":"13006","bloodtyping_dt":"2018-05-05 10:51:18","donation_id":"NVBSP20185000019","blood_type":"A pos","reviewed_endorsed_by":"badz","created_by":"13006","created_dt":"2018-05-05 10:51:18","updated_by":null,"updated_dt":null},"labels":[],"processing":{"facility_cd":"13006","bloodproc_no":"1300620180008496","bloodproc_dt":"2018-05-05 10:50:08","donation_id":"NVBSP20185000019","blood_bag":"T","adtl_bloodbag":null,"created_by":"13006","updated_by":null,"created_dt":"2018-05-05 10:50:08","updated_dt":null},"test":{"facility_cd":"13006","bloodtest_no":"1300620180008369","bloodtest_dt":"2018-05-05 10:52:25","donation_id":"NVBSP20185000019","result":"N","created_by":"13006","created_dt":"2018-05-05 10:52:25","updated_by":"badz","updated_dt":null},"units":[{"donation_id":"NVBSP20185000019","component_cd":20,"blood_type":"A pos","location":"13006","expiration_dt":"2018-06-02 00:00:00","component_vol":"250","comp_stat":"FBT","created_by":"13006","created_dt":"2018-05-05 10:50:08","updated_by":null,"updated_dt":null},{"donation_id":"NVBSP20185000019","component_cd":30,"blood_type":"A pos","location":"13006","expiration_dt":"2018-05-03 00:00:00","component_vol":"150","comp_stat":"FBT","created_by":"13006","created_dt":"2018-05-05 10:50:08","updated_by":null,"updated_dt":null},{"donation_id":"NVBSP20185000019","component_cd":40,"blood_type":"A pos","location":"13006","expiration_dt":"2019-04-28 00:00:00","component_vol":"50","comp_stat":"FBT","created_by":"13006","created_dt":"2018-05-05 10:50:08","updated_by":null,"updated_dt":null}]},{"seqno":"1300620180008639","donation_id":"NVBSP20185000020","donor_sn":null,"sched_id":"1300620180000299","pre_registered":"Y","donation_type":"V","collection_method":"WB","donation_stat":"A","facility_cd":"13006","mh_pe_stat":"A","mh_pe_deferral":null,"mh_pe_question":null,"mh_pe_remark":null,"collection_type":null,"collection_stat":"COL","coluns_res":null,"blood_bag":"S","created_by":"13006","created_dt":"2018-05-05 10:49:16","updated_by":null,"updated_dt":null,"type":{"bloodtyping_no":"1300620180008448","facility_cd":"13006","bloodtyping_dt":"2018-05-05 10:51:23","donation_id":"NVBSP20185000020","blood_type":"A pos","reviewed_endorsed_by":"badz","created_by":"13006","created_dt":"2018-05-05 10:51:23","updated_by":null,"updated_dt":null},"labels":[],"processing":{"facility_cd":"13006","bloodproc_no":"1300620180008497","bloodproc_dt":"2018-05-05 10:50:08","donation_id":"NVBSP20185000020","blood_bag":"S","adtl_bloodbag":null,"created_by":"13006","updated_by":null,"created_dt":"2018-05-05 10:50:08","updated_dt":null},"test":{"facility_cd":"13006","bloodtest_no":"1300620180008370","bloodtest_dt":"2018-05-05 10:52:26","donation_id":"NVBSP20185000020","result":"N","created_by":"13006","created_dt":"2018-05-05 10:52:26","updated_by":"badz","updated_dt":null},"units":[{"donation_id":"NVBSP20185000020","component_cd":10,"blood_type":"A pos","location":"13006","expiration_dt":"2018-06-02 00:00:00","component_vol":"500","comp_stat":"FBT","created_by":"13006","created_dt":"2018-05-05 10:50:08","updated_by":null,"updated_dt":null}]}];
      },
      hasUnit(units,cd){
        //   console.log(_.filter(units,{component_cd : 10}));
          return _.filter(units,{component_cd : cd*1}).length > 0;
      },
      isAlreadyLabeled(labels,cd){
          return _.filter(labels,{component_cd : cd}).length > 0;
      },
      selectUnit(donation_id,component_cd){
          let criteria = {'donation_id' : donation_id, 'component_cd' : component_cd*1};
          let unit = _.find(this.selected,criteria);
          if(unit){
              this.selected = _.reject(this.selected,criteria);
          }else{
              this.selected.push(criteria);
          }
      },
      clone(obj){
          return _.clone(obj);
      }
  },
  watch : {
      sched(){
          this.$store.state.sched = this.sched;
      },
      refresh(){
          this.selected = [];
          this.donations = [];
          this.loading = false;
          this.fetchDonations();
      },
      component_cd(){
        let {component_cd} = this;
        if(component_cd){
            this.components = _.pickBy(this.all_components, function(value, key){
                return key == component_cd;
            });
        }else{
            this.components = _.clone(this.all_components);
        }
      }
  }
}
</script>

<style scoped>
.control-label {
    margin-top:-.5em;
    font-size: 14px;
}
input[type='checkbox']{
    width:15px;
    height:15px;
}

</style>