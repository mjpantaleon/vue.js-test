<template>
  <div>
      <loading v-if="loading"></loading>
      <div class="row" v-if="agency">
          <div class="col-lg-8">
              <div class="panel panel-success">
                  <div class="panel-heading">Agency Details
                      <div class="pull-right">
                        <router-link to="/Agency" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Back to List</router-link>
                        <router-link :to="('/Agency/update/'+agency_cd)" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span> Edit</router-link>
                      </div>
                  </div>
                    <ul class="list-group" style="font-size:14px;">
                        
                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Agency Code</div>
                                    <div class="col-lg-6">{{ agency.agency_cd }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Agency Name</div>
                                    <div class="col-lg-6">{{ agency.agency_name }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Donor Recruitment Officer</div>
                                    <div class="col-lg-6">{{ agency.owner }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Contact Person</div>
                                    <div class="col-lg-6">{{ agency.contact_person }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Designation</div>
                                    <div class="col-lg-6">{{ agency.designation }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Region</div>
                                    <div class="col-lg-6">{{ agency.region.regname }}</div>
                                </div>
                            </div>
                        </li>

                        <!-- li.list-group-item>div.list-group-item-text>div.row>div.col-lg-6*2 -->

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Province</div>
                                    <div class="col-lg-6">{{ agency.province.provname }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">City</div>
                                    <div class="col-lg-6">{{ agency.city.cityname }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Barangay</div>
                                    <div class="col-lg-6">{{ (agency.barangay ? agency.barangay.bgyname : null) }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Zip Code</div>
                                    <div class="col-lg-6">{{ agency.adg_zip }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Tel No.</div>
                                    <div class="col-lg-6">{{ agency.adg_tel }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Mobile No.</div>
                                    <div class="col-lg-6">{{ agency.mobile_tel }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Fax No.</div>
                                    <div class="col-lg-6">{{ agency.adg_fax }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Email</div>
                                    <div class="col-lg-6">{{ agency.email_ad }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Date Created</div>
                                    <div class="col-lg-6">{{ agency.created_dt }}</div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="list-group-item-text">
                                <div class="row">
                                    <div class="col-lg-6">Last Update</div>
                                    <div class="col-lg-6">{{ agency.updated_dt }}</div>
                                </div>
                            </div>
                        </li>
                    </ul>
              </div>
          </div>
      </div>
  </div>
</template>

<script>

export default {
  props : ['agency_cd'],
  data(){
      return {
          loading : false, agency : null
      }
  },
  mounted(){
      this.loading = true;
      this.$http.get(this,"agency/info/" + this.agency_cd)
      .then( ({data}) => {
        this.agency = data;
        this.loading = false;
      })
      .catch( error => {
          this.$store.state.error = error;
      });
  }
}
</script>
