<style>
a.topup{ border:1px dotted #00a24f;padding:10px;margin-bottom:18px;color:#000;float:right;}
table.results{margin-top:25px;}

table.results td{background:#fff;}
table.results th a:hover{color:#fff!important;}
table.results tr{ border-bottom:1px dotted #ccc;}
.youcart{ background:#f7f7f7;color:#888888;padding:10px;text-align:center;margin-bottom:20px;}
.left_th{border:1px solid #f0f0f0;width:99.7%;float:left;margin-bottom:3px;}
.left_th span{float:left;padding:10px; font-size:15px;border-right:1px solid #f0f0f0;width:68%;}  
.left_th label{float:right;text-align:right;padding:10px;font-size:15px;}
.cart-payment{float:left;clear:both;width:100%;text-align:right;margin:16px 0px;}
.pod-div{ clear:both;margin:15px 0px;}
a.cartlink{ background:#ff9100;padding:10px 10px;color:#fff;  font-size:12px;text-transform:uppercase;font-weight:bold;margin-left:7px;
}
a.color1{background:#dddddd;color:#4a4a4a;border:1px solid #d2d2d2;}
a.color2{ }
a.color3{background:#282d33;border:1px solid #282d33;}
a:hover.cartlink{opacity:0.69;-moz-transition: all .25s ease;
	-o-transition: all .25s ease;
	transition: all .25s ease;}
</style>
<?php
#echo '<pre>';print_r($carts[0]);echo '</pre>'; exit;
   ?>






<div class="box clearfix">
<div class="top_heading">
<div class="doc_width">
<h1>My Cart</h1>
</div>


</div>
<div class="main_content">

<div class="main_content_middle">			

 <div class="fix_div2 table-responsive">
 <h1>Products in your cart</h1>
			 
			
				<?php
				 
					if(!empty($carts)){
				?>

				
                

				<table class="results results_cart" cellpadding="0" cellspacing="0" style="margin-bottom:0px;" width="100%">
				<tr>
					<th><?php echo $paginator->sort('Description');?></th>
                    <th>Quantity</th>
                    <th><?php __('Price');?></th>
                    <th><?php __('Total');?></th>
                    <th>Delete From Cart</th>
					 
				</tr>
				<?php
				$i = 0;
				foreach ($carts as $cart):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
					
                    
                    <?php
								$cart_products = mysql_query("SELECT cp.id,cp.oid,cp.quantity, p.title,p.buy_now
																			FROM cart_products cp 
																			LEFT JOIN products p ON cp.pid = p.id
																			 
																			WHERE cp.cid = '".$cart['Cart']['id']."' ");
																			
								while ($cart_product = mysql_fetch_array( $cart_products, MYSQL_ASSOC ) ){
										 
										$total += $cart_product['buy_now'] * $cart_product['quantity'] ;
										
										 
								?>
                                <tr<?php echo $class;?>>
						
                        
                        <td class="titlelink"><?php echo $cart_product['title']?></td>                        
                        <td>
						<form method="post">
							<input type="hidden" name="cart_product" value="<?php echo $cart_product['id']; ?>" />
							<select name="quantity" onchange="this.form.submit()"><?php for($i=1;$i<=10;$i++){ ?>
								<option <?php if($cart_product['quantity'] == $i){ ?> selected="selected" <?php } ?> value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php } ?></select>
						</form>
						</td>                        
                        <td><?php echo $number->currency($cart_product['buy_now']) ;?></td>                        
                        <td><?php echo $number->currency($cart_product['buy_now'] * $cart_product['quantity'])  ; ?></td>
                        <td>
							<a href="/carts/delete/<?php echo $cart_product['id'];?>"><img src="<?php echo $this->webroot; ?>img/bid_remov_icon.png" style="width:21px;height:22px;" width="21" height="22" border="0" alt="Remove item from Cart" title="Remove item from Cart" /></a>
						</td>                        
                        </tr>                        
                        <?php } ?>
        			<?php endforeach; ?>
					</table>


                
                <div class="cart-total-sum">
                	<?php if($discount > 0){?> 
                    <div class="left_th">
                        <span><?php __('Subtotal');?></span>
                        <label> <?php echo $number->currency( $total, $appConfigurations['currency'] ); ?></label>
                        <div class="clear"></div>
                    </div>
                    <?php }  ?>
                                
                
                
              
                
                <div class="left_th">
				<span><strong>Total</strong></span>
    			<label style="color:#000;"> <?php
					$total_to_pay =  $total - $discount  ;
					echo $number->currency( $total_to_pay , $appConfigurations['currency'] ); 
				mysql_query("UPDATE carts SET amount = '$total_to_pay' WHERE id = '".$cart['Cart']['id']."' ");
				?> </label>
				<div class="clear"></div>
				</div>   

				
                </div>
                
                <div class="cart-payment">
                
				
                <a href="/products" class="cartlink color2"> << Continue Shopping </a> 
                               
                <a href="/carts/checkout" class="cartlink  color3">Checkout >> </a>
				
                
				 
			
               
                </div>

				<?php }else{
				echo 'Your Cart is empty.';
				} ?>
			</div>
  
  
 
 
</div> 

</div>
</div>







 
 
 
 
      
            
            

	
<script>

function show_form(){
		$(".popup_dull").fadeIn('slow');
	  $('#g_checkout_form').show();
}

$( ".g_checkout" ).click(function() {  
 show_form();
});

<?php if($cart['Cart']['g_name'] == '' && $cart['Cart']['is_gift'] == 1){ ?>
	show_form();
<?php } ?>

</script>

