<?php

header('Content-Type: text/html; charset=utf-8');

$username = trim($_POST['username']);
$pw = trim($_POST['pw']);
$cpw = trim($_POST['cpw']);
$sex = $_POST['sex'];


$email = $_POST['email'];
$fav = @implode(",",$_POST['fav']);

include_once "conn.php";
if(!strlen($username) || !strlen($pw)){
    echo "<script>alert('用户名和密码必须填写');history.back()</script>";
    exit;
}else{
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$username)){
        echo "<script>alert('用户名必填，且只能大小写字符和数字构成，长度为3-10个字符');history.back()</script>";
        exit;
    }
}
if($pw <> $cpw){
    echo "<script>alert('密码和确认密码不同');history.back()</script>";
    exit;
}else{
    if(!preg_match('/^[a-zA-Z0-9]{6,10}$/',$pw)){
        echo "<script>alert('密码必填，且只能大小写字符和数字构成，长度为3-10个字符');history.back()</script>";
        exit;
    }
}
if(!empty($email)){
    if(!preg_match('/^[a-zA-Z0-9_\-] + @([a-zA-Z0-9]+\.)+(com|cn|net|org)$/',$email)){
        echo "<script>alert('邮箱格式不正确');history.back()</script>";
        exit;
    }
}

$sql = "select * from info where username='$username'";
$result = mysqli_query($conn,$sql);
$num = mysqli_num_rows($result);
if($num){
    echo "<script>alert('此用户已经被占用，请返回从新输入');history.back();</script>";
    exit;
}

$sql = "insert into info (username,pw,sex,email,fav,createtime) value ('$username','".md5($pw)."','$sex','$email','$fav','".time()."')";
$result = mysqli_query($conn,$sql);


if($result){

    echo "<script>alert('数据插入成功');location.href='index.php'</script>";
}else{
    print_r( $sex);
    echo "<script>alert('数据插入失败');history.back();</script>";
}