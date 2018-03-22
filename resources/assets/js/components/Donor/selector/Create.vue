<template>
  <div class="row">
      <div v-if="!loading">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    MBD Details
                    <router-link :to="('../AddDonor')" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-arrow-left"></span> Back to List</router-link>
                </div>
                <table class="table table-condensed table-bordered">
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-user"></span> Add New Donor
                </div>
                <div class="panel-body form-horizontal">
                    <donor-pic-capture @oncomplete="setPhoto"></donor-pic-capture>
                    <div class="form-group required">
                        <label for="" class="control-label col-lg-3">First Name</label>
                        <div class="col-lg-9"><input type="text" class="form-control input-sm" v-model="fname"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-3">Middle Name</label>
                        <div class="col-lg-9"><input type="text" class="form-control input-sm" v-model="mname"></div>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label col-lg-3">Last Name</label>
                        <div class="col-lg-9"><input type="text" class="form-control input-sm" v-model="lname"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-3">Name Suffix</label>
                        <div class="col-lg-9"><input type="text" class="form-control input-sm" v-model="name_suffix"></div>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label col-lg-3">Gender</label>
                        <div class="col-lg-9">
                            <select class="form-control input-sm" v-model="gender">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label col-lg-3">Birth Date</label>
                        <div class="col-lg-9"><input type="date" class="form-control input-sm" v-model="bdate"></div>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label col-lg-3">Civil Status</label>
                        <div class="col-lg-9">
                            <select class="form-control input-sm" v-model="civil_stat">
                                <option v-for="(val,code) in $session.get('civil_status')" :key="code" :value="code">{{val}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-3">Nationality</label>
                        <div class="col-lg-9">
                            <select class="form-control input-sm" v-model="nationality">
                                <option v-for="nation in nations" :key="nation.countrycode" :value="nation.countrycode">{{nation.nation}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-3">Telephone</label>
                        <div class="col-lg-9"><input type="text" class="form-control input-sm" v-model="tel_no"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-3">Mobile Phone</label>
                        <div class="col-lg-9"><input type="text" class="form-control input-sm" v-model="mobile_no"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-3">Email</label>
                        <div class="col-lg-9"><input type="email" class="form-control input-sm" v-model="email"></div>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home Address</a></li>
                        <li role="presentation"><a href="#office" aria-controls="office" role="tab" data-toggle="tab">Office Address</a></li>
                    </ul>

                    <donor-addresses @home="setHome" @office="setOffice"></donor-addresses>
                    <!-- div.form-group.required>label.control-label.col-lg-3+div.col-lg-9>input.form-control.input-sm -->
                    
                </div>
                <div class="panel-footer">
                    <button class="btn btn-default" @click.prevent="save">Add Donor</button>
                </div>
            </div>

        </div>
      </div>
      <loading v-if="loading"></loading>
      
  </div>
</template>

<script>
import loading from "./../../Loading.vue";
import DonorPicCapture from './create/DonorPhoto.vue';
import DonorAddresses from './create/DonorAddresses.vue';

export default {
  components : {loading,DonorPicCapture,DonorAddresses},
  props : ['sched_id'],
  data(){
      return { 
          mbd: null,loading : true, donor_photo : null, nations : [],
          fname : null, mname : null, lname : null, name_suffix : null, gender : null, bdate : null, civil_stat : null, tel_no : null, mobile_no : null, email : null, 
          home : null, office : null,
          nationality : 137
      };
  },
  mounted(){
      this.$http.get(this,"mbd/shortinfo/"+this.sched_id)
      .then(({data}) => {
          this.mbd = data;
          this.loading = false;
      })
      .catch(error => {
          this.$store.state.error = error;
      });

      this.$http.get(this,"keyvalues/nations")
      .then(({data}) => {
          this.nations = _.orderBy(data,['nation']);
      })
      .catch(error => {
          this.$store.state.error = error;
      });
  },
  methods: {
        setPhoto(photo){
            this.donor_photo = photo;
        },
        setHome(address){
            this.home = address;
        },
        setOffice(address){
            this.office = address;
        },
        save(){
            this.loading = true;
        }
    }
}
</script>

<style scoped>
.control-label {
    margin-top:-.5em;
    font-size: 14px;
}
.form-group.required .control-label:after {
  content:"*";
  color:red;
}
</style>
