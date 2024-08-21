<?php $this->layout('layouts/frontend', [
    'title' => 'Feedback',
    'alogin' => $alogin
]) ?>
<div class="row">
    <div class="col-md-12">
        <h2>Give us Feedback</h2>
        <div class="panel panel-default">
            <div class="panel-heading">Edit Info</div>
            <?= $this->insert('partials/alerts', ['msg' => $msg]) ?>
            <div class="panel-body">
                <form method="post" class="form-horizontal" enctype="multipart/form-data">

                    <div class="form-group">
                        <input type="hidden" name="user" value="<?php echo htmlentities($result->email); ?>">
                        <label class="col-sm-2 control-label">Title<span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <label class="col-sm-2 control-label">Attachment<span style="color:red"></span></label>
                        <div class="col-sm-4">
                            <input type="file" name="attachment" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description<span style="color:red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" name="description"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit">Send</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>