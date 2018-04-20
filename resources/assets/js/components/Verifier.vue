<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Confirmatory Verification Check</h3>
            </div>
            <div class="panel-body">
                <form action="" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-4">
                            <i class="text-success" style="font-size:12px;">Please call a Verifier to enter his/her Access Details</i>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label col-lg-4">User Name</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control input-sm" placeholder="User Name">
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label col-lg-4">Password</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control input-sm" placeholder="Password">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
.control-label {
    margin-top:-.5em;
    font-size: 14px;
}
.form-group.required .control-label:after {
  content:"*";
  color:red;
}
.error {
    font-size:12px;
    margin-top:0.5em;
}
</style>