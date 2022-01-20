<style>
.hide{
	display:none;
}
.payment-logos{
	position: absolute;
	right: 0;
	top: 168px;
}
.footerlink ul{
	position: relative;
}

</style>
 
 
 <div class="fot_invite">
<div class="doc_width">
<span><strong><?php __('Invite Your Friends');?></strong> 
<?php __('and get free bids');?>.</span>
<a class="btn_new  animated-btn animated-1" href="<?php echo $this->webroot?>invites">
<?php __('Invite Friends');?></a>
</div>
</div>


 <div class="pay-logos">
<div class="doc_width">
<img  src="<?php echo $this->webroot; ?>img/payment-logos-full.jpg" alt=""/>
</div>
</div>






<div class="doc_width">
<div class="footerlink">

<ul class="about_ul">
<p class="logo_footer"><img src="<?php echo $this->webroot; ?>img/footer-logo.png"/></p>
<p class="about_p">
<?php __("Welcome to Congo Bid -  Congo Bid allows you to acquire what you have always dreamed of at prices defying all standards, for the simple reason that you are the one who decides the price to pay.");?>

</p>

</ul>




<ul>
<h2><?php __('Quick Links');?></h2>

<li>
<a  href="<?php echo $this->webroot?>users/register">
<?php __('Join Now!');?></a>
</li>

<li>
<a  href="<?php echo $this->webroot?>auctions">
<?php __('Live Auctions');?></a>
</li>

<li>
<a href="<?php echo $this->webroot?>contact">
<?php __('Contact Us');?></a>
</li>



<li>
<a href="<?php echo $this->webroot?>page/how-it-works">
<?php __('How It Works');?></a>
</li>
</ul>



<ul>
<h2><?php __('Support');?></h2>


<li>
<a  href="<?php echo $this->webroot?>page/frequently-asked-questions">
<?php __('Faq');?></a>
</li>

 
<li>
<a  href="<?php echo $this->webroot?>page/help">
<?php __('Help');?></a>
</li>



</li>
</ul>



<ul>
<h2><?php __('About Us');?></h2>

 



<li>
<a href="<?php echo $this->webroot?>page/terms-and-conditions">
<?php __('Terms & Conditions');?></a>
</li>


<li>
<a href="<?php echo $this->webroot?>page/privacy-policy">
<?php __('Privacy Policy');?></a>
</li>


</ul>


<ul class="follow">
        <h2><?php __("follow us on");?>:</h2>
        <li class="social_icon f_icon"><a href="https://www.facebook.com/Congo-Bid-101599165504952?_rdc=2&_rdr">&nbsp;</a></li>
<li class="social_icon t_icon"><a href="https://twitter.com/BidCongo">&nbsp;</a></li>
 <li class="social_icon g_icon"><a href="https://instagram.com/congobid?utm_medium=copy_link">&nbsp;</a></li>
		
	<div class="fot-logo-pay">
	<img  src="<?php echo $this->webroot; ?>img/logo-visa.jpg" alt=""/>
	<img  src="<?php echo $this->webroot; ?>img/logo-master.jpg" alt=""/>
	<img  src="<?php echo $this->webroot; ?>img/logo-equity.jpg" alt=""/>
	<img  src="<?php echo $this->webroot; ?>img/logo-mpesa.jpg" alt=""/>
	<img  src="<?php echo $this->webroot; ?>img/logo-airtel.jpg" alt=""/>
	<img  src="<?php echo $this->webroot; ?>img/logo-orange-money.jpg" alt=""/>
	</div>

		</ul> 





</div>
</div>




<div class="copyright">
<div class="doc_width">
<span class="f_l">
CongoBid.©<?php echo date("Y"); ?> <?php __('All Rights Reserved.');?>
</span>


<span class="f_r">
<a href="<?php echo $this->webroot?>page/terms">
<?php __('Terms & Conditions');?>
</a>
<a style="padding-left:15px;" href="<?php echo $this->webroot?>page/privacy-policy">
<?php __('Privacy Policy');?>
</a>
</span>
</div>
<span class="day_text hide"><?php __('d');?></span>
</div>
<audio id="rewards_point">
  <source src="/audio.wav" type="audio/wav">
   Your browser does not support the audio element.
</audio>
 
<script>
var x = document.getElementById("rewards_point"); 

function playAudio() { 
  x.play(); 
} 

function pauseAudio() { 
  x.pause(); 
} 
</script>

<script>

 
$("input").each(function() {
   var element = $(this);
   if (element.val() != "") {
       element.parents('.input').addClass('focused');
   }
}); 
$("textarea").each(function() {
   var element = $(this);
   if (element.val() != "") {
       element.parents('.input').addClass('focused');
   }
});

$('input').focus(function(){
  $(this).parents('.input').addClass('focused');
});

$('input').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
    $(this).parents('.input').removeClass('focused');  
  }
})  






$('textarea').focus(function(){
  $(this).parents('.input').addClass('focused');
});

$('textarea').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
   
    $(this).parents('.input').removeClass('focused');  
  }
})

</script>



<script>

 
	 
$('html').click(function() {
	$('.main_error').hide();  
});
$('.error_inner').click(function(e){ 
	e.stopPropagation();
});
$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {  
        $('.main_error').hide();   
    }
});

<?php $times='2500'; if($_GET['e']==1){ $times='8000'; } ; ?>
setTimeout(function() {
    $('.main_error').fadeOut('slow');   
}, <?php echo  $times ?> ); 
</script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MFPGMKQP4P"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MFPGMKQP4P');
</script>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '3350810048353862');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=3350810048353862&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->