<template>
    <tr>
        <td style="font-size:12px;vertical-align:top; padding-top:1em;">{{row+1}}</td>
        <td :style="mh_pe_remarks ? 'font-size:12px;vertical-align:top; padding-top:1em;' : 'font-size:12px;vertical-align:middle;'" class="col-lg-3">
            {{donation.donor.fname | uppercase}} 
            {{donation.donor.mname | uppercase}} 
            {{donation.donor.lname | uppercase}} 
        </td>
        <td>
            <select class="form-control input-sm" v-model="donation.donation_stat">
                <option value="A">Accepted</option>
                <option value="TD">Temporary Deferred</option>
                <option value="PD">Permanently Deferred</option>
                <option value="ID">Indefinitely Deferred</option>
            </select>
        </td>
        <td>
            <input type="text" class="form-control input-sm" v-model="donation.mh_pe_question"  :disabled="donation.donation_stat == 'A' || !donation.donation_stat">
        </td>
        <td class="col-lg-2">
            <div class="input-group">
                <input type="text" class="form-control input-sm" v-model="new_remark" :disabled="donation.donation_stat == 'A' || !donation.donation_stat">
                <div class="input-group-btn"><button class="btn btn-success btn-sm" :disabled="!new_remark" @click="saveRemark"><span class="glyphicon glyphicon-ok"></span></button></div>
            </div>
            <span v-if="mh_pe_remarks">
                <div class="btn-group" v-for="(remark,i) in mh_pe_remarks" :key="i" style="margin:0.5em;">
                    <button class="btn btn-danger btn-xs" @click="removeRemark(remark)">{{remark}}</button>
                    <button class="btn btn-default btn-xs" @click="removeRemark(remark)"><span class="glyphicon glyphicon-remove text-danger"></span></button>
                </div>
            </span>
        </td>
        <td>
            <select class="form-control input-sm" v-model="donation.collection_stat" :disabled="!donation.donation_stat || donation.donation_stat != 'A'">
                <option value="COL">Successful</option>
                <option value="UNS">Unsuccessfuly</option>
            </select>
        </td>
        <td>
            <input type="text" class="form-control input-sm" v-model="donation.donation_id"  :disabled="!donation.donation_stat || donation.donation_stat != 'A'">
        </td>
        <td>
            <input type="text" class="form-control input-sm" v-model="donation.coluns_res" :disabled="!donation.donation_stat || (!donation.collection_stat || donation.collection_stat != 'UNS')">
        </td>
    </tr>
</template>

<script>
import filters from './../../../../filters';
export default {
  filters,
  props : ['donation','donation_statuses','row'],
  data(){
      return {
          mh_pe_remarks : [], new_remark : null
      }
  },
  methods : {
      saveRemark(){
          this.mh_pe_remarks.push(this.new_remark);
          this.new_remark = null;
      },
      removeRemark(remark){
          this.mh_pe_remarks = _.filter(this.mh_pe_remarks,(r) => {
              return r !== remark;
          });
      }
  },
  watch : {
      mh_pe_remarks(){
          this.donation.mhpe_remark = this.mh_pe_remarks.join(',');
      }
  }
}
</script>
