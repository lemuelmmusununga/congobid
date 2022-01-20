<html>

    <head>
        <title>Main Home </title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript">

            // Ajax post
            $(document).ready(function () {
                $("#submit").click(function (event) {
                    var item = 'my product'; //$("input#item").val();
                    var price = '1000'; //$("input#price").val();

                   // var item = $("input#item").val();
                   // var price = $("input#price").val();
                   var sectery ='2533d9f908a29cb6fc3f405cc4db549e540153a4';//add by developer insharp 2015-11-26
                     var paytype = $('#paytype').val();
                    jQuery.ajax({
                        type: "POST",
                        crossDomain: true, // enable this
                        url: "https://payleq8.com/en/Gatewayservice/paymentamount",
                        dataType: 'json',
                        data: {item: item, price: price, sectery: sectery,pmethod :paytype},
                        success: function (res) {
                            if (res)
                            {
                                console.log(res);
                                randomString();
                                jQuery("#value_item").html(res.item);
                                jQuery("#value_price").html(res.price);
                                jQuery("#value_fullamount").html(res.fullamount);

                                $("#hitem").val(res.item);
                                $("#hprice").val(res.price);
                                $("#hpaytype").val(res.paytype);
                                $('#myModal').modal('show');

                            }
                            else
                            {
                                alert("Error calling the web service.");
                            }
                        },
                        error: function () {
                            alert("Error calling the web service.");
                        }
                    });

                });


            });
            function randomString() {
                var chars = "1234567890";
                var string_length = 4;
                var randomstring = '';
                for (var i = 0; i < string_length; i++) {
                    var rnum = Math.floor(Math.random() * chars.length);
                    randomstring += chars.substring(rnum, rnum + 1);
                }

                //$("#hkey").val(randomstring);
                //document.randform.randomfield.value = randomstring;
            }
        </script>
    </head>
    <body>
        <form  >
            <p>
                Comment :- <input type="text" value="item name" id="item" name="item"  maxlength="100"  />
            </p>
            <p>
                Price :- <input type="text" value="100" name="price" id="price" required=""/>
            </p>
<p>
                Payment type :-  <select  name="paytype" id="paytype" >
          
            <option value="1">Knet</option>
            <option value="3">Visa/Master</option>
           
           
        </select> 
            </p>
            <p>
                <button type="button"  id="submit" class="submit" value="Submit"> submit</button> 
            </p> 
        </form>


        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Payment Detail</h4>
                    </div>
                    <form action="paybypayle.php" method="post">
                        <input type="hidden" name="item" id="hitem"/>
                        <input type="hidden" name="price" id="hprice" />
                        <input type="hidden" name="key" id="hkey1" value="<?php echo rand(1,9999); ?>" />
                         <input type="hidden" name="paytype" id="hpaytype" />
                        <div class="modal-body">
                            <label class='label_output'>Entered Comment :<div id='value_item' > </div></label>
                            <label class='label_output'>Entered price :<div id='value_price'> </div></label>
                            <label class='label_output'>Full amount :<div id='value_fullamount'> </div></label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="pay">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>



