<style>
.tooltips_icon {
	float:left;
	padding:10px 0px 0px 35px;
}
ul.horizontal-bid-list li.libig .bid-now {
	float:left;
	width:115px;
	padding:10px 0px 0px 0px;
}
ul.horizontal-bid-list li.libig {
	background:none;
	-webkit-border-radius:6px;
	-moz-border-radius:6px;
	width:642px;
	background:#fff;
	text-align:left;
	min-height:253px;
	margin:0px 0px 0px 29px;
}
ul.horizontal-bid-list li.libig h3 {
	padding:7px 0px 6px 0px!important;
	height:auto;
	font-size:16px;
}
ul.horizontal-bid-list li.libig .li_left {
	width:340px;
	text-align:left;
	float:left;
	padding-top:10px;
}
ul.horizontal-bid-list li.libig .li_right {
	width:275px;
	float:left;
	margin:56px 0px 0px 0px;
	text-align:left;
}
ul.horizontal-bid-list li.libig .li_right p {
	line-height:16px;
	margin:0px!important;
	padding:0px!important;
	min-height:32px;
	color:#767676;
	font-size:12px;
}
ul.horizontal-bid-list li.libig .bid-price {
	padding:0px;
	color:#000;
}
ul.horizontal-bid-list li.libig .pricebg {
	float:left;
	padding:6px;
	width:270px;
	margin-top:5px;
}
ul.horizontal-bid-list li.libig .timer_bg {
	float:left;
	padding:6px;
	width:270px;
	margin-top:5px;
}
ul.horizontal-bid-list li.libig .price {
	font-size:17px;
	margin-top:0px;
}
ul.horizontal-bid-list li.libig .currentprice {
	float:left;
	width:129px;
}
ul.horizontal-bid-list li.libig .currentprice h1 {
	color:#656565;
	font-size:15px;
	margin:0px;
	padding:0px;
}
ul.horizontal-bid-list li.libig .retail_price {
	float:right;
	width:129px;
	color:#000;
	font-size:18px;
	font-weight:bold;
}
ul.horizontal-bid-list li.libig .thumb img {
	width:auto;
}
ul.horizontal-bid-list li.libig .bid-button {
	float:left;
}
ul.horizontal-bid-list li.libig .retail_price h1 {
	color:#656565;
	font-size:15px;
	margin:0px;
	padding:0px;
}
ul.horizontal-bid-list li.libig .countdown {
	color:#ff0000;
	margin-top:2px;
	letter-spacing:normal;
	font-size:20px;
	font-weight:normal;
}
ul.horizontal-bid-list li.libig .timer_left {
	width:129px;
	float:left;
}
ul.horizontal-bid-list li.libig .timer_right {
	width:129px;
	float:right;
	color:#656565;
	font-size:15px;
}
</style>
<ul class="horizontal-bid-list">
  <li class="auction-item libig" title="<?php echo $featured['Auction']['id'];?>" id="auction_<?php echo $featured['Auction']['id'];?>">
    <?php if(!empty($featured['Product']['fixed'])):?>
    <a href="<?php echo AppController::AuctionLinkFlat($featured['Auction']['id'], $featured['Product']['title']); ?>"><span class="fixed"></span></a>
    <?php endif; ?>
    <?php if(!empty($featured['Auction']['free'])) : ?>
    <a href="<?php echo AppController::AuctionLinkFlat($featured['Auction']['id'], $featured['Product']['title']); ?>"><span class="free"></span></a>
    <?php endif; ?>
    <div class="content">      
      <div class="li_right">
      <h1 class="future">Future Auctions</h1>
        <h3><?php echo $html->link($text->truncate($featured['Product']['title'],25), AppController::AuctionLink($featured['Auction']['id'], $featured['Product']['title']));?></h3>
        <p><?php echo $text->truncate($featured['Product']['brief'],80); ?></p>
        <div class="pricebg">
          <div class="price clearfix">
            <div class="currentprice">
              <h1>Current Price</h1>
              <span class="bid-price"><?php echo $number->currency($featured['Auction']['price'], $appConfigurations['currency']); ?></span></div>
            <div class="retail_price">
              <h1>Retail Price</h1>
              <?php echo $number->currency($featured['Product']['rrp'], $appConfigurations['currency']);?></div>
          </div>
        </div>
        <div class="timer_bg">
          <div class="timer_left">
            <div id="timer_<?php echo $featured['Auction']['id'];?>" class="timer countdown clearfix" title="<?php echo $featured['Auction']['end_time'];?>">--:--:--</div>
          </div>
          <div class="timer_right">
            <div class="username bid-bidder clearfix">Highest bidder</div>
          </div>
        </div>
        <div class="bid-now clearfix">
          <?php 
					$hide_bid_button=false;
					eval(AddonManager::hook('views_elements_auction_beforebidbutton')); 
				?>
          <?php if (!$hide_bid_button): ?>
          <?php if(!empty($featured['Auction']['isFuture'])) : ?>
          <div><img src="<?php echo $this->webroot; ?>img/button/b-soon.gif"  alt="Please wait until the auction begins" title="Please wait until the auction begins"></div>
          <?php elseif(!empty($featured['Auction']['isClosed'])) : ?>
          <div><img src="<?php echo $this->webroot; ?>img/button/b-sold.gif"  alt="" title=""></div>
          <?php else:?>
          <?php if($session->check('Auth.User')):?>
          <div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
          <div class="bid-button"><a class="bid-button-link button-small" title="<?php echo $featured['Auction']['id'];?>" href="/bid.php?scheck=<?php echo $csrf;?>&id=<?php echo $featured['Auction']['id'];?>">&nbsp;</a></div>
          <?php else:?>
          <div class="bid-button"><a href="/users/login" class="b-login">
            <?php __(@$j['menu_my_login']);?>
            </a></div>
          <?php endif;?>
          <?php endif; ?>
          <?php endif; ?>
        </div>
        <div class="tooltips_icon">
          <div class="add_icon"><a href="#"><img src="<?php echo $this->webroot; ?>img/clock_icon.png">
            <div class="add_toltip">Penny Auction</div>
            </a> </div>
          <div class="add_icon"><a href="#"><img src="<?php echo $this->webroot; ?>img/free_icon.png">
            <div class="add_toltip">Penny Auction</div>
            </a> </div>
          <div class="add_icon"><a href="#"><img src="<?php echo $this->webroot; ?>img/cash_icon.png">
            <div class="add_toltip">Penny Auction</div>
            </a> </div>
        </div>
        <div class="bid-msg">
          <div class="bid-message"></div>
        </div>
      </div>
      <div class="li_left">
        <div class="thumb clearfix"> <a href="<?php echo AppController::AuctionLinkFlat($featured['Auction']['id'], $featured['Product']['title']); ?>"><span class="<?php if(!empty($featured['Auction']['penny'])):?> penny<?php endif;?><?php if(!empty($featured['Auction']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($featured['Auction']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($featured['Auction']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($featured['Auction']['featured'])):?> featured<?php endif;?>"></span>
          <?php
				if(!empty($featured['Product']['Image']) && !empty($featured['Product']['Image'][0]['image'])) {
					echo $html->image('product_images/max/'.$featured['Product']['Image'][0]['image']);
				} else {
					echo $html->image('product_images/thumbs/no-image.gif');
				} 
				?>
          </a> </div>
      </div>
    </div>
  </li>
</ul>
