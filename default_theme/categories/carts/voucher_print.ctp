<div class="heading_outer"><div class="fix_div"><h1><?php __('My orders');?></h1></div></div>
 <div class="fix_div">
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
				 <?php
				$html->addCrumb(__('Print Vouchers', true), '/carts/voucher_print/'.$order['Cart']['id']);
				echo $this->element('crumb_user');
				?>
				<p>Hieronder een overzicht van producten van uw bestelling met ordernummer # <?php  echo $order['Cart']['id'] ?> </p>
                
      			 <table class="results results_cart" cellpadding="0" cellspacing="0" style="margin-bottom:0px;" width="100%">
                <tr>
					<th><?php __('Title');?></th>
                    <th><?php __('Aantal');?></th>
                    <th><?php __('Price');?></th>
                    <th><?php __('Totaal');?></th>                    
                    <th><?php __('Voucher');?></th>
					 
				</tr>
                
				 <?php foreach($order['CartProduct'] as $prd){ 
						if($prd['prd_title'] == ''){
							$prd_ttl = mysql_fetch_array(mysql_query("SELECT title FROM products WHERE  id = '".$prd['pid']."' "), MYSQL_ASSOC);
							mysql_query("UPDATE cart_products SET prd_title = '".$prd_ttl['title']."' where id = '".$prd['id']."'");
							$prd['prd_title'] = $prd_ttl['title'];
						}
				 ?>                 
				     
                 <tr>
                 <td><?php echo $prd['prd_title'] ?></td> 
                 <td><?php echo $prd['quantity'] ?></td>
				 <td><?php echo $prd['amount'] ?></td>  
				 <td><?php echo $number->currency( ($prd['quantity']*$prd['amount']), $appConfigurations['currency']); ?></td>                                                                   
				 <td><a target="_blank" href="/carts/email_voucher/<?php echo $prd['id']; ?>">Print<img style="width:12px;margin-left:6px;" src="/img/printicon.png" /></a></td>		
						
						
					
                        
                </tr>        
				<?php }?>
                
                </table>
                
                
                
                
                </div>
				 
			</div>

</div>
