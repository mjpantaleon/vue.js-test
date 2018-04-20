<template>
  <div>
        <div class="modal fade" id="mhpe_questionaire">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">MH/PE</h4>
                    </div>
                    <div class="modal-body">
                        <questions @onselect="hasSelected" :reuse="reuse"></questions>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="complete">Done</button>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
import Questions from './Questions.vue';
export default {
  props : ['reuse'],
  components : {Questions},
  data(){
      return {
          selections : {}
      };
  },
  methods : {
      hasSelected(selections){
          this.selections = selections;
      },
      complete(){
          this.$emit("oncomplete",this.selections);
          this.selections = {};
      }
  }
}
</script>

