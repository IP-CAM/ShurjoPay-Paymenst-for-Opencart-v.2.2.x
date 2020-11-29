<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1><img src="http://www.shurjopay.com.bd/images/logo.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="pull-right">
                <button type="submit" form="form-skrill" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary" onclick="$('#form').submit();"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
            </div>
        <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="shurjopay_order_status_id" id="input-status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $shurjopay_order_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-secret"><?php echo $entry_username; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="shurjopay_username" value="<?php echo $shurjopay_username; ?>" placeholder="<?php echo $shurjopay_username; ?>" id="input-secret" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-secret"><?php echo $entry_password; ?></label>
                        <div class="col-sm-10">
                            <input type="password" name="shurjopay_password" value="<?php echo $shurjopay_password; ?>" placeholder="<?php echo $shurjopay_password; ?>" id="input-secret" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-secret"><?php echo $entry_uniq_transaction_key; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="shurjopay_uniq_transaction_key" value="<?php echo $shurjopay_uniq_transaction_key; ?>" placeholder="<?php echo $shurjopay_uniq_transaction_key; ?>" id="input-secret" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-secret"><?php echo $entry_paymentOption; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="shurjopay_paymentOption" value="dbbl_visa" id="input-secret" class="form-control" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-secret"><?php echo $entry_userIP; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="shurjopay_userIP" id="input-secret" class="form-control" value="<?php echo $shurjopay_userIP; ?>" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="shurjopay_status" id="input-status" class="form-control">
                                <?php if ($shurjopay_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>