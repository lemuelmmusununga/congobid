<?php
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' || 1) {
$item  = $_POST['item'];
$price = $_POST['price'];
$key = $_POST['key'];
$paytype=$_POST['paytype'];

?>

<body>
        <form action="https://payleq8.com/en/Gatewayservice/paymentinitialize" method="post" name="payleForm" id="payleForm">
            <!--<input type="hidden" id="lang" name="lang" value="en"/>-->
            <!-- <input type="hidden" id="sectery" name="sectery" value="2533d9f908a29cb6fc3f405cc4db549e540153a4"/> your business code that given by payle admin comment by developer insharp 2015-11-26--> 
 <input type="hidden" id="pmethod" name="pmethod" value="<?php echo $paytype; ?>"/>
           <input type="hidden" id="sectery" name="sectery" value="2533d9f908a29cb6fc3f405cc4db549e540153a4"/><!-- add by developer insharp 2015-11-26 -->
           <input type="hidden" id="key" name="key" value="<?php echo $key; ?>"/><!-- unique key for identify transaction --> 
            <input type="hidden" id="successurl" name="successurl" value="http://www.the1bid.com/webroot/payle/success.php"/><!-- success return url -->
            <input type="hidden" id="errorurl" name="errorurl" value="http://www.the1bid.com/webroot/payle/failpayment.php"/><!-- fail return url -->
          <!--  <input type=hidden name="item" value="test product<?php echo $item; ?>">comment by developer insharp 2015-11-26 -->
           <input type=hidden name="item" value="<?php echo $item; ?>"> <!-- add by developer insharp 2015-11-26 -->
           <!--  <input type=hidden name="price" value="1130<?php echo $price; ?>"> comment by developer insharp 2015-11-26 -->
            <input type=hidden name="price" value="<?php echo $price; ?>"> <!-- add by developer insharp 2015-11-26 -->
        </form>
    </body>

<script language="javascript" type="text/javascript">
   
    document.forms['payleForm'].submit();
       
</script>


<?php
 


}
 else {
    echo 'fail';
}

//ob_get_clean();
?>
