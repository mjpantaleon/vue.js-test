<template>
  <div>
    <div class="form-group">
        <label for="" class="control-label col-lg-4">{{prefix}} Region</label>
        <div class="col-lg-8">
            <select v-model="region" class="form-control input-sm">
                <option v-for="(name,i) in regions" :key="i" :value="i">{{name}}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="control-label col-lg-4">{{prefix}} Province</label>
        <div class="col-lg-8">
            <select v-model="province" class="form-control input-sm">
                <option v-for="(name,i) in provinces" :key="i" :value="i">{{name}}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="control-label col-lg-4">{{prefix}} City/Municipality</label>
        <div class="col-lg-8">
            <select v-model="city" class="form-control input-sm">
                <option v-for="(name,i) in cities" :key="i" :value="i">{{name}}</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="control-label col-lg-4">{{prefix}} Barangay</label>
        <div class="col-lg-8">
            <select v-model="barangay" class="form-control input-sm">
                <option v-for="(name,i) in barangays" :key="i" :value="i">{{name}}</option>
            </select>
        </div>
    </div>
  </div>
</template>

<script>

export default {
  props : ['defaults'],
  data(){
      return {
          prefix : null,
          region : null, province : null, city : null, barangay : null,
          regions : [], provinces : [], cities : [], barangays : []
      }
  },
  computed : {
      headers(){
          return {
              headers : {
                    Authorization : this.$store.state.token.access_token,
                }
          };
      },
  },
  mounted(){
      if(this.defaults.prefix){
          this.prefix = this.defaults.prefix;
      }
      let {region,province,city,barangay} = this.defaults;
      this.fetchRegion();
      this.region = region;
      this.province = province;
      this.city = city;
      this.barangay = barangay;
  },
  methods : {
      fetchRegion(){
          let {headers} = this;
          this.$http.get(this,"address/regions",headers)
          .then( ({data}) => {
              this.regions = data;
          })
        //   .catch(error => {
        //       this.$store.state.error = error;
        //   });
      },
      hasChanged(){
          this.$emit('onchange',this.$data);
      }
  },
  watch : {
      region(){
          let {headers} = this;
          this.cities = []; this.barangays = [];
          this.$http.get(this,"address/provinces/"+this.region)
          .then( ({data}) => {
              this.provinces = data;
          })
        //   .catch(error => {
        //       this.$store.state.error = error;
        //   });
          this.hasChanged();
      },
      province(){
          let {headers} = this;
          this.barangays = [];
          this.$http.get(this,"address/cities/"+this.province)
          .then( ({data}) => {
              this.cities = data;
          })
        //   .catch(error => {
        //       this.$store.state.error = error;
        //   });
          this.hasChanged();
      },
      city(){
          let {headers} = this;
          this.$http.get(this,"address/barangays/"+this.city)
          .then( ({data}) => {
              this.barangays = data;
          })
        //   .catch(error => {
        //       this.$store.state.error = error;
        //   });
          this.hasChanged();
      },
      barangay(){
          this.hasChanged();
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