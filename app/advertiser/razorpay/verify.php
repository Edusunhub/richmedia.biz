<?php
require_once('../../config.php');
require_once('../session.php');

$keyId=keyId;
$keySecret=keySecret;

print_r($_POST);

require(ABSPATH.'payment-gateways/razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";

    print_r($_POST);

    $type = $_POST['type'];
    if($type==1){
        //Wallet Recharge
        $paymentID = $_POST['razorpay_payment_id'];
        $id = $_POST['user_id'];
        $amount = $_POST['amount'];
        $sql="INSERT INTO `payments` (user_id,transactionid, amount, type, payment_status,method) VALUES('".$_SESSION['userid']."','".$paymentID."','".$amount."','Wallet','1','razorpay')";
        $result=$db->insert($sql);
        if($result){
                $sql="SELECT * FROM users WHERE id='".$_SESSION['userid']."' AND deleted_at is NULL";
                $manage=$db->get_row($sql);
                $mail="SELECT * FROM users WHERE id='".$manage['managerid']."'  AND deleted_at is NULL";
                $mmail=$db->get_row($mail);
                $admin="SELECT * FROM users WHERE type=10 AND deleted_at is NULL";
                $amail=$db->get_row($admin);
                $name=$manage['name'];
                $amt=$amount;
                $tid=$paymentID;
                $message='<p>Hi,</p>
                <p>Name Of Advertiser:'.$name.'</p>
                <p>Transaction ID:'.$tid.';</p>
                <p>Name Of Mode:Razorpay</p>
                <p>Name Of Type:Wallet Recharge</p>
                <p>Amount:$'.$amt.'</p>';
                $cc=$mmail['email'];
                sendmail($amail['email'],'New Payment Made By Advertiser',$message,$cc);
            redirect(baseurl.'/advertiser/payment-successful.php');
        }
    }
    if($type==2){
        //campaign
        $paymentID = $_POST['razorpay_payment_id'];
        $id = $_POST['id'];
        $amount = $_POST['amount'];

        $sql="INSERT INTO `payments` (user_id,transactionid, amount, type, payment_status,campaign_id) VALUES('".$_SESSION['userid']."','".$paymentID."','".$amount."','razorpay','1','".$id."')";
        
        $result=$db->insert($sql);
        if($result){
            $q="UPDATE campaigns SET status='1' WHERE (id='".$id."' OR campaign_group='".$id."')";
            $db->query($q);
                $camp="SELECT * FROM campaigns WHERE id='".$id."' AND deleted_at is NULL";
                $camname=$db->get_row($camp);
                $sql="SELECT * FROM users WHERE id='".$_SESSION['userid']."' AND deleted_at is NULL";
                $manage=$db->get_row($sql);
                $mail="SELECT * FROM users WHERE id='".$manage['managerid']."'  AND deleted_at is NULL";
                $mmail=$db->get_row($mail);
                $admin="SELECT * FROM users WHERE type=10 AND deleted_at is NULL";
                $amail=$db->get_row($admin);
                $name=$manage['name'];
                $amt=$amount*2.8/100;
                $total_budget=$amt+$amount;
                $tid=$paymentID;
                $camp=$camname['name'];
                $message='<p>Hi,</p>
                <p>Name Of Advertiser:'.$name.'</p>
                <p>Campaign Name:'.$camp.'</p>
                <p>Transaction ID:'.$tid.';</p>
                <p>Name Of Mode:Razorpay</p>
                <p>Amount:$'.$total_budget.'</p>';
                $cc=$mmail['email'];
                sendmail($amail['email'],'New Payment Made By Advertiser',$message,$cc);
            redirect(baseurl.'/advertiser/payment-successful.php');
        }
    }

}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}

echo $html;
