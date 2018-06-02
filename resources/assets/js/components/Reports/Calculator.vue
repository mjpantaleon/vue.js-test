<template>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                My Calculator
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12"><input type="text" class="form-control" v-model="screen.value"></div>
                </div>

                <button-row :numbers=" ['7','8','9','*']" :screen="screen"></button-row>
                <button-row :numbers=" ['4','5','6','/']"></button-row>
                <button-row :numbers=" ['1','2','3','+']"></button-row>
                <button-row :numbers=" ['C','0','.','-']"></button-row>
            </div>
        </div>
    </div>
</template>
<script>

import ButtonRow from './Calculator/ButtonRow';

export default {
    components : {ButtonRow},
    data(){
        
        return {
            screen : {
                value : 0
            }
        }
    }
}
</script>