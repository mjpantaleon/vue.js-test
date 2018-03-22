<template>
  <div class="panel panel-default">
    <div class="panel-heading">
        <router-link :to="('/MBD/'+schedid+'/AddDonor')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-search"></span> Search Donor</router-link>
        <a href="#" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span> Update Donation Details</a>
    </div>
    <table class="table table-condensed table-bordered table-striped">
        <thead>
            <tr>
                <th colspan="3"></th>
                <th colspan="3" class="text-center">Donor Details</th>
                <th colspan="3" class="text-center">Donation Details</th>
            </tr>
            <tr>
                <th style="width:30px;">
                    <input type="checkbox" v-model="selectAll">
                </th>
                <th style="width:30px;"></th>
                <th style="width:30px;"></th>
                <th>Donor Name</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Donation ID</th>
                <th>MH/PE Result</th>
                <th>Collection Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="!donations.length && !loading">
                <td colspan="9" class="text-center">No Donors Yet</td>
            </tr>
            <tr v-if="loading">
                <td colspan="9" class="text-center"><rowloading label="Please wait, loading donors.."></rowloading></td>
            </tr>
            <tr v-if="donations && !loading" v-for="d in donations" :key="d.seqno" style="font-size:14px;">
                <td>
                    <input type="checkbox" :value="d.seqno" v-model="selected" v-if="!d.processing">
                </td>
                <td><button class="btn btn-danger btn-xs" v-if="!d.processing"><span class="glyphicon glyphicon-remove"></span></button></td>
                <td><button class="btn btn-info btn-xs" v-if="!d.donor"><span class="glyphicon glyphicon-user"></span></button></td>
                <td v-if="!d.donor" colspan="3"></td>
                <td v-if="d.donor">{{d.donor.fname}} {{d.donor.mname}} {{d.donor.lname}}</td>
                <td v-if="d.donor">{{d.donor.gender | gender}}</td>
                <td v-if="d.donor">{{d.donor.bdate}}</td>
                <td>{{d.donation_id}}</td>
                <td>{{d.mh_pe_stat | mhpe}}</td>
                <td>{{d.collection_stat | collection}}</td>
            </tr>
        </tbody>
    </table>
   </div>
</template>

<script>
import filters from './../../../filters';

export default {
  filters,
  props : ['schedid','donations','loading'],
  data(){
      return {
          selected : []
      }
  },
  computed: {
    selectAll: {
        get: function () {
            return this.donations ? this.selected.length == this.donations.length : false;
        },
        set: function (value) {
            var selected = [];

            if (value) {
                this.donations.forEach(function (donation) {
                    selected.push(donation.seqno);
                });
            }

            this.selected = selected;
        }
    }
  }
}
</script>

