<template>
  <tr v-if="rules">
        <td>{{no}}</td>
        <td>{{donation.donation_id}}</td>
        <td>{{donation.type ? donation.type.blood_type : ''}}</td>
        <td>{{bloodBags[donation.blood_bag]}}</td>
        <th v-for="(cn,cd) in components" :key="cd" width="100">
            <input type="number" class="form-control input-sm" @keyup="updateAllowedSet" v-model="donation.units[cd]" :disabled="!isAllowed(cd)" @focus="donation.units[cd] = null">
        </th>
  </tr>
</template>

<script>
export default {    
  props : ['no','donation','components','bloodBags','rules'],
  data(){
      let o_components = [];
      for(let c in this.components){
          o_components.push({component_cd : c});
      }
      let allowed = _.clone(o_components);
      allowed.forEach(allow => {
          allow.component_cd *= 1;
      });
      let sets = [];
      this.rules.forEach(set => {
          let s = [];
          set.forEach(component_cd => {
              s.push({component_cd});
          })
          sets.push(s);
      })
      return {
          o_components, allowed, sets
      };
  },
  mounted(){
    //   this.updateAllowedSet();
  },
  methods : {
      isAllowed(component_cd){
          return _.filter(this.allowed,{component_cd : component_cd*1}).length > 0;
      },
      updateAllowedSet(){
          let {sets,o_components,donation:{units}} = this;
          let hasValue = 0;
          for(let component_cd in units){
              if(units[component_cd]){
                  hasValue++;
              }
          }
          if(!hasValue){
              this.allowed = _.clone(this.o_components);
              return;
          }else if(this.allowed.length == this.o_components.length){
              for(let component_cd in units){
                  if(units[component_cd]){
                      sets.forEach( set => {
                          if(_.filter(set,{component_cd : component_cd*1}).length){
                              this.allowed = set;
                          }
                      })
                  }
              }
          }
      }
  }
}
</script>
