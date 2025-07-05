<?php
$conn = mysqli_connect("localhost","root","root","member");
if(!$conn){
die("链接数据库服务器失败");
}
mysqli_query($conn,"set names utf8");