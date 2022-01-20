<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/swiper.min.css">
<script src="<?php echo $this->webroot; ?>css/swiper.min.js"></script>
<div class="bnrbg">
 <div class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
	  <img  src="<?php echo $this->webroot; ?>img/bnr/banner-3.jpg" alt=""/>
		<a class="btn_new  left-animated btn-blue blue_fill" href="<?php echo $this->webroot; ?>users/register"><?php __('Register'); ?></a>	  
	  </div>
      <div class="swiper-slide">
		<img  src="<?php echo $this->webroot; ?>img/bnr/banner-2.jpg" alt=""/>	
		 <a class="btn_new  left-animated btn-blue blue_fill" href="<?php echo $this->webroot; ?>packages"><?php __('Buy Bids'); ?></a>	  		
	  </div>
      <div class="swiper-slide">
		<img  src="<?php echo $this->webroot; ?>img/bnr/banner-1.jpg" alt=""/>	 
		 <a class="btn_new  left-animated btn-blue blue_fill" href="<?php echo $this->webroot; ?>page/how-it-works"><?php __('Watch Tutorial'); ?></a>	  		
	  </div>
		
    </div>
</div>




<?php if($session->check('Auth.User')):?>
<a class="btn_new  left-animated btn-blue blue_fill hide" href="<?php echo $this->webroot; ?>packages"><?php __('Buy Bids'); ?></a>
<?php else:?>
<a class="btn_new  left-animated btn-blue blue_fill hide" href="<?php echo $this->webroot; ?>users/register"><?php __('Sign Up Today!'); ?></a>
<?php endif;?>
	
	 <div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
	</div>




 <script>
    var swiper = new Swiper('.swiper-container', {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,	        
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
	   autoplay: {
		delay: 5000,
		}
	 
    });
  </script>

<style>

@media only screen and ( min-width:320px) and ( max-width:900px ) {
	.swiper-button-prev, .swiper-container-rtl .swiper-button-next{
		left: 0px;
		background-size: 40px;
	}
	.swiper-button-next, .swiper-container-rtl .swiper-button-prev{
		right: 0px;
		background-size: 40px;
	}
	
	body .bnrbg a{
		max-width: 170px;
		font-size: 11px;
		padding: 10px 0px !important;		
	}

}
.swiper-container {
      width: 100%;
      height: 100%;
    }
.swiper-slide{
	position: relative;
}
.bnrbg a{
	left: 0;
	right: 0;
	top: 50%;
	margin-left: auto;
	margin-right: auto;
	position: absolute;
	max-width: 280px;
	padding-top: 20px;
	padding-bottom: 20px;
	font-size: 16px;
	border-radius: 4px !important;
	transform: translateY(-50%);
	background: #b41600;
	border: 2px solid #b41600;
}
.bnrbg a.blue_fill:hover, .bnrbg a.blue_fill:visited:hover {
    color: #b41600;
}

</style>
