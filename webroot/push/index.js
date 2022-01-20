var app     =     require("express")();  
var http    =     require('http').Server(app);  
var io      =     require("socket.io")(http);
var bodyParser     =        require("body-parser");   

var users = [];

app.use(bodyParser.urlencoded({ extended: false }));

app.post("/push",function(req,res)  //leave it push? yes but modify the php  
{
    io.emit('push',req.body);
	console.log('request =');
	console.log(req.body);
	res.send('Ok'); 
});

app.get("/",function(req,res)
{
	res.send('Hurrreee! Its working! ');
});

http.listen(3000, '0.0.0.0',function(){
    console.log("Listening on 3000");
});



io.on('connection',function(socket)
{ 
	console.log('User Connented!'); 
});


