<div style="height:50px;">&nbsp;</div>
<div style="text-align:center;">
<form method="post" name="frmDalpay" action="https://secure.dalpay.is/cgi-bin/order2/processorder1.pl">
				<input type="hidden" name="mer_id" value="<?php echo htmlentities($dalpaycheckoutData['merchant'], ENT_COMPAT, "UTF-8");?>" />										
				<input type="hidden" name="pageid" value="<?php echo htmlentities($dalpaycheckoutData['pageid'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="pay_type" value="<?php echo htmlentities($dalpaycheckoutData['paytype'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="next_phase" value="paydata" />
				<input type="hidden" name="valuta_code" value="<?php echo htmlentities($dalpaycheckoutData['currency'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="langcode" value="<?php echo htmlentities($dalpaycheckoutData['lang'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_name" value="<?php echo htmlentities($dalpaycheckoutData['first_name'].' ' .$dalpaycheckoutData['last_name'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_company" value="<?php echo htmlentities($dalpaycheckoutData['company_name'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_phone" value="<?php echo htmlentities($dalpaycheckoutData['phone'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_email" value="<?php echo htmlentities($dalpaycheckoutData['email'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_address1" value="<?php echo htmlentities($dalpaycheckoutData['address1'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_address2" value="<?php echo htmlentities($dalpaycheckoutData['address2'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_city" value="<?php echo htmlentities($dalpaycheckoutData['city'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_state" value="<?php echo htmlentities($dalpaycheckoutData['state'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_zip" value="<?php echo htmlentities($dalpaycheckoutData['zip'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="cust_country_code" value="<?php echo htmlentities($dalpaycheckoutData['country'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="info1" value="<?php echo htmlentities($dalpaycheckoutData['info1'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="num_items" value="1" />
				<input type="hidden" name="item1_desc" value="<?php echo htmlentities($dalpaycheckoutData['item_name'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="item1_price" value="<?php echo htmlentities($dalpaycheckoutData['amount'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="item1_qty" value="1" />
				<input type="hidden" name="user1" value="<?php echo htmlentities($dalpaycheckoutData['custom'], ENT_COMPAT, "UTF-8");?>" />
				<input type="hidden" name="user2" value="<?php echo htmlentities($dalpaycheckoutData['transkey'], ENT_COMPAT, "UTF-8");?>" />
</form>
<script type="text/javascript">
document.frmDalpay.submit();
</script>
</div>
<div style="height:50px;">&nbsp;</div>
<div class="clear"></div>