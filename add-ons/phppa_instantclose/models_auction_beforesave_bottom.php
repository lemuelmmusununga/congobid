<?php
if (isset($this->data['Auction']['product_id'])) {
	if(empty($this->data['Auction']['hidden_reserve'])) {
		$this->data['Auction']['hidden_reserve'] = 0;
	}
}