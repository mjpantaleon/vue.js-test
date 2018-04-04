<template>


    <b-alert 
    :show="dismissCountDown"
    dismissible
    @dismissed="dismissCountDown=0"
    @dismiss-count-down="countDownChanged" 
    :variant="$store.state.msg.type" 
    v-if="hasMsg"
    >
    {{$store.state.msg.content}}
    </b-alert>
</template>

<script>

import bAlert from 'bootstrap-vue/es/components/alert/alert';
export default {
  components : {bAlert},
  data(){
    return {
      dismissCountDown: 5,
      showDismissibleAlert: false
    }
  },
  watched : {
    dismissCountDown(){
      console.log('asd');
      if(this.dismissCountDown == 0){
        alert('asd');
        this.$store.state.msg = null;
        this.dismissCountDown = 5;
        this.showDismissibleAlert= true;
      }
    }
  },
  computed : {
    hasMsg(){
      return this.$store.state.msg != null;
    }
  },
  methods: {
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    }
  }
}
</script>
