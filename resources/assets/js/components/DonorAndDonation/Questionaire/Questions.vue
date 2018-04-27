<template>
  <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#mh" aria-controls="mh" role="tab" data-toggle="tab">Medical History</a></li>
            <li role="presentation"><a href="#pe" aria-controls="pe" role="tab" data-toggle="tab">Physical Examination</a></li>
        </ul>
       <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="mh">
                <div class="panel panel-primary">
                    <table class="table table-condensed table-bordered">
                        <tbody v-for="question in questions" :key="question.question_no" >
                            <tr style="font-size:14px;" class="text-danger">
                                <td colspan="3" v-html="question.txt"></td>
                            </tr>
                            <tr v-for="(txt,i) in question.questions" :key="i" style="font-size:12px;">
                                <td>{{i}}.</td>
                                <td v-html="txt"></td>
                                <td>
                                    <input type="checkbox" v-model="selections" :value="i">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="pe">
                <div class="panel panel-primary form-horizontal">
                    <div class="panel-body">
                        <table class="table table-condensed table-bordered">
                            <tbody>
                                <tr>
                                    <th colspan="2">Hemoglobin</th>
                                </tr>
                                <tr>
                                    <td class="col-xs-4 small-right">Low Hemoglobin</td>
                                    <td>
                                        <input type="radio" name="hemoglobin" value="L" v-model="hemoglobin">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="small-right">High Hemoglobin</td>
                                    <td>
                                        <input type="radio" name="hemoglobin" value="H" v-model="hemoglobin">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">Body Weight</th>
                                </tr>
                                <tr>
                                    <td class="col-xs-4 small-right">Low Body Weight</td>
                                    <td>
                                        <input type="radio" name="bodyweight" value="L" v-model="bodyweight">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="small-right">High Body Weight</td>
                                    <td>
                                        <input type="radio" name="bodyweight" value="H" v-model="bodyweight">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">Blood Pressure</th>
                                </tr>
                                <tr>
                                    <td class="col-xs-4 small-right">Low Blood Pressure</td>
                                    <td>
                                        <input type="radio" name="bloodpressure" value="L" v-model="bloodpressure">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="small-right">High Blood Pressure</td>
                                    <td>
                                        <input type="radio" name="bloodpressure" value="H" v-model="bloodpressure">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">Pulse Rate</th>
                                </tr>
                                <tr>
                                    <td class="col-xs-4 small-right">Low Pulse Rate</td>
                                    <td>
                                        <input type="radio" name="pulserate" value="L" v-model="pulserate">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="small-right">High Pulse Rate</td>
                                    <td>
                                        <input type="radio" name="pulserate" value="H" v-model="pulserate">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">Temperature</th>
                                </tr>
                                <tr>
                                    <td class="col-xs-4 small-right">Low Temperature</td>
                                    <td>
                                        <input type="radio" name="temperature" value="L" v-model="temperature">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="small-right">High Temperature</td>
                                    <td>
                                        <input type="radio" name="temperature" value="H" v-model="temperature">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <button class="btn btn-xs btn-default" @click="clearPE">Clear Selections</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>

export default {
    props : ['reuse'],
    data(){
        return this.defaults();
    },
    mounted(){
        this.fetchQuestions();
    },
    watch : {
        reuse(){
            this.selections = [];
            this.hemoglobin = null;
            this.bodyweight = null;
            this.bloodpressure = null;
            this.pulserate = null;
            this.temperature = null;
        },
        selections(){
            this.compute();
        },
        hemoglobin(){
            this.compute();
        },
        bodyweight(){
            this.compute();
        },
        bloodpressure(){
            this.compute();
        },
        pulserate(){
            this.compute();
        },
        temperature(){
            this.compute();
        }
   },
   methods: {
       defaults(){
           return {
                questions : [], selections : [], hemoglobin : null, bodyweight : null, bloodpressure : null, pulserate : null, temperature : null
            }
       },
       fetchQuestions(){
           this.$http.get(this,'dhq/questions')
            .then(({data}) => {
                this.questions = _.orderBy(data,['no'],['desc']);
            })
            .catch(error => {
                this.$store.state.error = error;
            });
       },
       clearPE(){
           this.hemoglobin = null;
           this.bodyweight = null;
           this.bloodpressure = null;
           this.pulserate = null;
           this.temperature = null;
       },
       compute(){
           let pe = [];
           if(this.hemoglobin == 'L'){
               pe.push("Low Hemoglobin");
           }else if(this.hemoglobin == 'H'){
               pe.push("High Hemoglobin");
           }
           if(this.bloodpressure == 'L'){
               pe.push("Low Blood Pressure");               
           }else if(this.bloodpressure == 'H'){
               pe.push("High Blood Pressure");
           }
           if(this.bodyweight == 'L'){
               pe.push("Low Body Weight");               
           }else if(this.bodyweight == 'H'){
               pe.push("High Body Weight");
           }
           if(this.pulserate == 'L'){
               pe.push("Low Pulse Rate");               
           }else if(this.pulserate == 'H'){
               pe.push("High Pulse Rate");
           }
           if(this.temperature == 'L'){
               pe.push("Low Temperature");               
           }else if(this.temperature == 'H'){
               pe.push("High Temperature");
           }
           let res = {
                questions : this.selections.join(","),
                pe : pe.join(",")
            };
            this.$emit("onselect",res);
       }
   }
}
</script>

<style scoped>
    .small-right{
        text-align:right;
        font-size:12px;
    }
</style>
