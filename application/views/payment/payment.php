<!DOCTYPE html>
<html>
    <head>
        <title>Pay by Visa</title>
    </head>
    <body>
        <form action="https://e-commerce.cartubank.ge/servlet/Process3DSServlet/3dsproxy_init.jsp" method="POST" >
            <input type="hidden" name="PurchaseDesc" value="<?= $transId ?>" />
            <input type="hidden" name="PurchaseAmt" value="<?= $amount ?>" />
            <input name="CountryCode" type="hidden" value="268" />
            <input name="CurrencyCode" type="hidden" value="981" />
            <input name="MerchantName" type="hidden" value="Bids!bids.ge" />
            <input name="MerchantURL" type="hidden" value="http://bids.ge/" />
            <input name="MerchantCity" type="hidden" value="Tbilisi" />
            <input name="MerchantID" type="hidden" value="000000008000123-00000001" />
            <input name="xDDDSProxy.Language" type="hidden" value="01" />
            <input type="submit" value="Finalize payment" />
        </form>
    </body>
</html>

<?php

/*
<input type="hidden" name="merchant" value="<?= $merchant ?>" />
            <input type="hidden" name="ordercode" value="<?= $orderCode ?>" />
            <input type="hidden" name="amount" value="<?= $amount ?>" />
            <input type="hidden" name="currency" value="GEL" />
            <input type="hidden" name="description" value="<?= $description ?>" />
            <input type="hidden" name="clientname" value="<?= $clientname ?>" />
            <input type="hidden" name="lng" value="<?= $lng ?>" />
            <?php if( isset($testMode) ): ?>
                <input type="hidden" name="testmode" value="1" />
                <input type="hidden" name="successurl" value="bids.ge" />
                <input type="hidden" name="errorurl" value="bids.ge" />
                <input type="hidden" name="cancelurl" value="bids.ge" />
                <input type="hidden" name="callbackurl" value="https://bids.ge/payments/paycallback/" />
            <?php endif; ?>
            <input type="hidden" name="check" value="<?= $check ?>" />
            <input  type="submit" value="submit" />
*/