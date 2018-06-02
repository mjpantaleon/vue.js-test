<template>
    <button class="btn" @click="setScreenValue">{{number}}</button>
</template>

<script>
export default {
    props : ['number','screen'],
    data(){
        return {
            xscreen : this.screen
        }
    },
    methods : {
        setScreenValue(){
            switch(this.number){
                case '*':
                    
                break;
                case '/':

                break;
                case '+':

                break;
                case '-':

                break;
                case 'C':

                break;
                case '.':

                break;
                default:
                    if(this.xscreen.value == 0){
                        this.xscreen.value = this.number;
                    }else{
                        this.xscreen.value = this.screen.value + this.number;
                    }

            }
        }
    }
}
</script>
