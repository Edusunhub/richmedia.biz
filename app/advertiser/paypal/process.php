<?php
require '../../config.php';
require '../session.php';

if(!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && $_GET['type']=='wallet'){
    $paymentID = $_GET['paymentID'];
    $payerID = $_GET['payerID'];
    $token = $_GET['token'];
    $type = $_GET['type'];
    $amount = $_GET['amount'];

    $sql="INSERT INTO `payments` (user_id,transactionid, amount, type, payment_status,method) VALUES('".$_SESSION['userid']."','".$paymentID."','".$amount."','wallet','1','paypal')";
    
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
            <p>Name Of Mode:paypal</p>
            <p>Name Of Type:Wallet Recharge</p>
            <p>Amount:$'.$amt.'</p>';
            $cc=$mmail['email'];
            sendmail($amail['email'],'New Payment Made By Advertiser',$message,$cc);
        redirect(baseurl.'/advertiser/payment-successful.php');
    }

}elseif(!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['id']) ){
    $paymentID = $_GET['paymentID'];
    $payerID = $_GET['payerID'];
    $token = $_GET['token'];
    $id = $_GET['id'];
    $type = $_GET['type'];
    $amount = $_GET['amount'];
    $sql="INSERT INTO `payments` (user_id,transactionid, amount, type, payment_status,campaign_id) VALUES('".$_SESSION['userid']."','".$paymentID."','".$amount."','paypal','1','".$id."')";
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
            $amt=$amount*5.37/100;
            $total_budget=$amt+$amount;
            $tid=$paymentID;
            $camp=$camname['name'];
            $message='<p>Hi,</p>
            <p>Name Of Advertiser:'.$name.'</p>
            <p>Campaign Name:'.$camp.'</p>
            <p>Transaction ID:'.$tid.';</p>
            <p>Name Of Mode:paypal</p>
            <p>Amount:$'.$total_budget.'</p>';
            $cc=$mmail['email'];
            sendmail($amail['email'],'New Payment Made By Advertiser',$message,$cc);
        redirect(baseurl.'/advertiser/payment-successful.php');
    }
}else{
    redirect(baseurl.'/advertiser/payment-cancelled.php');
}
?>