<template>
  <div>
      <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <br/>
                <address-picker  :defs="homeAddressDefault" @onchange="homeChanged"></address-picker>
                <div class="form-group">
                    <label for="" class="control-label col-lg-4">Home Zip</label>
                    <div class="col-lg-8"><input type="text" class="form-control input-sm" v-model="home_zip" @keyup="homeChanged"></div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-4" style="font-size:10px;">House No. / Street / Block</label>
                    <div class="col-lg-8"><input type="text" class="form-control input-sm" v-model="home_no_st_blk" @keyup="homeChanged"></div>
                </div>                
            </div>
            <div role="tabpanel" class="tab-pane" id="office">
                <br/>
                <address-picker :defs="officeAddressDefault" @onchange="officeChanged"></address-picker>
                <div class="form-group">
                    <label for="" class="control-label col-lg-4">Office Zip</label>
                    <div class="col-lg-8"><input type="text" class="form-control input-sm" v-model="office_zip" @keyup="officeChanged"></div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-4" style="font-size:10px;">House No. / Street / Block</label>
                    <div class="col-lg-8"><input type="text" class="form-control input-sm" v-model="office_no_st_blk" @keyup="officeChanged"></div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>

export default {
  props : ['donor'],
  data(){
      return {
          home_region : null, home_prov : null, home_citymun : null, home_brgy : null, home_zip : null, home_no_st_blk : null,
          office_region : null, office_prov : null, office_citymun : null, office_brgy : null, office_zip : null, office_no_st_blk : null
      };
  },
  watch : {
      donor(){
          if(this.donor){
            let {home,office} = this.donor;
            this.home_zip = home.zip;
            this.home_no_st_blk = home.no_st_blk;
            this.office_zip = office.zip;
            this.office_no_st_blk = office.no_st_blk;
        }
      }
  },
  computed : {
      homeAddressDefault(){
          if(this.donor != undefined){
              return this.donor.home;
          }else{
              return this.facilityAddress('Home ');
          }
      },
      officeAddressDefault(){
          if(this.donor != undefined){
              return this.donor.office;
          }else{
              return this.facilityAddress('Office ');
          }
      }
  },
  methods : {
    homeChanged({region,province,city,barangay}){
        this.home_region = region;
        this.home_prov = province;
        this.home_citymun = city;
        this.home_brgy = barangay;
        this.$emit("home",{region,province,city,barangay,zip : this.home_zip, no_st_blk : this.home_no_st_blk});
    },
    officeChanged({region,province,city,barangay}){
        this.office_region = region;
        this.office_prov = province;
        this.office_citymun = city;
        this.office_brgy = barangay;
        this.$emit("office",{region,province,city,barangay, zip : this.office_zip, no_st_blk : this.office_no_st_blk});
    },
    facilityAddress(prefix){
        let {address_region,address_prov,address_citymun,address_bgy} = this.$session.get('user').facility;
        return {
            region : address_region, province : address_prov, city : address_citymun, barangay : address_bgy, prefix
        };
    }
    
  }
}
</script>

