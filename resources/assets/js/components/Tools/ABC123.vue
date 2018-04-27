<template>
  <div>
      <a href="#" class="abc" v-for="a in letters" :key="a" @click.prevent="clicked(a)">{{a}}</a>
  </div>
</template>

<script>
export default {
  data(){
      return {
          letters : ['#','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']
      }
  },
  methods : {
      clicked(a){
          this.$emit('hasClicked',a);
      }
  }
}
</script>

<style>
.abc{
    padding-left: 0.58em;
    padding-right: 0.58em;
}
</style>

