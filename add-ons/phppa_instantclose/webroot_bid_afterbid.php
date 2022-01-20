<?php


// hidden reserve checking
$hiddenReserve = hiddenReserve($auction);
if($hiddenReserve == true) {
	$auction['message'] = __('You just won this auction - your bid was the hidden reserve!', true);
}


function hiddenReserve($data) {
	if(!empty($data['Bid']['user_id'])) {
		$auction = mysql_fetch_array(mysql_query("SELECT * FROM auctions WHERE id = ".$data['Bid']['auction_id']), MYSQL_ASSOC);
		if(($auction['hidden_reserve'] > 0) && ($auction['hidden_reserve'] == $auction['price'])) {
			closeAuction($auction);
			return true;
		}
	} else {
		return false;
	}
}