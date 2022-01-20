
                
                
                
                
			
            
            
            
    <table cellpadding="0" width="70%" align="center" border="0" style="COLOR:#000000;margin:0 auto;">
  <tbody>
  <tr>
    <td style="PADDING-BOTTOM:0.75pt;PADDING-TOP:0.75pt;PADDING-LEFT:0.75pt;PADDING-RIGHT:0.75pt">
      <table width="100%" cellspacing="0" cellpadding="0" border="1" style="BORDER-TOP:#777777 1pt solid;BORDER-RIGHT:#777777 1pt solid;WIDTH:100%;BORDER-BOTTOM:#777777 1pt solid;COLOR:#000000;BORDER-LEFT:#777777 1pt solid">
        <tbody>
        <tr>
          <td width="10" style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;WIDTH:7.5pt;BORDER-BOTTOM:medium none;padding:10px;">
            <p class="MsoNormal"><img width="200" src="http://luxdealstoday.felsaprojecten.nl/img/logo/logo.png" alt="luxdealstoday B.V"><u></u><u></u></p></td>
          <td style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;BORDER-LEFT:medium none;PADDING-RIGHT:0cm">
            <p align="center" style="TEXT-ALIGN:center" class="MsoNormal"><span style="FONT-SIZE:15pt;FONT-FAMILY:&quot;Arial&quot;,&quot;sans-serif&quot;">VOUCHER<u></u><u></u></span></p></td></tr>
        <tr>
          <td colspan="2" style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;BORDER-LEFT:medium none;PADDING-RIGHT:0cm">
            <div align="center" style="TEXT-ALIGN:center" class="MsoNormal">
            <hr width="100%" size="2" align="center">
            </div></td></tr>
        <tr style="HEIGHT:7.5pt">
          <td valign="top" style="BORDER-TOP:medium none;HEIGHT:7.5pt;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;padding:10px;">
            <p align="center" style="TEXT-ALIGN:center" class="MsoNormal">
            
   
            
            
           <div class="auction-image">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image'], array('class'=>'productImageMax', 'alt' => $auction['Product']['title'], 'title' => $auction['Product']['title']));?>
						<?php else:?>
							<?php echo $html->image('product_images/max/no-image.gif', array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title']));?>
						<?php endif; ?>
					</div> 
            
            
            
            
            
            
            
            
            
            
            
            
            <u></u><u></u></p></td>
          <td valign="top" style="BORDER-TOP:medium none;HEIGHT:7.5pt;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;BORDER-LEFT:medium none;PADDING-RIGHT:0cm">
            <table width="95%" cellspacing="0" cellpadding="0" border="0" style="WIDTH:95%;COLOR:#000000">
              <tbody>
              <tr>
                <td style="padding:10px;">
                  <div style="MARGIN-TOP:2.25pt">
                  <p class="MsoNormal"><span style="FONT-SIZE:13.5pt;FONT-FAMILY:&quot;Arial&quot;,&quot;sans-serif&quot;">
                  <?php echo $auction['Product']['title']; ?>
                  <u></u><u></u></span></p></div></td></tr>
              <tr>
                <td style="PADDING-BOTTOM:0.75pt;PADDING-TOP:0.75pt;PADDING-LEFT:0.75pt;PADDING-RIGHT:0.75pt">
                  <p class="MsoNormal">&nbsp;<u></u><u></u></p></td></tr>
              <tr>
                <td valign="top" style="padding:10px;">
                  <p class="MsoNormal"><strong><span style="COLOR:#555555">Leverancier</span></strong><span style="COLOR:#555555"><u></u><u></u></span></p></td></tr></tbody></table></td></tr>
        <tr>
          <td colspan="2" style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;BORDER-LEFT:medium none;PADDING-RIGHT:0cm">
            <div align="center" style="MARGIN-BOTTOM:7.5pt;TEXT-ALIGN:center;MARGIN-LEFT:0cm;MARGIN-RIGHT:0cm" class="MsoNormal">
            <hr width="100%" size="2" align="center">
            </div></td></tr>
        <tr>
          <td colspan="2" style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;BORDER-LEFT:medium none;PADDING-RIGHT:0cm">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="WIDTH:100%;COLOR:#000000">
              <tbody>
              <tr>
                <td width="30%" style="WIDTH:30%;padding:10px;">
                  <h3 align="center" style="TEXT-ALIGN:center;MARGIN:0cm 0cm 0pt"><span style="FONT-WEIGHT:normal">Voucherwaarde<u></u><u></u></span></h3>
                  <h2 align="center" style="TEXT-ALIGN:center;MARGIN-TOP:0cm"><span style="FONT-WEIGHT:normal"><?php echo $auction['Product']['rrp'];  ?></span><span style="FONT-SIZE:7pt;FONT-WEIGHT:normal;COLOR:#999999">Inclusief 
                  <?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span><span style="FONT-WEIGHT:normal"><u></u><u></u></span></h2></td>
                <td valign="bottom" style="PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;PADDING-RIGHT:0cm"></td>
                <td width="30%" style="WIDTH:30%;padding:10px;">
                  <h3 align="center" style="TEXT-ALIGN:center;MARGIN:0cm 0cm 0pt"><span style="FONT-WEIGHT:normal">Persoonlijke 
                  code<u></u><u></u></span></h3>
                  <h2 align="center" style="TEXT-ALIGN:center;MARGIN-TOP:0cm"><span style="FONT-WEIGHT:normal"><?php echo $cartProduct['CartProduct']['voucher_code']; ?><u></u><u></u></span></h2></td>
                <td valign="bottom" style="PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;PADDING-RIGHT:0cm"></td>
                <td width="30%" style="WIDTH:30%;padding:10px;">
                  <h3 align="center" style="TEXT-ALIGN:center;MARGIN:0cm 0cm 0pt"><span style="FONT-WEIGHT:normal">Aanbiederscode<u></u><u></u></span></h3>
                  <h2 align="center" style="TEXT-ALIGN:center;MARGIN-TOP:0cm"><span style="FONT-WEIGHT:normal"><u><?php echo $cartProduct['CartProduct']['voucher_code']; ?></u><u></u></span></h2></td></tr></tbody></table></td></tr>
        <tr>
          <td colspan="2" style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;BORDER-LEFT:medium none;PADDING-RIGHT:0cm">
            <div align="center" style="TEXT-ALIGN:center" class="MsoNormal">
            <hr width="100%" size="2" align="center">
            </div></td></tr>
        <tr>
          <td valign="top" colspan="2" style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0cm;PADDING-TOP:0cm;PADDING-LEFT:0cm;BORDER-LEFT:medium none;PADDING-RIGHT:0cm">
            <table width="95%" cellspacing="0" cellpadding="0" border="0" style="WIDTH:95%;COLOR:#000000">
              <tbody>
              <tr>
                <td valign="top" style="padding:10px;">
                  <p style="MARGIN-BOTTOM:3.75pt;MARGIN-LEFT:0cm;MARGIN-RIGHT:0cm" class="MsoNormal"><span style="COLOR:#555555">Hieronder kan je de specificaties van 
                  jouw bestelling terugvinden.<u></u><u></u></span></p></td>
                <td width="10" rowspan="3" style="WIDTH:7.5pt;PADDING-BOTTOM:1.5pt;PADDING-TOP:1.5pt;PADDING-LEFT:1.5pt;PADDING-RIGHT:1.5pt">
                  <p style="MARGIN-BOTTOM:3.75pt;MARGIN-LEFT:0cm;MARGIN-RIGHT:0cm" class="MsoNormal"><img src="http://luxdealstoday.felsaprojecten.nl/img/barkot_img.png" class="CToWUd"><u></u><u></u></p></td></tr>
              <tr>
                <td style="PADDING-BOTTOM:1.5pt;PADDING-TOP:1.5pt;PADDING-LEFT:1.5pt;PADDING-RIGHT:1.5pt"></td></tr>
              <tr>
                <td style="padding:10px;">
                  <p style="MARGIN-BOTTOM:3.75pt;MARGIN-LEFT:0cm;MARGIN-RIGHT:0cm" class="MsoNormal"><b>Te 
                  gebruiken</b><br><span style="COLOR:#555555">Landelijk Bestel 
                  het boeket voor 12 februari 16:30 uur en ontvang het op 
                  Valentijn (Voucher geldig t/m 12 februari 2015 16:30 
                  uur)</span> <u></u><u></u></p></td></tr>
              <tr>
                <td colspan="2" style="padding:10px;">
                  <p style="MARGIN-BOTTOM:3.75pt;MARGIN-LEFT:0cm;MARGIN-RIGHT:0cm" class="MsoNormal"><b>Over restaurant de Oude Toren in Waalre</b><span style="COLOR:#555555"><u></u><u></u></span></p>
                  <ul type="disc">
                   <?php echo $auction['Product']['description1'];?>
					</ul>
                    </td></tr>
              <tr>
                <td style="padding:10px;">
                  <p class="MsoNormal"><b><span style="COLOR:#555555">Afleveradres</span></b><span style="COLOR:#555555"><br>Trudie van Erven, Piet Heinstraat 
                  23, 5151ms&nbsp; drunen </span><u></u><u></u></p></td>
                <td style="PADDING-BOTTOM:1.5pt;PADDING-TOP:1.5pt;PADDING-LEFT:1.5pt;PADDING-RIGHT:1.5pt"></td></tr>
              <tr>
                <td colspan="2" style="padding:10px;">
                  <p><a target="_blank" href="https://www.luxdealstoday.nl/myvoucher/index/pdf/key2/YzhlNzM5ODVkY2Y2ZWI5ODg3NjAwMDc=/"><span style="COLOR:#333333">Of download hier de voucher als 
                  pdf</span></a><u></u><u></u></p></td></tr></tbody></table></td></tr></tbody></table></td></tr>
  <tr>
    <td style="padding:10px;">
      <div>
      <p class="MsoNormal"><span style="COLOR:#333333">Vragen? Mail naar <a target="_blank" href="mailto:info@luxdealstoday.nl">info@luxdealstoday.nl</a><br></span><span style="COLOR:#999999">luxdealstoday BV · Postvak 12 · Postbus 376 · 1000 EB 
      Amsterdam</span> <u></u><u></u></p></div></td></tr></tbody></table>
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
