import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/Home.vue';
import ChangePassword from './components/Home/ChangePassword.vue';
import AgencyManger from './components/Agency/Manager.vue';
import AgencyInfo from './components/Agency/Info.vue';
import AgencyCreate from './components/Agency/Create.vue';
import AgencyEdit from './components/Agency/Edit.vue';

import MBD from './components/MBD/List.vue';
import MBDManager from './components/MBD/Manager.vue';
import MBDCreate from './components/MBD/Create.vue';
import MBDAddDonor from './components/MBD/SelectDonor.vue';
import MBDNewDonor from './components/Donor/selector/Create.vue';
import MBDUpdateDonor from './components/Donor/selector/Update.vue';
import MBDDonorInfo from './components/Donor/selector/Info.vue';

import DonorVerifier from './components/Donor/Verifier.vue';
import DonorProfile from './components/Donor/Info.vue';
import DonorUpdate from './components/Donor/Update.vue';
import DonorCreate from './components/Donor/Create.vue';

import WalkinCreate from './components/Walk-in/Create.vue';
import Walkin from './components/Walk-in/List.vue';

Vue.use(VueRouter);

export default new VueRouter({
    routes : [
        { path : '/', component : Home },
        { path : '/ChangePassword', component : ChangePassword },

        { path : '/Agency', component : AgencyManger },
        { path : '/Agency/create', component : AgencyCreate },
        { path : '/Agency/:agency_cd', component : AgencyInfo ,  props : true },
        { path : '/Agency/update/:agency_cd', component : AgencyEdit ,  props : true },

        { path : '/MBD', component : MBD },
        { path : '/MBD/create', component : MBDCreate },
        { path : '/MBD/:sched_id', component : MBDManager, props : true },
        { path : '/MBD/:sched_id/SearchDonor', component : MBDAddDonor, props : true },
        { path : '/MBD/:sched_id/:donation_id/SearchDonor', component : MBDAddDonor, props : true },
        { path : '/MBD/:sched_id/donor/create', component : MBDNewDonor, props : true },
        { path : '/MBD/:sched_id/donor/:seqno/update', component : MBDUpdateDonor, props : true },
        { path : '/MBD/:sched_id/donor/:seqno', component : MBDDonorInfo, props : true },
        { path : '/MBD/:sched_id/AddDonor/:donation_id/donor/:seqno', component : MBDDonorInfo, props : true },

        { path : '/Verifier', component : DonorVerifier },
        { path : '/donor/create', component : DonorCreate },
        { path : '/donor/:seqno', component : DonorProfile, props : true },
        { path : '/donor/:seqno/update', component : DonorUpdate, props : true },
        
        { path : '/donor/:seqno/donate', component : WalkinCreate, props : true },
        { path : '/Walkin', component : Walkin },
    ]
})