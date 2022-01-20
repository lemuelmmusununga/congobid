<?php
$html->addCrumb(__('Cart details for Store order', true), '/admin/auctions');
if(!empty($extraCrumb)) :
	$html->addCrumb($extraCrumb['title'], '/admin/storeorders/');
	$html->addCrumb($extraCrumb['title'], '/admin/storeorders/cart/'.$order['id']);
endif;
echo $this->element('admin/crumb');
?>

<div class="auctions index">
<?php 
	#echo '<pre>';print_r($order);echo '</pre>';  

$arr_prd = explode(',', $order['store_order_ids']);
$arr_prd_qty = explode(',', $order['quantity']);
if( !empty($arr_prd) ){
	foreach( $arr_prd as $key => $pid ){
		$prd_info = array();
		$prd_info    = mysql_fetch_array(mysql_query("SELECT p.title, s.quantity FROM storeorders s 
														LEFT JOIN products p ON s.product_id = p.id
														WHERE s.id = '".$pid."' "), MYSQL_ASSOC);
		echo '<br /><br /> Title: '.$prd_info['title'] ;
		echo '<br /> Quantity: '.$prd_info['quantity'] ; 
		
	}
	
	echo '<br /><br /> Shipping: '.$order['shipping'] ; 
	echo '<br /><br /> amount: '.$order['amount'] ; 
	echo '<br /><br /> Total: '.($order['amount']+$order['shipping']); 

}else{
	
	$prd_info    = mysql_fetch_array(mysql_query("SELECT * FROM products WHERE id = '".$order['product_id']."' "), MYSQL_ASSOC);
	echo '<br /> Title: '.$prd_info['title'] ;
	
}




 ?> 
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__(' << Back to Store Orders', true), array('controller' => 'storeorders', 'action' => 'index')); ?></li>
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		if($('#selectStatus').length){
			$('#selectStatus').change(function(){
				location.href = '/admin/auctions/won/' + $('#selectStatus').val();
			});
		}	});
</script>