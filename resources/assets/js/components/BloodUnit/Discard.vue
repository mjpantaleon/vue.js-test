<template>
  <div>
      <list @hasSelected="setSelections" :refresh="refresh"></list>
      <select-reason :units="selections" @done="refresh++;"></select-reason>
  </div>
</template>

<script>
import List from './Discard/List.vue';
import SelectReason from './Discard/SelectReason.vue';

export default {
    components : {List,SelectReason},
    data(){
        return {
            selections : [],refresh : 0
        }
    },
    methods : {
        setSelections(selected){
            this.selections = selected;
            $("#SelectDiscardReason").modal("show");
        }
    }
}
</script>
