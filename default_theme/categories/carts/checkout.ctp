<script type="text/javascript" src="/js/validation.js"></script>
<style>
a.topup{ border:1px dotted #ff9100;padding:10px;margin-bottom:18px;color:#000;float:right;}
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
a.cartlink{ background:#ff9100;padding:10px 25px;color:#fff;  font-size:13px;text-transform:uppercase;font-weight:bold;margin-left:7px;
}
a.color1{background:#dddddd;color:#4a4a4a;border:1px solid #d2d2d2;}
a.color2{ }
a.color3{background:#ff9100;border:1px solid #ff9100;}
a:hover.cartlink{opacity:0.69;-moz-transition: all .25s ease;
	-o-transition: all .25s ease;
	transition: all .25s ease;}
</style>
 
 <div class="box clearfix">
<div class="top_heading">
<div class="doc_width">
<h1>Review Order.</h1>
</div>


</div>
<div class="main_content">

<div class="main_content_middle">			


 
  <div  class="fix_div2 table-responsive">
	<span class="order_info clear"> <h1>Review Order</h1> </span>
		
		<div id="order_info"  
		style="
		<?php #if($this->params['pass'][0] == 3){ echo 'display:block;'; }else { echo 'display:none;'; } ?>">
		
			<table class="results results_cart" cellpadding="0" cellspacing="0" style="margin-bottom:0px;" width="100%">
				<tr>
					<th>Description</th>
                    <th>Quantity</th>
                    <th><?php __('Price');?></th>
                    <th><?php __('Total');?></th>
                    
					 
				</tr>
				<?php $cart_products = mysql_query("SELECT cp.id,cp.oid,cp.quantity, p.title,p.rrp, p.buy_now 
																			FROM cart_products cp 
																			LEFT JOIN products p ON cp.pid = p.id
																			
																			WHERE cp.cid = '".$carts['Cart']['id']."' ");
																			
								while ($cart_product = mysql_fetch_array( $cart_products, MYSQL_ASSOC ) ){
										
										$total += $cart_product['buy_now'] * $cart_product['quantity'] ;
										
										 
								?>
                                <tr<?php echo $class;?>>
						
                        
                        <td class="titlelink"><?php echo $cart_product['title']?></td>                        
                        <td><?php echo $cart_product['quantity'] ;?></td>     
						                      
                        <td><?php echo $number->currency($cart_product['buy_now']) ;?></td>                        
                        <td><?php echo $number->currency($cart_product['buy_now'] * $cart_product['quantity'])  ; ?></td>
                                          
                        </tr>                        
                        <?php } ?>
        			
					</table>
                
					 
					<div class="left_th">
						<span><strong>Total</strong></span>
						<label style="color:#000;"> <?php 
						$total_to_pay =  $total - ( $discount + $bonus_bunks_balance) ;
						echo $number->currency( $total_to_pay , $appConfigurations['currency'] ); 
						
						?> </label>
						<div class="clear"></div>
					</div> 
					
					
					<div class="cart-payment">					
					 
						 
				<a href="/payment_gateways/bank/store/<?php echo $carts['Cart']['id'] ?>" class="cartlink  color3"> Pay using Credit Card >>  </a>
                
               
					 
					</div>
					

			
		</div>
 </div>    
 


</div> 

</div>
</div>

 
 
 
 
 
  
 
 
     
 
 
 
 
 
 
      
            
            

	
<script>
$( ".auth_info" ).click(function() {
  $('#auth_info').toggle('slow');
});
$( ".user_info" ).click(function() {
  $('#user_info').toggle('slow');
});
$( ".payment_info" ).click(function() {
  $('#payment_info').toggle('slow');
});
$( ".order_info" ).click(function() {
  $('#order_info').toggle('slow');
});

function auth_next(){
	var val = $('input:radio[name=checkout_user_option]:checked').val();
	if(val){
		if(val == 2){ 
			$('#pass_block').show();
			$('#pass_block input').attr( "required", "required" );
		}
		if(val == 1){ 
			$('#pass_block').hide();
			$('#pass_block input').removeAttr("required");
		}
		$('#create_account').val(val);
		$('#auth_info').hide('slow');
		$('#user_info').show('slow');
	}else{
		alert('Please choose guest option'); return false ;
	}
}

</script>
<script type="text/javascript">
$('#same_as_billing').click(function() {
	if ($(this).is(':checked')) {   
		$('.shipping_address').hide() ;   
		$('.shipping_address input').removeAttr("required");
	}else{
		 
		$('.shipping_address').show() ;   
		$('.shipping_address input').attr( "required", "required" );
		
	}
 });
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.radio-group input').click(function(){
			if($(this).attr('title')){
				if($(this).attr('title') == 1){
					$('#sourceExtraBlock').show(1);
				}else{
					$('#sourceExtraBlock').hide(1);
					$('#sourceExtra').val('');
				}
			}
		});

		if($('.radio-group input:checked').attr('title') == 1){
			$('#sourceExtraBlock').show(1);
		}
	});
	<?php if( $this->params['pass'][0] == 2 ){ ?>
		$(".login_register").attr('checked', true);
		auth_next();
	<?php } ?>
</script>