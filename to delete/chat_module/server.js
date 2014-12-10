var mongo = require('mongodb').MongoClient;
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

var mysql      = require('mysql');
var connection1 = mysql.createConnection({
  host     : '127.0.0.1',
  user     : 'root',
  password : 'redhat11111p',
});

connection1.connect(function(err) {
  // connected! (unless `err` is set)
	console.log(err);
});

var post  = {sender_id: 8, receiver_id: 7, message: 'hi script'};
var query = connection1.query('INSERT INTO ninjasTeamRoom.messages SET ?', post, function(err, result) {
  // Neat!
	//console.log("failled to insert "+ result);
});
console.log(query.sql);



app.get('/', function(req, res){
  res.sendfile('index.html');
});



mongo.connect('mongodb://127.0.0.1/chat', function(err, db){
  if(err) {throw err;}

  io.on('connection', function(socket){
    console.log('Someone connected!');
    var collection = db.collection('messages');

    var sendStatus = function(s){
      socket.emit('status', s);
    };

    //Emit all messages
    collection.find().limit(50).sort({_id: 1}).toArray(function(err, res){
      if(err) {sendStatus('Error fetching messages.');}

      //socket.emit('output', res);

    });

    var sql    = 'SELECT * FROM ninjasTeamRoom.messages';
    connection1.query(sql, function(err, results) {
      console.log(results);
      socket.emit('output', results);
    });

    //Wait for input from frontend
    socket.on('userinput', function(data){
      var receiver_id = data.receiver_id,
	        sender_id = data.sender_id, 
          message = data.message,
          whitespacePattern = /^\s*$/;

      if(whitespacePattern.test(message)){
        console.log('Invalid! Cannot insert empty string.');
        sendStatus('Message cannot be empty.');
      } else {

	    var post  = {receiver_id : receiver_id, 		sender_id :sender_id, message: message};
	    var query = connection1.query('INSERT INTO ninjasTeamRoom.messages SET ?', post, function(err, result) {
	     });

        collection.insert({receiver_id : receiver_id, 		sender_id :sender_id, message: message}, function(){
          console.log('data inserted into db.');

          //Emit latest messages to all Clients
          socket.broadcast.emit('output', [data]);

          socket.emit('output', [data]);

          //Send status to current client
          sendStatus({
            message : 'Message sent!',
            clear : true
          });
        });
      }

    });
  });
});


http.listen(3000, function(){
  console.log('listening on *:3000');
});
