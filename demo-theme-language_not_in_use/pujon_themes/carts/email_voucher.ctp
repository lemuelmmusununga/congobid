<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Voucher PDF</title>
</head>

<body style="background:#404040;margin:0px;padding:0px;font-family:Arial, Helvetica, sans-serif;">
<?php 
$cart_product['rrp'] = $cart_product['rrp'] * $cart_product['quantity'] ;
if($cart_product_option['option_price'] > 0){
	$cart_product['price'] = $cart_product_option['option_price'] * $cart_product['quantity']; 
}else{
	$cart_product['price'] = $cart_product['price'] * $cart_product['quantity']; 
}
?>
<table width="850"  bgcolor="#ffffff"  align="center" cellpadding="40" cellspacing="0">
   <tr>
   <td valign="top">

<table width="850"  align="center" cellpadding="10" cellspacing="10" bgcolor="#ffffff" style="BORDER:#ff0099 12px solid;border-radius:10px;">
   <tr>
      <td valign="top">
      <a target="_blank" href="<?php echo $appConfigurations['url']?>">
      <img border="0" src="<?php echo $appConfigurations['url']?>/img/logo/logo.jpg" alt="luxdealstoday" >
      <!-- <img border="0" src="http://luxdealstoday1.felsaprojecten.nl/img/logo/logo_voucher.png" alt="luxdealstoday" > -->
      </a>
      </td>
      
      <td align="right"><b>code:</b> <?php echo $cart_product['voucher_code']; ?></td>
 
    </tr>
    
    
  <tr>
    <td bgcolor="#e1e0e0" colspan="2" valign="top" style="border-radius:10px;padding:20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td valign="top"><img border="0" src="<?php echo $appConfigurations['url']?>/img/product_images/thumbs/<?php echo $cart_product['image']; ?>" alt="luxdealstoday"></td>
     <td width="5%">&nbsp;</td>
      
    <td valign="top"><h3 style="FONT-SIZE:22px;FONT-WEIGHT:normal;MARGIN:0px 0px 11px;LINE-HEIGHT:25px">
    <a href="#"  style="COLOR:#000;text-decoration:none;">
	<?php echo $cart_product['title']; ?></a> 
	 <?php echo ($cart_product_option['option_title'] != '')  ? '<br />('.$cart_product_option['option_title'].')' : '' ;   ?> 
	</h3>
    <h4 style="margin:0px 0px;">&nbsp;</h4>
    
    <strong>Voucherwaarde:</strong> <font><?php echo $number->currency($cart_product['rrp'], $appConfigurations['currency']); ?></font>   <br /> 
    <strong>Voucherprijs:</strong> <font><?php echo $number->currency($cart_product['price'], $appConfigurations['currency']); ?> 
		<?php $dis = number_format(100 -  ( ($cart_product['price'] / $cart_product['rrp'] ) * 100 ), 2) ; ?>
		(<?php echo $dis; ?>% korting)</font>
    <p style="color:#ff0099;"><?php echo $time->niceShort($cart_product['created']);?></p>
    </td>


  
  </tr>
</table>

    </td>
  </tr>
  
  <tr>
    <td colspan="2" align="right">
    <p style="margin:0px;"><?php echo $time->niceShort($cart_product['created']);?></p>
    <p style="margin:0px;"><strong>Controlecode: <?php echo $cart_product['voucher_code']; ?></strong></p>
    </td>
  </tr>
  
  
  
  
  <tr>
    <td colspan="2" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td valign="top" width="40%">
  <h1 style="margin:0px;color:#ff0099;font-size:18px;padding-bottom:15px;">Highlights</h1>
  <ol style="list-style-position:outside;margin:0px;padding:5px 0px 0px 16px;list-style-type:disc;font-size:14px;">
  <ol>
 <?php  
		$highligh_arrays = explode(',',$cart_product['highlights'] );
		 foreach($highligh_arrays as $highligh_array){ 
			if($highligh_array != ''){ echo '<li style="padding-bottom:8px;">'.$highligh_array.'</li>'; }
		 }
 ?>
</ol>
  </ol>
  
  </td>
  
  <td width="10%">&nbsp;</td>
      
   <td valign="top">
  <h1 style="margin:0px;color:#ff0099;font-size:18px;padding-bottom:15px;">Voorwaarden</h1>
  <ol style="list-style-position:outside;margin:0px;padding:5px 0px 0px 16px;list-style-type:disc;font-size:14px;">
   <?php  
		$highligh2_arrays = explode(',',$cart_product['highlights2'] );
		 foreach($highligh2_arrays as $highligh2_array){ 
			if($highligh2_array != ''){ echo '<li style="padding-bottom:8px;">'.$highligh2_array.'</li>'; }
		 }
 ?>
  </ol>
  
  </td>


  
  </tr>
</table>

  </td>
  </tr>
  
  
  
  
  
  <tr>
    <td bgcolor="#e1e0e0" colspan="2" valign="top" style="border-radius:10px;padding:20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td valign="top">
   <?php echo $cart_product['address']; ?>
  </td>
     <td width="5%">&nbsp;</td>
      
    <td valign="middle" align="right">
    <img border="0" src="<?php echo $appConfigurations['url']?>/img/barcode/code_<?php echo $cart_product['id']; ?>.png" alt="barkot" >
    </td>


  
  </tr>
</table>

    </td>
  </tr>
  
  
  
 <tr>
    <td  colspan="2" valign="top" style="border-radius:10px;padding:20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td valign="top">
  
   <img border="0" width="215" src="<?php echo $appConfigurations['url']?>/img/logo/logo.jpg" alt="luxdealstoday" > 
  </td>
  
  <td width="5%">&nbsp;</td>
      
    <td valign="middle" align="right">
  
    </td>
    
    

  </tr>
  
  
 
  
  
  
  </table>
    </td>
  </tr> 
  
  
   <tr >
  <td colspan="2" align="center" style="font-size:12px;"><a  href="mailto:info@luxdeal.nl">info@luxdeal.nl</a> , Lux Deal Today, Postbus 2082, 5202 CB Den Bosch</td>
  </tr>
  
  
  
  
  
  
    
</table>



</td>
  </tr>
</table>



</body>
</html>
<script>window.print();</script>