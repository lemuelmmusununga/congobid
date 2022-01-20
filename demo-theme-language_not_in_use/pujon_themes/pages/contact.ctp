<style>
fieldset .text input, fieldset .password input, fieldset .textarea textarea{
	width:250px;
}
fieldset .text label, fieldset.contact .text label, fieldset.contact .select label, fieldset.contact .textarea label{
	text-align:left;
	width:90px;
}
fieldset label{
	text-align:left;
	width:90px;
}
select{
	background:#fff;
	border:1px solid #ccc!important;
	padding:6px 0px 6px 0px;
	width:260px;
	font-family:Arial, Helvetica, sans-serif;
}
#recaptcha_area{
	float:left!important;
	width:250px!important;
}
fieldset div.submit{
	margin-left:99px!important;
	margin-bottom:5px!important;
	margin-top:10px!important;	
}
</style>


<div class="main_content_middle">			
<div class="page_div">
<h2 style="text-transform:uppercase;"><?php __('Contact Us');?></h2>
<br />
<h1><?php __('We are here to assist you');?><br />
<?php __('2 EASY WAYS to stay in touch');?></h1>
<br />
<div class="dots" style="width:300px;"></div>
<br />


<div class="contact_icon">
<div class="icon_envolope"></div>
<h2 style="text-transform:uppercase;"><?php __('Email Us');?></h2>
<h3><a href="mailto:care@bidnbids.com">care@bidnbids.com</a></h3>
</div>

<div class="contact_icon contact_icon_right">
<div class="icon_envolope icon_faq"></div>
<h2><?php __('FAQs');?></h2>
<h3><font class="dir_none"><?php __('Check our');?></font><a href="<?php echo $this->webroot;?>pages/faq"><?php __('FAQs');?></a> <?php __('for more answers');?></h3>

</div>





</div>             
</div>  
