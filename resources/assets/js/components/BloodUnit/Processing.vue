<template>
  <div>
      <list v-show="!editing" @hasSelected="setSelections" :updated="refresh"></list>
      <editing v-if="editing" :donationids="selections" @cancel="selections = []; editing = false; refresh++;"></editing>
  </div>
</template>

<script>
import List from './Processing/List.vue';
import Editing from './Processing/Editing.vue';

export default {
    components : {List,Editing},
    data(){
        return {
            selections : [{"seqno":"1300620180000002","donation_id":"NVBSP20185000001","donor_sn":"1300620180026979","sched_id":"1300620180000636","pre_registered":"N","donation_type":"V","collection_method":"WB","donation_stat":"A","facility_cd":"13006","mh_pe_stat":"A","mh_pe_deferral":null,"mh_pe_question":null,"mh_pe_remark":null,"collection_type":null,"collection_stat":"COL","coluns_res":null,"blood_bag":"D","created_by":"13006","created_dt":"2018-04-26 10:20:37","updated_by":"13006_jag","updated_dt":"2018-04-30 15:18:41","processing":null,"type":null,"test":null,"mbd":{"sched_id":"1300620180000636","agency_cd":"1300601860","agency_name":"NVBSP-IMU","facility_cd":"13006","donation_dt":"2018-04-20 00:00:00","remarks":null,"mbd_status":"1","created_by":"13006","created_dt":"2018-04-20 09:27:41","updated_by":null,"updated_dt":null}}]
            , editing : true, refresh : 0
        }
    },
    methods : {
        setSelections(selected){
            this.selections = selected;
            this.editing = true;
        }
    }
}
</script>
