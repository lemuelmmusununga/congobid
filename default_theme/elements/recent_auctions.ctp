<style>



a.button-small
{
	background:url(<?php echo $this->webroot;?>img/smallbid-bid_btn.png) no-repeat left top;
	width:68px;
	height:22px;
	margin-top:4px;
}
a.b-login
{

	background:url(<?php echo $this->webroot;?>img/smallbid-login_btn.png) no-repeat left top;
	width:68px;
	height:22px;
	margin-top:4px;	
}


    ul.horizontal-bid-list
    {
        margin:0 !important;
		width:965px;
        padding:0!important;
    }
    ul.horizontal-bid-list li .thumb{
        float:left;
		height:76px;
        width:100px;
        margin-left:0px;
		margin-top:6px;
    }
    .small_auction_right{
        float:right;
        width:100px;
    }
    #recentAuctions .timer
    {
		font-size:14px;
		float:right;
        font-weight:600;
        color:#004;
        letter-spacing:0px;
        padding-bottom:0px;
		padding-top:0px;
        margin:0px 4px 3px 0px;
}
    #recentAuctions .price
    {
        color:#929497;
		float:right;
		font-size:13px;
        line-height:40%;
        font-weight:400;
        padding:3px 0px 0px 0px;
}
    #recentAuctions .username{
        line-height:41%;
		margin-bottom:5px;
}
ul.small_ul li{
	-webkit-border-radius:6px;
	-moz-border-radius:6px;	
	width:223px;
	margin-bottom:0px;
	height:143px!important;
	margin-right:8px;
	padding:0px;
	min-height:143px;
	margin-left:0px;
}

ul.small_ul li h3{
  font-size:14px;
  font-weight:normal;
  height:27px;
  line-height:15px;
  padding-top:4px;
  margin-bottom:8px;
}
ul.horizontal-bid-list li .bid-price{
	font-size:16px!important;
	line-height:23px;
}
ul.horizontal-bid-list li .thumb img{
	width:82px;
}
ul.small_ul li h3 a{
  font-size:12px!important;
  color:#056EA4;
  font-weight:normal;	
  padding-top:10px;
}
ul.billing_info{
	float:left;
	width:338px;
	margin:10px 40px 0px 0px;
	padding:0px;
}
ul.billing_info li{
	margin:0px;
	padding:0px 0px 8px 0px;
	color:#929497;
	font-size:14px;
}
ul.billing_info li h3{
	margin:0px;
	padding:0px;
	color:#929497;
	font-size:12px;
	font-weight:normal;
}
p.bid_setting{
	color:#BBBDBF;
	font-size:13px;
	text-align:left;
	font-weight:bold;
	margin:0px!important;
	padding:10px 0px 0px 8px;
}
label.numberof_bids{
	color:#BBBDBF;
	font-size:13px;
	text-align:left;
	padding:6px 0px 0px 8px;	
}
.main_content h1.main_heading2{
	color:#fff;
	font-size:13px;
	font-weight:normal;
	height:20px;
	padding:4px 0px 0px 38px;
}

</style>

<?php $latestWinners = $this->requestAction('/auctions/latestwinner/4/' . $auction['Auction']['id']); ?>

<ul class="horizontal-bid-list small_ul" id="recentAuctions">
    <?php foreach ($latestWinners as $auction1): ?>
        <li class="auction-item" title="<?php echo $auction1['Auction']['id']; ?>" id="auction_<?php echo $auction1['Auction']['id']; ?>"><?php if (!empty($auction1['Product']['fixed'])): ?><a href="<?php echo AppController::AuctionLinkFlat($auction1['Auction']['id'], $auction1['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if (!empty($auction1['Auction']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($auction1['Auction']['id'], $auction1['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
            <div class="content" style="padding:0px!important;">
                <h3><?php echo $html->link($text->truncate($auction1['Product']['title'], 25), AppController::AuctionLink($auction1['Auction']['id'], $auction1['Product']['title'])); ?></h3>
                <div class="thumb clearfix">
                    <a href="<?php echo AppController::AuctionLinkFlat($auction1['Auction']['id'], $auction1['Product']['title']); ?>"><span class="<?php if (!empty($auction1['Auction']['penny'])): ?> penny<?php endif; ?><?php if (!empty($auction1['Auction']['peak_only'])): ?> peak_only<?php endif; ?><?php if (!empty($auction1['Auction']['beginner'])): ?> beginner<?php endif; ?> <?php if (!empty($auction1['Auction']['nail_bitter'])): ?> nail<?php endif; ?><?php if (!empty($auction1['Auction']['featured'])): ?> featured<?php endif; ?>"></span>
                        <?php
                        if (!empty($auction1['Product']['Image']) && !empty($auction1['Product']['Image'][0]['image'])) {
                            echo $html->image('product_images/thumbs/' . $auction1['Product']['Image'][0]['image']);
                        } else {
                            echo $html->image('product_images/thumbs/no-image.gif');
                        }
                        ?>
                    </a>
                </div>
                <div class="small_auction_right">
                    <div class="price clearfix">
				<?php if(!empty($auction['Product']['fixed'])):?>
					<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?>
					<span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
				<?php else: ?>
					<span class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
				<?php endif; ?>
			</div>
            <div id="timer_<?php echo $auction1['Auction']['id']; ?>" class="timer countdown clearfix" title="<?php echo $auction1['Auction']['end_time']; ?>">--:--:--</div>
                    <div class="username bid-bidder clearfix"><?php __('Highest bidder ');?></div>                     
                    <div class="bid-now clearfix">
                        <?php if (!empty($auction1['Auction']['isFuture'])) : ?>
                            <div><img src="<?php echo $this->webroot; ?>img/button/b-soon.gif" width="94" height="32" alt="Por favor espere a que comience la subasta" title="Por favor espere a que comience la subasta"></div>
                        <?php elseif (!empty($auction1['Auction']['isClosed'])) : ?>
                            <div><img src="<?php echo $this->webroot; ?>img/button/b-sold.gif" width="94" height="32" alt="" title=""></div>
                        <?php else: ?>
                            <?php if ($session->check('Auth.User')): ?>
                                <div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif'); ?></div>
                                <div class="bid-button"><a class="bid-button-link button-small" title="<?php echo $auction1['Auction']['id']; ?>" href="/bid.php?id=<?php echo $auction1['Auction']['id']; ?>">Bid</a></div>
                            <?php else: ?>
                                <div class="bid-button"><a href="/users/login" class="b-login"><?php __(@$j['menu_my_login']); ?></a></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    </div>
                    
                    <div class="bid-msg">
                        <div class="bid-message"></div>
                    </div>
               
            </div>
        </li>
    <?php endforeach; ?>
</ul>


