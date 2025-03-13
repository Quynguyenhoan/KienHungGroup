<?php
//kết nối đến csdl
$servername="localhost";
$username="root";
$password="";
$dbname="banhang2";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_errno)
die("Connect fail:".$conn->connect_errno);
//khi kết nối thành công
//thực thi csdl
$mahh=$_POST["mahh"];
$tenhh=$_POST["tenhh"];
// $mahh="HH09";
// $tenhh="Mì chính";
$sql ="INSERT INTO hanghoa VALUE('".$mahh."','".$tenhh."')";
$result=$conn->query($sql);
//dong
$conn->close();
?>