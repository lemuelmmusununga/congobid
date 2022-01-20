<html>

    <head>
        <title>Transaction </title>


<!-- Latest compiled and minified JavaScript -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

 <script type="text/javascript">

            // Ajax post
            $(document).ready(function () {
            
                    var sectery = '2533d9f908a29cb6fc3f405cc4db549e540153a4';
                    var key = '127';
                    //event.preventDefault();
                     jQuery.ajax({
                        type: "POST",
                       crossDomain: true, // enable this
                        url: "http://paylegateway.test.payleq8.com/en/Gatewayservice/getdetail",
               
                        dataType: 'json',
                        data: {sectery :sectery,key :key },
                        success: function (res) {
                            if (res)
                            {
                                 console.log(res);
                               
                               for(var i=0;i< res.data.length;i++)
                              {
                                    $('#mydata').append('<tr><td>' + res.data[i]['txt']+'</td><td>' + res.data[i]['mkey']+'</td><td> ' + res.data[i]['amount']+ ' </td><td> ' + res.data[i]['date']+' </td><td> ' + res.data[i]['result']+'</td></tr>');
                              }
                               
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
          
        </script>
    </head>
    <body>
      
 <div >
            <table>
                <thead>
                <th>Comment</th>
                 <th>key</th>
                  <th>amount</th>
                   <th>date</th>
                    <th>result</th>
            </thead>
            <tbody id="mydata">
                
            </tbody>
            </table>
        </div>

    </body>
</html>



