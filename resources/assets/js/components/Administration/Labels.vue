<template>
  <div>
      <div class="row" v-if="!create && !edit">
          <div class="col-lg-6">
              <table class="table table-condensed">
                  <thead>
                      <tr>
                          <th>Blood Label Templates</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-if="loading">
                          <td colspan="2" class="text-center"><loadingInline label="Loading templates.."></loadingInline></td>
                      </tr>
                      <tr v-if="!loading && templates.length" v-for="t in templates" :key="t.id">
                          <td>{{t.facility.facility_name}}</td>
                          <td>
                              <button @click="edit = t;" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>
                              <button @click="remove(t)" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                          </td>
                      </tr>
                      <tr v-if="!loading && !templates.length">
                          <td colspan="2" class="text-center">No Available Templates Yet</td>
                      </tr>
                  </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-success btn-sm" @click="create = true">Add New Template</button>
                            </td>
                        </tr>
                    </tfoot>
              </table>
          </div>
      </div>
      
      <div class="row" v-if="create">
          <div class="col-lg-12">
              <create @cancel="create = null;" @complete="create = null; fetchTemplates()"></create>
          </div>
      </div>

      <div class="row" v-if="edit">
          <div class="col-lg-12">
              <edit-template :edit="edit" @cancel="edit = null;" @complete="edit = null; fetchTemplates()"></edit-template>
          </div>
      </div>
  </div>
</template>

<script>
import Create from "./Labels/Create.vue";
import EditTemplate from "./Labels/Edit.vue";

export default {
  components : {Create,EditTemplate},
  data(){
      return {
          loading :false, templates : [], create : false, edit : null
      }
  },
  mounted(){
      this.fetchTemplates();
  },
  methods : {
      fetchTemplates(){
          this.loading = true;
            this.$http.get(this,"admin/templates")
            .then(({data}) => {
                this.templates = data;
                this.loading = false;
            })
      },
      remove(t){

      }
  }
}
</script>
