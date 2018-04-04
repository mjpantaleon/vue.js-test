<template>
    <div>
        <div class="row" v-if="!loading && mbd">
            <div class="col-lg-6">
                <div class="panel panel-success">
                    <div class="panel-heading">MBD Details
                        <router-link to="/MBD" class="pull-right btn btn-default btn-xs"><span class="glyphicon glyphicon-arrow-left"></span> Back to List</router-link>
                    </div>
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Agency</th><td>{{ mbd.agency_name }}</td>
                            </tr>
                            <tr>
                                <th>Date</th><td>{{ mbd.donation_dt.substr(0,10) }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="col-lg-12">
                <donations :schedid="mbd.sched_id"></donations>
            </div>
        </div>
        <loading v-if="loading"></loading>
    </div>
</template>

<script>
import loading from './../Loading.vue';
import rowloading from './../LoadingInline.vue';
import Donations from './Manager/Donations.vue';

export default {
  components : { loading, rowloading, Donations },
  props : ['sched_id'],
  data(){
      return  {
          mbd : null, loading : false, selected : [],
          headers : {headers : { Authorization : this.$store.state.token.access_token }}
      }
  },
  methods : {
  },
  mounted(){
      this.loading = true;
      this.$http.get(this,"mbd/info/"+this.sched_id)
      .then(({data}) => {
          this.mbd = data;
          this.loading = false;
      })
      .catch(error => {
          this.$store.state.error = error;
      });
  }
}
</script>

