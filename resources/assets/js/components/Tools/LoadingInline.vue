<template>
  <div>
      <img :src="imgsrc" alt="loading" :width="width" height="15px" /> {{label}}
  </div>
</template>

<script>
export default {
  props : ['label'],
  data(){
    return {width:30};
  },
  computed: {
    imgsrc(){
      return './images/loading.gif';
    }
  }
}
</script>
