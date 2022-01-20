var fs = require('fs');
var https = require('https');
var bodyParser     =        require("body-parser"); 
var express = require('express');
var app = express();

var options = {
key  : fs.readFileSync('/etc/apache2/ssl/new/pokebidder_com_key.txt', 'utf8'),
cert : fs.readFileSync('/etc/apache2/ssl/new/pokebidder_com.crt', 'utf8')
};
var serverPort = 3001;

var server = https.createServer(options, app);
var io = require('socket.io')(server);

app.get("/",function(req,res)
{
	res.send('Hurrreee! Its working! again ');
});

app.use(bodyParser.urlencoded({ extended: false }));

app.post("/push",function(req,res)  //leave it push? yes but modify the php  
{
    
   io.emit('push',req.body); 
	 
	//console.log(req.body); 
	res.send('Ok'); 
	
});

io.on('connection', function(socket) {
  console.log('new connection');
  socket.emit('message', 'This is a message from the dark side.');
});

server.listen(3002, '0.0.0.0',function(){
    console.log("Listening on 3002");
});