<?php
function verifyTransaction($data) {
    global $paypalUrl;

    $req = 'cmd=_notify-validate';
    foreach ($data as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
        $req .= "&$key=$value";
    }

    $ch = curl_init($paypalUrl);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    $res = curl_exec($ch);

    if (!$res) {
        $errno = curl_errno($ch);
        $errstr = curl_error($ch);
        curl_close($ch);
        throw new Exception("cURL error: [$errno] $errstr");
    }

    $info = curl_getinfo($ch);

    // Check the http response
    $httpCode = $info['http_code'];
    if ($httpCode != 200) {
        throw new Exception("PayPal responded with http code $httpCode");
    }

    curl_close($ch);

    return $res === 'VERIFIED';
}

function checkTxnid($txnid) {
    global $db;

    $txnid = $txnid;
    $results = $db->counts('SELECT * FROM `payments` WHERE transactionid = "' . $txnid . '"');

    return $results;
}

function addPayment($data) {
    global $db;

    if (is_array($data)) {
    
        $sql="INSERT INTO `payments` (user_id,transactionid, amount, type, payment_status,campaign_id) VALUES('".$data['user_id']."','".$data['txn_id']."','".$data['payment_amount']."','paypal','".$data['payment_status']."','".$data['item_number']."')";
        $result=$db->insert($sql);
        if($result){
            $q="UPDATE campaigns SET status='0' WHERE (id='".$data['item_number']."' OR campaign_group='".$data['item_number']."')";
            $db->query($q);
            return $result;
        }

        /*$stmt = $paydb->prepare('INSERT INTO `payments` (user_id,transactionid, amount, type, payment_status,campaign_id) VALUES(?, ?, ?, ?, ?, ?)');
        $stmt->bind_param(
            $data['user_id'],
            $data['txn_id'],
            $data['payment_amount'],
            'paypal',
            $data['payment_status'],
            $data['item_number']
        );
        $stmt->execute();
        $stmt->close();

        return $paydb->insert_id;*/
    }

    return false;
}
?>