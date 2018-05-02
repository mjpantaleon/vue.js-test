<template>
  <div>
      <list v-show="!editing" @hasSelected="setSelections" :updated="refresh"></list>
      <editing v-if="editing" :donationids="selections" @cancel="selections = []; editing = false; refresh++;"></editing>
  </div>
</template>

<script>
import List from './Testing/List.vue';
import Editing from './Testing/Editing.vue';

export default {
    components : {List,Editing},
    data(){
        return {
            selections : [], editing : false, refresh : 0
        }
    },
    methods : {
        setSelections(selected){
            this.selections = selected;
            this.editing = true;
        }
    }
}
</script>
