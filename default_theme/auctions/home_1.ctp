
<?php
if(!empty($auctions_end_soon)) : ?>






<div class="main_content">

<div class="promo_bnr text-center">
	<div class="doc_width">		

	<div class="item item-1">
		<img class="img-fluid" src="<?php echo $this->webroot ?>img/bnr-step-1.png" alt="">
	</div>

	<div class="item item-2">
		<h2>
			<span><?php __('video des gagnants');?></span>			
		</h2>	
		<img class="img-fluid width-80" src="<?php echo $this->webroot ?>img/video-1.png" alt="">
	</div>

	<div class="item item-3">
		<h2>			
			<span><?php __('comment sa marche');?></span>
		</h2>	
		<img class="img-fluid width-80" src="<?php echo $this->webroot ?>img/video-2.png" alt="">
		<div class="row-btn">
			<a class="theme-btn" href="<?php echo $this->webroot ?>"><?php __('Nos Articles');?></a>
		</div>		
	</div>

	
	</div>
</div>

<div class="promo_bnr_text text-center d-none1">
	<?php __('Nos Articles sont originaux neufs dans leurs emballages dorigines  et garantis');?>
</div>
<div class="cat_menu">
	<div class="doc_width">
		<ul class="display_grid">
			<li><a class="theme-btn" href="<?php echo $this->webroot ?>"><span class="icon"></span>
				<?php __("S'inscrire");?></a>
			</li>
			<li><a class="theme-btn" href="<?php echo $this->webroot ?>"><span class="icon"></span>
				<?php __("Achetez des bids");?></a>
			</li>
			<li><a class="theme-btn" href="<?php echo $this->webroot ?>"><span class="icon"></span>
				<?php __("Videos explicatives");?></a>
			</li>
			<li><a class="theme-btn" href="<?php echo $this->webroot ?>"><span class="icon"></span>
				<?php __("Mon compte");?></a>
			</li>
		<ul>
	</div>
</div>



<div class="doc_width">
<h1 class="home_heading"><?php __('Live Auctions');?></h1>    
<?php echo $this->element('auctions_new_desing', array('auctions'=>$auctions_end_soon)); ?>
<div class="more-btn"><a  href="<?php echo $this->webroot ?>auctions"><?php __('Voir plus');?></a></div>	


<h1 class="home_heading" style="display:none"><?php __('Future Auctions');?></h1>  
<?php # echo $this->element('auctions_undated', array('auctions'=>$auctions_undated)); ?>
</div>
</div>
 
<?php endif; ?>

 

<?php if(!$_COOKIE['shown_video']){?>
<div id="videoModal">
	<div class="modal-dialog">
	<div class="modal-content">
	<span class="close-btn"></span>
		<video  controls loop="true" autoplay="true" id="theVideo">
		<source src="<?php echo $this->webroot;?>img/video1.mp4" type="video/mp4" />
		</video>
	</div>
	
	</div>
</div>
<?php  setcookie("shown_video", 1,  time()+7200  ); 
} ?>
<script>
$('.close-btn').click(function() {
	close();
});
$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) { // ESC
		close();	 
    }
});
function close(){
	$('#videoModal').fadeOut('slow');  
	$('#theVideo').get(0).pause();
	$('#theVideo').get(0).currentTime = 0;
	setcookie("shown_video", 1, <?php echo time()+7200 ?>);  /* expire in 1 hour */
}

</script>


<style>


	.promo_bnr{		
		background:#f8d4c2;	
		padding: 20px 0px;
	}
	.item{
		width: 36%;
		display: inline-block;
		vertical-align: middle;
		position:relative;
	}
	.item-1{
		width: 25%;		
	}
	.row-btn{
		text-align: right;		
	}
	.item.item-3 .row-btn{
		position:absolute;		
		bottom:15px;
		left: -75px;
	}
	.item.item-3 .row-btn a.theme-btn{
		font-size: 18px;
		padding: 10px 20px;
	}
	.promo_bnr h2{
		font-size:13px;
		text-transform: uppercase;
		padding-bottom:15px;
	}
	.promo_bnr h2 span{
		font-size: 16px;
	}
	.promo_bnr_text{
		background:#fff;
		padding:15px 20px;
		color:#000;
	}
	.cat_menu{
		 background-image: linear-gradient(#fedccb, #eba683);
		 padding:25px 0px;		 
	}
	.cat_menu ul{
		text-align:center;
	}
	.cat_menu li{
		display:inline-block;
	}
	
	.cat_menu li a{
		min-width: 200px;
		display: inline-block;
		padding: 15px;
	}
	.cat_menu li a:hover{
	}	
			
	a.theme-btn{
		background:#ff5e09;
		color:#fff;
		padding:10px;
		border-radius: 6px;
	}	
	a:hover.theme-btn{
		background:#000;
		color:#fff;		
	}		
	.img-fluid {
	  max-width: 100%;
	  height: auto;
	}
	.item-1 img{
		position: relative;
		top: 18px;
	}
	.width-80{
		width:80%;
	}
/*
ul.horizontal-bid-list li{display:none!important}
ul.horizontal-bid-list li:nth-child(11){
	display:block!important;
}
*/
ul.horizontal-bid-list li .sold_for{
	display:none!important;
}
ul.horizontal-bid-list li .close_sticker{
	display:none!important;
}	
ul.horizontal-bid-list li .thumb{
	margin: 0 auto;
	width: 46%;
	text-align: center;
	display: inline-block;
}
ul.horizontal-bid-list li .thumb img{
	height: 120px;
}
ul.horizontal-bid-list li{		
	width: 33%;
	min-height: 420px;
	margin: 0px 0px 4px 0px;
}
ul.horizontal-bid-list li h3{
	border:none;
	padding-bottom:5px;
}
ul.horizontal-bid-list li .bid-price{
	font-size;16px;
}
ul.horizontal-bid-list li .countdown{
	font-size:12px;
}
a.b-login-new{
	 background-image: linear-gradient(#008606, #02cf12, #008606);
	 border-radius: 6px;
	 height: 50px;
	line-height: 50px;
	padding: 0px 10px;
}
.left_sec{
	position: absolute;
	left: 0px;
	top:40px;
	width:110px;
	font-size:12px;
}
.right_sec{
	position: absolute;
	right: 15px;
	top:40px;
	width:100px;
	font-size:12px;
}
.click_price p{
	font-size:11px;
}
.click_price h2{
	font-size:16px;
}
.cat_sec{
	background: #fae4b8;	
	border-radius: 0px 10px 10px 0px;
	padding:10px;
	text-align: left;
	width:90px;
	margin-bottom: 10px;
	float: left;
}
.cat_name strong{
	color: #ee710c;
}
ul.horizontal-bid-list li .bid-price{
	text-align:left;
	color: #ee710c;
	margin:0;
}
.theme-color{
	color: #ee710c;
}
.live_chat{
	text-align:right;
	padding-bottom: 20px;
}
.click_price{	
	width: 110px;
	text-align: right;
	float: right;
	padding-bottom:30px;
}
ul.horizontal-bid-list li .bid-button{
	min-width: 90px;
	width: auto;
}
.bidbtn{
	padding-bottom:20px;
	float:right;
}
.auction_click{
	width: 100px;
	text-align: right;
	float: right;
}
.auction_click h2{
	font-size: 12px;
}
.auction_click input{
	float:left;
	border: 1px solid #e8e8e8;
	padding: 5px;
	width: 55px;
	font-size: 12px;
}	
.auction_click span{
	float: left;
	background: #d7d7d7;
	border-radius: 50px;
	width: 26px;
	height: 26px;
	text-align: center;
	line-height: 26px;
	font-size: 11px;
	text-transform: uppercase;
	font-weight: bold;
	cursor: pointer;
	margin-left: 6px;
}
.auction_click h2{
	margin-bottom: 10px !important;
}
.price_arrow{
	display:inherit;
}
.live_chat img{
	width: 70px;
}
.left_sec .row{
	margin-bottom:10px;	
}
.left_sec h2, .right_sec h2{
	margin:0px;
	padding:0px;
}
.options{
	position: absolute;
	left: 0;
	bottom: 15px;
	width: 100px;
}
.options img{
	height:20px;
	margin-bottom: 10px;
}
.options h2{
	padding-bottom:10px;
	font-size:14px;
}
.options .item_row{
	display:inline-block;
	width:38%;
	text-align:center;
}
.options .item_row span{
	border:1px solid #e8e8e8;
	padding: 5px 10px;
}
.vote{
	text-align:center;
	padding-top: 50px;
	font-weight: 500;
}
.vote .vote_text{
	width: 210px;
	margin: 0 auto;
}

.vote img{
	width:20px;
}
.vote h2{
	font-size:14px;
	margin-top: -10px !important;
}

.more-btn{
	text-align: center;	
	background:#cac6c6;
	padding:10px 0px;
	margin-top:20px;
	float: left;
	width: 100%;
}
.more-btn a{
	color:#6d6d6d;
	padding:10px 50px;
	border-radius:6px;
    background-image: linear-gradient(#fdebc3, #e0cca0);
	display: inline-block;
	font-size: 16px;
	font-weight: bold;	
}
.mb-0{
	margin-bottom:0!important;
}
.bonus_bid{
	position:relative;
	color: #555;
	font-size: 16px;
}
.bonus_bid:after{
	position:absolute;
	left:4px;
	top:50%;
	padding: 0px 5px
	content:"";
	width:100%;
	height:2px;
	background:#ee710c;
	
}
</style>

<style>
.d-none{display:none}
@media only screen and (max-width:800px) {
	body ul.horizontal-bid-list li{
		min-height: 430px;
		margin-bottom: 10px;		
	}

	body ul.horizontal-bid-list li .countdown{
		font-size: 15px;
	}
	body ul.horizontal-bid-list li h3 a{
		font-size: 17px !important;
	}
	ul.horizontal-bid-list li .thumb{
		width:40%;
	}
	ul.horizontal-bid-list li .thumb img{
		height:80px;
	}
	.vote .vote_text{
		font-size: 12px;
	}
	.item.item-3 .row-btn{
		bottom: -3px;
		left: -50px;
	}
	.promo_bnr h2 span{
		font-size:11px;
	}
	.item.item-3 .row-btn a.theme-btn{
		font-size: 14px;
		padding: 7px 10px;
	}
	.d-none{
		display:inline-block;
	}
	.cat_menu li {	  
	  width: 49%;	  
	  margin-bottom: 3px;
	}
	.cat_menu li a{
		display: block;
		min-width: inherit;
	}
	.left_sec .row{
		font-size:12px;
		margin-bottom: 5px;
	}
	.search_bg {
		border: 1px solid #ccc;
		width: 110px;
		padding: 7px 10px;
		padding-right: 33px;
		font-size: 14px;
		margin-left: 15px;
		border-radius: 4px;  
	}
	.search_icon{
		position: relative;
		right: 30px;
		top: 4px;
	}
	.home_heading{
		background:#ffdecd;
		text-transform: uppercase;
		font-size: 17px;
		padding-top: 10px;
		padding-bottom: 10px;
		margin-top:10px;
	}
	.search_icon img{width:16px;}	
   .top_lang a img{display:none;}
	body .main_menu .top_lang li a{color:#fff;}
	.top-account-link{  position: relative;left: -13px;top: 4px;}
	.top-account-link img{width:15px;}
	#header{
		background: #fda779;
	}
	.nav-btn{
		background: url(../img/drop_icon_white.png) no-repeat;
	}
	.top_lang{width:80px;}
	

	ul.horizontal-bid-list li.new_design{		
		border:none;
	}
	ul.horizontal-bid-list li h3 a{
		color: #6d6d6d !important;
	}
	
}
</style>