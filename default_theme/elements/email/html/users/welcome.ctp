<p>hi</p>
<p><?php echo sprintf(__('Hi %s', true), $data['User']['username']);?>,</p>

<p>Thanks for creating an account with PokeBidder. We have added 5 Free Bids to your 
    account so you can get started. We hope you have fun and find some great deals. </p>

<p>Want to see the most popular auctions? Click <a href="<?php echo $appConfigurations['url'];?>/auctions">here!</a> </p>


<p>Want to increase your chances of winning? Click    <a href="<?php echo $appConfigurations['url'];?>/packages"> here!</a> 
to add bids to your account!</p>

<p>Want more FREE BIDS? <a href="<?php echo $appConfigurations['url'];?>/invites">Invite your friends </a> to join!</p>

<p>Want to get even more FREE BIDS? Stay up to date with our 
    <a href="https://www.instagram.com/pokebiddertcg/">Instagram</a> 
    and 
    <a href="https://twitter.com/pokebidder">Twitter </a>
    for the latest giveaways and promotions!</p>

    <p>How does it work? Click  <a href="<?php echo $appConfigurations['url'];?>/page/how-it-works"> here</a> to find out!</p>
    <p> Click <a href="<?php echo $appConfigurations['url'];?>/pages/faq"> here</a> for the FAQs   </p>

    <p> Your user login is : <?php echo $data['User']['username'];?> </p>

    <p> Happy bidding!</p>

    <br />    <br />
    <br />
    <p>Still have questions? <a href="<?php echo $appConfigurations['url'];?>/contact"> Contact Us! </a> </p> 