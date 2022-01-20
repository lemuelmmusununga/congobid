




<div class="box clearfix">
<div class="top_heading">
<div class="doc_width">
<h1><?php __('Please wait while we transfer you to the payment gateway');?></h1>
</div>


</div>



<div class="main_content">
<div class="main_content_middle main_content_middle2">			

<div class="payment-redirect">
    <?php echo $paypal->submit(__('Click here if this page appears for more than 5 seconds', true), $paypalData);?>
    <script type="text/javascript">
        document.getElementById('frmPaypal').submit();
    </script>
</div>




</div> 

</div>
</div>
