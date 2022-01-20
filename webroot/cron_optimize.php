<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 
require_once '../config/config.php';
 
 
// Setup the timezone
if(!empty($config['App']['timezone'])){
	putenv("TZ=".$config['App']['timezone']);
}

 

 
require_once '../database.php';
 
$auc = mysqli_query($db,"SELECT id FROM auctions  where closed = 1 AND optimized = 0  ");
while($res_auc = mysqli_fetch_array($auc,MYSQLI_ASSOC) ){ 
    $id = $res_auc['id'];

    $sql_bids10 = "SELECT id FROM bids where auction_id = $id ORDER BY ID DESC LIMIT 10,1 ";
    $bids_10_run = mysqli_query($db,$sql_bids10);
    $bids_10_id = mysqli_fetch_array($bids_10_run,MYSQLI_ASSOC) ;
    $sql_10_del = "DELETE FROM bids where id < '".$bids_10_id['id']."' AND auction_id = $id ";
    echo '<br /><br /> AID:'. $id;
    echo '<br /> bid ID:'. $bids_10_id['id'];
    $bids_10_run1  = mysqli_query($db,$sql_10_del);
    mysqli_query($db,"UPDATE auctions SET optimized = 1 WHERE id = '$id' ");
 }

 //exit('<br /><br /> end : ');
 
 

//$date5min = date('Y-m-d H:i:s', strtotime('-5 minutes'));

//mysqli_query($db,"DELETE FROM auction_block WHERE created <  '".time()."'  "); 
//mysqli_query($db,"DELETE FROM user_unblock WHERE created <  '".time()."'  "); 

$date60_sec = date('Y-m-d H:i:s', strtotime('-1 minute'));
mysqli_query($db,"DELETE FROM last5bidders WHERE created <  '".$date60_sec."'  "); 
mysqli_query($db,"DELETE FROM last5bids WHERE created <  '".$date60_sec."'  ");

$real_can_win = 0;
$last_auc = mysqli_fetch_array(mysqli_query($db,"SELECT id,end_time FROM auctions where closed = 1 ORDER BY end_time DESC "), MYSQLI_ASSOC);
$current_money = mysqli_fetch_array(mysqli_query($db,"SELECT SUM(price) as total FROM accounts where a.soon_undate = 0 AND  created  > '".$last_auc['end_time']."' "), MYSQLI_ASSOC);

$live_auction_cost = mysqli_query($db," SELECT a.id, p.rrp FROM auctions a  LEFT JOIN products p ON a.product_id = p.id where closed = 0 AND a.end_time > '".date('Y-m-d H:i:s')."'   " );
 
while($res = mysqli_fetch_array($live_auction_cost,MYSQLI_ASSOC) ){
  $id = $res['id'];
  $price = $res['rrp'];
  $total_price +=  $price;
 }
 
if($current_money['total'] >  $total_price ){
	mysqli_query($db,"UPDATE settings SET real_can_win = 1  WHERE id  = 27  ");
}else{
	mysqli_query($db,"UPDATE settings SET real_can_win = 0  WHERE id  = 27  ");
}

 



?>
 
