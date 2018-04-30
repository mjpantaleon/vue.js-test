<template>
  <tr v-if="rules">
        <td>{{no}}</td>
        <td>{{donation.donation_id}}</td>
        <td>{{donation.blood_type}}</td>
        <td>{{bloodBags[donation.blood_bag]}}</td>
        <th v-for="(cn,cd) in components" :key="cd" width="100">
            <input type="number" class="form-control input-sm" v-model="donation.units[cd]">
        </th>
  </tr>
</template>

<script>
export default {
  props : ['no','donation','components','bloodBags','rules'],
  data(){
      return {

      };
  },
  watch: {
      rules(){
          if(!this.rules){
              return;
          }
            console.log(this.allow(10));
      }
  },
  methods : {
      allow(component_cd){
          if(!this.rules){
              return;
          }
          let rule = this.rules[this.donation.blood_bag];
          rule.forEach( r => {
              console.log(r);
            //   r.forEach( l => {
            //   });
            //   console.log(_.findIndex(r,component_cd));
            //   if(_.findIndex(r,component_cd)){
            //       return true;
            //   }
          });
          
          return false;
      }
  }
}
</script>
