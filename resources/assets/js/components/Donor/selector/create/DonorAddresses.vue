<template>
  <div>
      <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <br/>
                <address-picker  :defaults="homeAddressDefault" @onchange="homeChanged"></address-picker>
                <div class="form-group">
                    <label for="" class="control-label col-lg-4">Home Zip</label>
                    <div class="col-lg-8"><input type="text" class="form-control input-sm" v-model="home_zip"></div>
                </div>
                
            </div>
            <div role="tabpanel" class="tab-pane" id="office">
                <br/>
                <address-picker :defaults="officeAddressDefault" @onchange="officeChanged"></address-picker>
                <div class="form-group">
                    <label for="" class="control-label col-lg-4">Office Zip</label>
                    <div class="col-lg-8"><input type="text" class="form-control input-sm" v-model="office_zip"></div>
                </div>

            </div>
        </div>
  </div>
</template>

<script>
import addressPicker from "./../../../Address.vue";

export default {
  components : {addressPicker},
  data(){
      return {
          home_region : null, home_prov : null, home_citymun : null, home_brgy : null, home_zip : null,
          office_region : null, office_prov : null, office_citymun : null, office_brgy : null, office_zip : null
      };
  },
  computed : {
      homeAddressDefault(){
          let {address_region,address_prov,address_citymun,address_bgy} = this.$session.get('user').facility;
          return {
              region : address_region, province : address_prov, city : address_citymun, barangay : address_bgy, prefix : 'Home '
          };
      },
      officeAddressDefault(){
          let {address_region,address_prov,address_citymun,address_bgy} = this.$session.get('user').facility;
          return {
              region : address_region, province : address_prov, city : address_citymun, barangay : address_bgy, prefix : 'Office '
          };
      }
  },
  methods : {
    homeChanged({region,province,city,barangay}){
        this.home_region = region;
        this.home_prov = province;
        this.home_citymun = city;
        this.home_brgy = barangay;
        this.$emit("home",{
            region, province, city, barangay
        });
    },
    officeChanged({region,province,city,barangay}){
        this.office_region = region;
        this.office_prov = province;
        this.office_citymun = city;
        this.office_brgy = barangay;
        this.$emit("office",{
            region, province, city, barangay
        });
    }
    
  }
}
</script>

