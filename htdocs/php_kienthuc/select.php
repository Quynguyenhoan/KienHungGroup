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
$sql ="SELECT MaHH , TenHH FROM hanghoa";
$result=$conn->query($sql);
if($result->num_rows>0){
    //xuất từng dòng dữ liệu
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Mã hàng hóa</th>";
    echo "<th>Tên hàng hóa</th>";
    echo "</tr>";
   while($row=$result->fetch_assoc()){
    echo "<table border='1'>";
    echo "<tr>";
    echo "<td>".$row["MaHH"]."</td>";
    echo "<td>".$row["TenHH"]."</td>";
    echo "</tr>";
   }
   echo"</table>";
}
else 
echo "không có cơ sở dữ liệu".$conn->connect_errno;
//đóng kết nối
$conn->close();
?>
<!-- Đoạn mã PHP này thực hiện các bước sau:

1. **Kết nối đến CSDL:** Sử dụng đối tượng `mysqli` để kết nối đến cơ sở dữ liệu MySQL với thông tin như sau:
   - Server: localhost
   - Username: root
   - Password: (rỗng)
   - Tên cơ sở dữ liệu: banhang2

```php
$servername="localhost";
$username="root";
$password="";
$dbname="banhang2";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_errno)
    die("Connect fail:".$conn->connect_errno);
```

2. **Thực hiện truy vấn SQL:** Sử dụng câu lệnh SQL để lấy các cột `MaHH` và `TenHH` từ bảng `hanghoa`.

```php
$sql ="SELECT MaHH , TenHH FROM hanghoa";
$result=$conn->query($sql);
```

3. **Xử lý kết quả truy vấn:** Nếu có dữ liệu trả về từ truy vấn, sẽ hiển thị kết quả dưới dạng bảng HTML. Nếu không có dữ liệu, sẽ xuất thông báo "Không có cơ sở dữ liệu" và mã lỗi kết nối.

```php
if($result->num_rows>0){
    // Xuất tiêu đề bảng
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Mã hàng hóa</th>";
    echo "<th>Tên hàng hóa</th>";
    echo "</tr>";

    // Xuất dữ liệu từng dòng
    while($row=$result->fetch_assoc()){
        echo "<tr>";
        echo "<td>".$row["MaHH"]."</td>";
        echo "<td>".$row["TenHH"]."</td>";
        echo "</tr>";
    }
    echo"</table>";
}
else 
    echo "Không có cơ sở dữ liệu".$conn->connect_errno;
```

4. **Đóng kết nối:** Cuối cùng, đóng kết nối đến cơ sở dữ liệu để giải phóng tài nguyên.

```php
$conn->close();
```

Lưu ý: Mã lệnh này sử dụng MySQLi, một trong những extension để làm việc với MySQL trong PHP. Nó kiểm tra lỗi kết nối và xuất thông báo nếu có vấn đề. -->