<form action="<?php echo $action; ?>" method="post">
    <input type="hidden" name="pay_to_username" value="<?php echo $pay_to_username; ?>" />
    <input type="hidden" name="pay_to_password" value="<?php echo $pay_to_password; ?>" />
    <input type="hidden" name="uniq_transaction_key" value="<?php echo $uniq_transaction_key; ?>" />
    <input type="hidden" name="userIP" value="<?php echo $userIP; ?>" />
    <input type="hidden" name="paymentOption" value="<?php echo $paymentOption; ?>" />
    <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="returnUrl" value="<?php echo $returnUrl; ?>" />
    <div class="buttons">
        <div class="pull-right">
            <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
        </div>
    </div>
</form>
