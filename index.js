var express = require("express");
var app = express();
var router = express.Router();
var path = __dirname + '/views/';

var web3 = require('web3');


app.use(express.static('bower_components'));

router.use(function (req,res,next) {
  console.log("/" + req.method);
  next();
});

router.get("/",function(req,res){
  res.sendFile(path + "index.html");
});

router.get("/about",function(req,res){
  res.sendFile(path + "about.html");
});

router.get("/contact",function(req,res){
  res.sendFile(path + "contact.html");
});



router.get("/api",function(req,res){
  res.json({
  	valor:"datos de prueba"
  });
});


app.use("/",router);

app.use("*",function(req,res){
  res.sendFile(path + "404.html");
});

app.listen(3000,function(){
  console.log("Live at Port 3000");
});