<template>
    <table class="table table-bordered table-condensed">
        <thead>
            <tr style="font-size:12px;">
                <th>#</th>
                <th>Donor</th>
                <th>MH/PE Result</th>
                <th>MH/PE Deferral</th>
                <th>Other Reason</th>
                <th>Collection Status</th>
                <th>Donation ID</th>
                <th>Unsuccessfuly Collection Reason</th>
            </tr>
        </thead>
        <tbody>
            <phlebotomy-row v-for="(donation,i) in donations" :row="i" :key="donation.seqno" :donation="donation" @onupdate="donationUpdated"></phlebotomy-row>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8">
                    <button class="btn btn-default btn-xs" @click="validateForm"><span class="glyphicon glyphicon-ok"></span> Save Changes</button>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
import PhlebotomyRow from './Phlebotomy/Row.vue';

export default {
  components : {PhlebotomyRow},
  props : ['donations'],
  data(){
      return {formErrors : []};
  },
  watch : {
      formErrors(){
          this.$emit("onerror",this.formErrors);
      }
  },
  computed : {
      donationToSubmit(){
          return this.donations;
      }
  },
  methods : {
      donationUpdated(donation){
          this.donationToSubmit.forEach(d => {
              if(d.seqno = donation.seqno){
                  d = donation;
              }
          });
      },
      validateForm(){
          this.formErrors = [];
          let i = 1;
          this.donations.forEach(donation => {
              let {donation_stat,donation_id,collection_stat,coluns_res,mhpe_question,mhpe_remark} = donation;
              let err = [];
              if(!donation_stat){
                  err.push('Invalid MH/PE Result at row no. '+i);
              }else if(donation_stat != 'A' && (!mhpe_question && !mhpe_remark)){
                  err.push('Please provide MH/PE deferral reason at row no. '+i);
              }
              if(donation_stat == 'A' && !collection_stat){
                  err.push('Invalid Collection Status provided at row no. '+i);
              }
              if(donation_stat == 'A' && collection_stat == 'UNS' && !coluns_res){
                  err.push('Please provide Reason for Unsuccesfull collection at row no. '+i);
              }
              if(donation_stat == 'A' && donation_id.length != 16){
                  err.push('Invalid Donation ID at row no. '+i);
              }
              if(err){
                  this.formErrors.push(err);
              }
              i++;
          });
          
          if(this.formErrors){
              return false;
          }else{
              this.processForm();
          }
      },
      processForm(){
          
      }
  }
}
</script>
