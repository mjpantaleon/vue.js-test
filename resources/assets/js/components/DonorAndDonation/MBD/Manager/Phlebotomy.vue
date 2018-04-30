<template>
    <div>
        <div v-show="!verify">
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
                    <phlebotomy-row v-for="(donation,i) in donations" :row="i" :key="donation.seqno" :donation="donation" @onupdate="donationUpdated" @mhpeClicked="launchMHPEQuestionaire(donation)"></phlebotomy-row>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">
                            <button class="btn btn-default btn-xs pull-left" @click="validateForm"><span class="glyphicon glyphicon-ok"></span> Save Changes</button>
                            <loadingInline label="Please wait.." class="pull-left" v-if="loading"></loadingInline>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <questionaire-window @oncomplete="mhpeDone" :reuse="reuse"></questionaire-window>
        </div>
        <verifier v-show="verify" @cancel="verify = false" @proceed="processForm"></verifier>
    </div>
</template>

<script>

import QuestionaireWindow from './../../Questionaire/Window.vue';
import PhlebotomyRow from './Phlebotomy/Row.vue';

export default {
  components : {PhlebotomyRow,QuestionaireWindow},
  props : ['donations'],
  data(){
      return {formErrors : [], currentMhPeField : null, reuse : 0, loading : false, verify : false};
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
      launchMHPEQuestionaire(donation){
          this.currentMhPeField = donation;
          this.reuse++;
      },
      mhpeDone(selections){
          this.currentMhPeField.mh_pe_question = selections.questions;
          if(selections.pe){
            this.currentMhPeField.mh_pe_remark = selections.pe;
          }
      },
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
              if(donation_stat == 'A'){
                  let duplicate = donation_id ? _.filter(this.donations,{donation_id}).length : 0;

                  if(!donation_id || donation_id == ''){
                      err.push('Invalid Donation ID at row no. '+i);
                  }else if(donation_id.length != 16){
                      err.push('Invalid Donation ID at row no. '+i);
                  }else if(duplicate > 1){
                      err.push('Duplicate Donation ID at row no. '+i);
                  }else if(!donation_id.startsWith('NVBSP')){
                      err.push('Invalid format for Donation ID at row no. '+i);
                  }
              }
              if(err){
                  this.formErrors.push(err);
              }
              i++;
          });
          
          if(this.formErrors.toString().replace(/[,]+/g,'').length > 0){
              return false;
          }else{
              this.verify = true;
            //   this.processForm();
          }
      },
      processForm(verifier){
          this.loading = true;
          let donation_ids = _.map(this.donations,'donation_id');
          let that = this;
          this.$http.post(this,"mbd/checkDonationIDs",{donation_ids,verifier})
          .then(({data}) => {
              if(data.length > 0){
                  this.loading = false;
                  this.formErrors = data;
              }else{
                  that.saveChanges(verifier);
              }
          })
      },
      saveChanges(verifier){
        let done = _.debounce(() => {
            this.loading = false;
            this.$emit("oncomplete");
        },1500);

        done();

        let {donations} = this;
        let user = this.$session.get('user');
        this.$http.post(this,"mbd/updateDonationDetails",{
            donations, user
        },({data}) => {
            
        });
      }
  }
}
</script>