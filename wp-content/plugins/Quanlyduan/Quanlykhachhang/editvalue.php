<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>
<?php
// Kết nối CSDL
require_once 'ketnoi.php';

// Lấy ID khách hàng từ URL
$customer_table = 'customer';
$id = $_GET['sid'];
$project_table = 'project';
$project_query = "SELECT * FROM $project_table";
$project_result = mysqli_query($conn, $project_query);
// Truy vấn để lấy thông tin của khách hàng cần chỉnh sửa
$edit_customer_query = "SELECT * FROM $customer_table WHERE Id = '$id'";
$edit_customer_result = mysqli_query($conn, $edit_customer_query);
$customer = mysqli_fetch_assoc($edit_customer_result);

// Truy vấn để lấy danh sách các dự án đã được chọn của khách hàng
$customer_projects_query = "SELECT MaDuAn FROM customer_project WHERE MaKhachHang = '$id'";
$customer_projects_result = mysqli_query($conn, $customer_projects_query);
$customer_projects = [];
while ($row = mysqli_fetch_assoc($customer_projects_result)) {
    $customer_projects[] = $row['MaDuAn'];
}
?>
<button onclick="window.location.href = 'http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management';" class="btn btn-outline-warning">Quay lại</button>
<h2 style="text-align :center"> Sửa Khách hàng</h2>
    <hr>
<form id="edit-customer-form" action="update_customer.php" method="post">
    <input type="hidden" name="id" value="<?php echo $customer['Id']; ?>">
    <div class="mb-3 mt-3">
        <label for="edit-customer-name">Tên:</label>
        <input type="text" name="name" id="edit-customer-name" class="form-control" value="<?php echo $customer['Customer_Name']; ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="edit-customer-address">Địa chỉ:</label>
        <input type="text" name="address" id="edit-customer-address" class="form-control" value="<?php echo $customer['Customer_Address']; ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="edit-customer-email">Email:</label>
        <input type="email" name="email" id="edit-customer-email" class="form-control" value="<?php echo $customer['Customer_Email']; ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="edit-customer-phone">Số điện thoại:</label>
        <input type="text" name="phone" id="edit-customer-phone" class="form-control" value="<?php echo $customer['Customer_Phone']; ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="edit-customer-description">Mô tả:</label>
        <textarea name="description" id="edit-customer-description" class="form-control"><?php echo $customer['Customer_description']; ?></textarea>
    </div>
    <div class="mb-3 mt-3">
    <label for="customer-projects">Dự án:</label><br>
    <select multiple id="customer-projects" name="customer_projects[]" class="form-control">
      <?php // Kiểm tra xem truy vấn có lỗi không
if (!$project_result) {
    echo "Lỗi: " . mysqli_error($conn);
} else {
    // Lặp qua tất cả các bản ghi dự án và tạo các tùy chọn cho menu dropdown
    while ($project = mysqli_fetch_assoc($project_result)) {
        echo '<option value="' . $project['Id'] . '" ' . (in_array($project['Id'], $customer_projects) ? 'selected' : '') . '>' . $project['TenDuAn'] . '</option>';
    }
} ?>
    </select>
</div>
<div class="mb-3 mt-3">
        <label for="Customer-modified_by">Được sửa bởi:</label>
        <input type="text" id="Customer-modified_by" name="Customer_modified_by" class="form-control" value="<?php echo $customer['Modifiedby']; ?>"/><br />
 </div> 

    <button type="submit" class="btn btn-primary">Cập nhật thông tin khách hàng</button>
</form>
</body>
</html>
