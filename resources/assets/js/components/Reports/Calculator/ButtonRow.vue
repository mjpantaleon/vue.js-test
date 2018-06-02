<template>
    <div class="row">
        <div class="col-lg-12">
            <my-button v-for="n in numbers" :key="n" :number="n" :screen="screen"></my-button>
        </div>
    </div>
</template>

<script>
import MyButton from './button.vue';
export default {
    props : ['numbers','screen'],
    components : {MyButton},
    data(){
        return {
            
        }
    }
}
</script>
