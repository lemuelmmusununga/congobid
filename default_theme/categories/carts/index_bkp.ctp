<div class="heading_outer"><div class="fix_div"><h1><?php __('Cart');?></h1></div></div>
 <div class="fix_div">
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
				




<div style="padding-top:18px; margin-bottom:5px; border-bottom:0px dotted #ccc; font-weight:bold; text-align:left;">
					<?php
					$cash_balance = mysql_fetch_array(mysql_query("SELECT cash_balance FROM users WHERE id = '".$session->read('Auth.User.id')."' "), MYSQL_ASSOC);
			
					echo sprintf(__('You currently have %s in your wallet.', true), '<span class="bid-balance"><strong>'. $number->currency($cash_balance['cash_balance'], $appConfigurations['currency']).'</strong></span>');?>
                    <span style="font-weight:bold; text-transform:capitalize; padding-left:15px;"><a class="topup" href="/credits">top-up your wallet</a></span>
        </div>
<!--insert cart here-->
<?php if(!empty($orders)): ?>
<?php //echo $this->element('pagination'); ?>
<table class="results" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<th><?php echo $paginator->sort('ID', 'title');?></th>
							<th><?php echo $paginator->sort('Description');?></th>
							<th><?php echo $paginator->sort('Qty', 'Status.name');?></th>
                            <th><?php __('Price');?></th>
							<th><?php echo $paginator->sort('Total', 'created');?></th>
							<th nowrap="nowrap"><?php __('Options');?></th>
						</tr>
					<?php
					$i = 0;
					foreach ($orders as $order): 
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
						$this_row_total = $order['Storeorder']['amount'] * $order['Storeorder']['quantity']  ;
						$final_total = $final_total + $this_row_total ;
						$final_shpping = $final_shpping + $order['Storeorder']['shipping'] ; 
						$store_order_id[] = $order['Storeorder']['id'] ;
						$product_ids[] = $order['Storeorder']['product_id'] ;
					?>
						<tr<?php echo $class;?>>
							<td align="left"> 
								<?php echo $order['Storeorder']['id']; ?>
							</td>
							<td>
								<?php echo $html->link($order['Product']['title'], array('controller' => 'products', 'action' => 'view', $order['Product']['id'])); ?>  <br />
								<?php if($order['Storeorder']['color'] != ''): ?>
                                Product Color  : <span style="font-weight:bold;">
                                <span style="color:#f60;"> <?php echo $order['Storeorder']['color'];?></span></span>
                                </span>
                                <?php endif; ?><br />
                                <?php if($order['Storeorder']['size'] != ''): ?>
                                Product Size  :<span style="font-weight:bold;">
                                  <span style="color:#f60;"> <?php echo $order['Storeorder']['size'];?></span> </span>
                                </span>
                                <?php endif; ?>
							</td>
							<td>
								<form action="/storeorders"  name="form"  id="myForm<?php echo $order['Storeorder']['id']; ?>"  method="POST" onchange="document.getElementById('myForm<?php echo $order['Storeorder']['id']; ?>').submit();" >
									<select style="padding:5px 7px; border:1px solid #ccc; font-size:14px; background:#eee; color:#666;" name="quantity">
									   <?php for($i=1;$i <=5; $i++){?>
											<option value="<?php echo $i; ?>" <?php if($i == $order['Storeorder']['quantity']){ echo 'selected="selected"';} ?>><?php echo $i; ?></option>
									   <?php } ?>
									   <input type="hidden" name="id" value="<?php echo $order['Storeorder']['id']; ?>">
									</select>
                                </form>
							</td>
                            <td>
								<?php echo  $number->currency($order['Storeorder']['amount'], $appConfigurations['currency']) ; ?>
							</td>
                            <td>
								<?php echo  $number->currency( $this_row_total , $appConfigurations['currency']) ; ?>
							</td>
							<td nowrap="nowrap" valign="middle">
								<?php //if($order['Status']['id'] == 1) : ?>
									<?php //echo $html->link(__('Pay', true), array('action' => 'pay', $order['Storeorder']['id'])); ?>
								<?php //endif; ?>
                               <!-- |-->                               
                               <a href="/storeorders/delete/<?php echo $order['Storeorder']['id']; ?>"><img src="<?php echo $this->webroot; ?>img/bid_remov_icon.png" width="21" height="22" border="0" alt="Remove item from Cart" title="Remove item from Cart" /></a>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
<!--cart summary starts-->
<div class="youcart">Your cart contents are stored here for 30+ days so you can return anytime.</div>
<div class="cart-total-sum">
<!--sub total-->
<div class="left_th">
	<span>Sub-total</span>
    <label>
    	<?php echo $number->currency(	  $final_total , $appConfigurations['currency']);
		
		$str = implode(",",$product_ids);
		$strP = implode(",",$store_order_id);
		mysql_query("DELETE FROM carts WHERE unpaid = 0 AND user_id = '".$session->read('Auth.User.id')."'  ") or die(mysql_error());
		
		
	
		mysql_query("INSERT INTO carts SET user_id = '".$session->read('Auth.User.id')."',
										   unpaid = '0',
										   product_id = '".$str."',
										   store_order_ids = '".$strP."',
										   amount = '". $final_total ."',
										   created = '".date('Y-m-d H:i:s')."' 
											")  ; 
											 
		$id = mysql_insert_id() ;
		
						
		$user_city = mysql_fetch_array(mysql_query("SELECT city_id FROM users WHERE id = '".$session->read('Auth.User.id')."'"), MYSQL_ASSOC);
		if($user_city['city_id'] == 22 && $final_total > 5000){
			$shipping_fee = 0;
		}
		else if($user_city['city_id'] == 22 && $final_total < 5000){
			$shipping_fee = 500;
		}
		else if($user_city['city_id'] != 22 && $final_total > 5000){
			$shipping_fee = 500;
		}
		else if($user_city['city_id'] != 22 && $final_total < 5000){
			$shipping_fee = 1500;
		}
		mysql_query("UPDATE storeorders SET shipping = '".$shipping_fee."', cart_id = '$id' WHERE id IN ($strP) ") or die(mysql_error());
		$update_shipping_price = mysql_query( "update carts SET shipping = '".$shipping_fee."' WHERE id = '".$id."'  " ) ;
		?>
    </label>
<div class="clear"></div>
</div>
<!--sub total ends-->	
<!--shipping-->
<div class="left_th">
<span>Shipping</span>
    <label>
    	<?php 
		echo $number->currency($shipping_fee, $appConfigurations['currency']); 
		?>
    </label>
<div class="clear"></div>
</div>
<!--final total-->
<div class="left_th">
	<span><strong>Order-total</strong></span>
    <label style="color:#000;">
    	<?php 
						echo $number->currency($shipping_fee  + $final_total , $appConfigurations['currency']);
						
							 						 
						?>
    </label>
<div class="clear"></div>
</div>
</div>
<?php $shipping_add = mysql_fetch_array(mysql_query("SELECT user_address_type_id FROM addresses WHERE user_id = '".$session->read('Auth.User.id')."'"), MYSQL_ASSOC);
                     ?>
<?php if(!empty($shipping_add)) : ?>
<!--cart payment-->
<div class="cart-payment">
  <input style="float:left;" id="_1" type="checkbox">
  <label style="text-align:left;float:left;"  class="collapse" for="_1"><span class="pod-button"> &nbsp;Pay On Delivery</span></label>                        
                        
                       <a class="cartlink color1" href="/products">continue shopping</a>                        
                       <a class="cartlink color2" href="/payment_gateways/webpay/store/<?php echo $id; ?>">Pay with Card</a>
                       <a class="cartlink color3" href="/payment_gateways/cash_pay/store/<?php echo $id; ?>">Pay from Wallet</a>			
                        
                    <div class="pod-div">
                   
                           
                        <div style="padding:10px 0;clear:both;display:none;">
                            <div style="border:1px dotted #00a24f;text-align:left; background:#fff; margin-bottom:10px; padding:10px; color:#f00;">Pay on delivery only available in Lagos!</div>
                            <?php $user_city = mysql_fetch_array(mysql_query("SELECT city_id FROM users WHERE id = '".$session->read('Auth.User.id')."'"), MYSQL_ASSOC);
                      if($user_city['city_id'] == 22) : ?>
                            Pay when we deliver to you. Please note that there is an additional charge of ₦500 for pay on delivery.
                            <?php $pod_fee = "500";?>
                            
                            <div style="margin:10px 0 15px 0;">Total : ₦500 (POD Fee) + <?php echo $number->currency($final_total , $appConfigurations['currency']);?> = <span style="font-weight:bold; font-size:18px; color:#000;"><?php echo $number->currency($pod_fee  + $final_total , $appConfigurations['currency']);?></span></div>
                            <!--insert form-->
                            <div class="form-style" id="contact_form">
                        <div class="form-style-heading">Enter Shipping Details</div>
                        <div id="contact_results"></div>
                        <div id="contact_body">
                            <label><span>Full Name <span class="required">*</span></span>
                                <input type="text" name="name" id="name" required="true" class="input-field"/>
                            </label>
                            <label><span>Phone</span>
                                <input type="text" name="phone1" maxlength="4" placeholder="+234"  required="true" class="tel-number-field"/>&mdash;<input type="text" name="phone2" maxlength="15"  required="true" class="tel-number-field long" /><br /><br />
                            <label for="field5"><span>Address <span class="required">*</span></span>
                                <textarea name="message" id="message" class="textarea-field" required="true"></textarea>
                            </label>
                            <label>
                                <span>&nbsp;</span><input type="submit" id="submit_btn" value="Submit" />
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                            </div>
                  
                    </div>
                    <!--pod-->
                    <div class="clear"></div>
                    </div>
<!--cart summary ends-->
<?php //endif; ?>
<?php else: ?>
<div style="padding:10px 20px; margin:15px 0; background:#FF9; color:#000; font-weight:bold; font-size:18px;">
                    <?php echo ('Alert!!! -  Missing address. Click <a href="/addresses/add/Shipping">here</a> to add shipping before check out.'); ?> 
                    </div>
<?php endif; ?>
<?php else:?>
<p>
 <div class="empty-cart-message">
                          <h2 class="empty-title font-century">Hmmm! Your cart is empty</h2>
                          <div class="empty-suggest">
                            <p style="font-size:18px;">Looking for something? Save up to 90% on your favorite products and services.</p>
                            <h1 class="font-century">Find some cool discounts to get you started...</h1>
                            <a href="/products" class="continue-shop-button">Return to Store</a>
                            </div>
                        </div>
</p>
<?php endif;?>

				
			</div>

</div>
