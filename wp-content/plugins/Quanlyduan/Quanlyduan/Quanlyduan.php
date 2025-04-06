<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- data table -->
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
    <style>
    /* Tăng kích thước của trình soạn thảo văn bản */
    #project-description_ifr {
        height: 600px !important; /* Điều chỉnh chiều cao của trình soạn thảo ở đây */
    }
</style>
</head>

<body>
    <?php 
    global $wpdb;
    $project_table ='project';
    $project_category_table = 'project_category';
    $project_data = $wpdb->get_results("SELECT * FROM $project_table");
    $category = $wpdb->get_results("SELECT * FROM $project_category_table");
    if ($wpdb->last_error) {
        echo "Lỗi: " . $wpdb->last_error;
    }
    ?>
    <h2>Bảng dự án</h2>
    <div class="wrap">
        <button id="add-project-btn" for="control-modal" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#project_modal">Thêm dự án</button>
        <!-- Thêm nút "Xóa hàng loạt" -->
        <button id="delete-selected-project-btn" class="btn btn-danger">Xóa hàng loạt</button>
        <table class="wp-list-table widefat fixed striped" id="project_table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-pro2-checkbox"></th>
                    <th>Hình ảnh</th>
                    <th>Hình ảnh nhiều</th>
                    <th>Tiêu đề</th>
                    <th>Nổi bật</th>
                    <th>Loại dự án</th>
                    <th>Tình trạng dự án</th>
                    <th>Khách hàng tham dự</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($project_data as $project): ?>
                <tr>
                    <td><input type="checkbox" class="delete-checkbox-project2" data-id="<?= $project->Id ?>"></td>
                    <td><img src="<?= $project->project_image_c ?>" alt="Hình ảnh" style="width: 50px;"></td>
                    <td>
                    <?php 
    // Lấy Id của dự án hiện tại
    $projectId = $project->Id;
    // Truy vấn dữ liệu hình ảnh cho dự án hiện tại
    $image = $wpdb->get_results("SELECT Project_Image_n FROM project_image WHERE Project_id = '$projectId'");
    ?>
                    <?php foreach ($image as $imageRow): ?>
                <img src="<?= $imageRow->Project_Image_n ?>" alt="Project Image" width="50" height="50">
            <?php endforeach; ?>
    <button class="btn btn-primary view-images-btn" data-bs-toggle="modal" data-bs-target="#imagemodalpro"  data-id="<?= $projectId ?>">
        ▧
    </button>
</td>
                    <td><?= $project->TenDuAn ?></td>
                    <td>
    <?php
    // Lấy đường dẫn đến file active.php trong plugin
    $plugin_dir_url = plugin_dir_url(__FILE__);

    // Kiểm tra giá trị của IS_Hot và tạo liên kết tương ứng
    if ($project->IS_Hot == 0) {
        echo '<a class="btn btn-dark" href="' . $plugin_dir_url . 'Hot.php?project_id='. $project->Id.'">X </a>';
    } elseif ($project->IS_Hot == 1) {
        echo '<a class="btn btn-primary" class="btn btn-dark"href="' . $plugin_dir_url . 'Hot.php?project_id='. $project->Id.'">✓</a>';
    } else {
        echo "Giá trị không hợp lệ";
    }
    ?>
</td>
                    <td>
                        <?php
                        $Title = '';
                        foreach ($category as $cate) {
                            if ($cate->Id == $project->ProjectCategory_id) {
                                $Title = $cate->Title;
                                break;
                            }
                        }
                        echo $Title;
                        ?>
                    </td>
                    <td><?= $project->PaymentStatus ?></td>
                    <td>
                        <?php
                        $customer_projects = $wpdb->get_results("SELECT c.Customer_Name FROM customer_project cp JOIN customer c ON cp.MaKhachHang = c.Id WHERE cp.MaDuAn = '$projectId'");
                        foreach ($customer_projects as $customer_project) {
                            echo $customer_project->Customer_Name . "<br>";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="<?= plugin_dir_url(__FILE__) . 'editvalue.php?sid=' . $project->Id ?>" class="btn btn-primary edit-project-btn">Sửa</a>
                        <a onclick="return confirm('Bạn có muốn xóa không !')" href="<?= plugin_dir_url(__FILE__) . 'Xoa.php?sid=' . $project->Id; ?>" class="delete-project-btn btn btn-dark" data-id="<?= $project->Id ?>">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="modal-content2"></div>
    <!-- Modal -->
    <div class="modal" id="project_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm mới dự án</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="<?= plugin_dir_url(__FILE__) . 'Them.php'; ?>" enctype="multipart/form-data">
                        <div class="mb-3 mt-3">
                            <label for="project-title">Tiêu đề:</label>
                            <input type="text" id="project-title" name="project_title" class="form-control" /><br />
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="project-alias">Alias:</label>
                            <input type="text" id="project-alias" name="project_alias" class="form-control" /><br />
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="project-diachi">Địa chỉ:</label>
                            <input type="text" id="project-diachi" name="project_diachi" class="form-control" /><br />
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="project-datenews">Ngày bắt đầu:</label>
                            <input type="date" id="project-datenews" name="project_datenews" class="form-control" /><br />
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="project-dateend">Ngày kết thúc :</label>
                            <input type="date" id="project-dateend" name="project_dateend" class="form-control" /><br />
                        </div>

                        <div class="mb-3 mt-3">
    <label for="project_description">Mô tả:</label>
    <?php
    // Lấy nội dung hiện tại của trình soạn thảo
    $content = '';
    if (isset($_POST['Project_Description'])) {
        $content = wp_unslash($_POST['Project_Description']);
    }
    wp_editor($content, 'project-description', array(
        'textarea_name' => 'project_description',
        'textarea_rows' => 200, // Đặt số hàng bạn muốn hiển thị ở đây
        'teeny' => false,
        'media_buttons' => true,
        'tinymce' => true,
    ));
    ?>
</div>

                        <div class="mb-3 mt-3">
                            <label for="project-image">Hình ảnh:</label>
                            <input type="hidden" id="project-image-url" name="project_image_c" />
                            <button id="upload-proimage-button" class="button">Chọn hình ảnh</button>
                            <img id="selected-imagepro" src="" style="display: none; width: 50px; height: 50px;" />
                        </div>

                        <label for="project-category">Thể loại:</label>
                        <select id="project-category" name="project_category_id">
                            <?php foreach ($category as $cate): ?>
                                <option value="<?= $cate->Id ?>"><?= $cate->Title ?></option>
                            <?php endforeach; ?>
                        </select>

                        <div class="mb-3 mt-3">
    <label for="payment-status">Tình trạng:</label>
    <select id="payment-status" name="payment_status" class="form-control">
        <option value="Hoàn thành">Hoàn thành</option>
        <option value="Chưa hoàn thành">Chưa hoàn thành</option>
        <option value="Đang chờ">Đang chờ</option>
    </select>
</div>

<div class="mb-3 mt-3">
                        <label for="total_amount">Nổi bật:</label>
    <input type="checkbox" id="IS_HOT" name="IS_HOT">
                        </div>

                        <div class="mb-3 mt-3">
                        <label for="total_amount">Tổng giá tiền:</label>
    <input type="text" id="total_amount" name="total_amount">
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="project-created-by">Được tạo bởi:</label>
                            <input type="text" id="project-created-by" name="project_created_by" class="form-control" /><br />
                        </div>

                        <input type="submit" value="Thêm dự án mới" class="btn btn-success" />
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">X</button>
                </div>
            </div>
        </div>
    </div>
    <!--####################################################################-->
  <script>
        jQuery(document).ready(function ($) {
            $('#upload-proimage-button').click(function (e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Chọn hình ảnh',
                    multiple: false
                }).open().on('select', function (e) {
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    $('#selected-imagepro').attr('src', image_url).show();
                    $('#project-image-url').val(image_url);
                });
            });
        });
 

        $('#project_table').dataTable({
            paging: false,
            scrollCollapse: true,
            scrollY: '300px'
        });

        // Chọn tất cả
        $(document).ready(function () {
            $('#select-pro2-checkbox').change(function () {
                if ($(this).prop('checked')) {
                    $('.delete-checkbox-project2').prop('checked', true);
                } else {
                    $('.delete-checkbox-project2').prop('checked', false);
                }
            });

            $('.delete-checkbox-project2').change(function () {
                if ($('.delete-checkbox-project2:not(:checked)').length > 0) {
                    $('#select-pro2-checkbox').prop('checked', false);
                } else {
                    $('#select-pro2-checkbox').prop('checked', true);
                }
            });
        });

        // Xóa hàng loạt
        jQuery(document).ready(function ($) {
            $('#delete-selected-project-btn').click(function () {
                var selectedIds = [];
                $('.delete-checkbox-project2:checked').each(function () {
                    selectedIds.push($(this).closest('tr').find('.delete-project-btn').data('id'));
                });
                $.ajax({
                    url: '<?= plugin_dir_url(__FILE__) . "xoahangloat.php"; ?>',
                    type: 'POST',
                    data: { ids: selectedIds },
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        alert('Lỗi xóa hàng loạt: ' + error);
                    }
                });
            });
        });

 // Hiển thị nhiều hình ảnh
 jQuery(document).ready(function ($) {
            $('#project-multi-image').change(function (e) {
                var files = e.target.files;
                var imageUrls = [];
                for (var i = 0; i < files.length; i++) {
                    var imageUrl = URL.createObjectURL(files[i]);
                    imageUrls.push(imageUrl);
                }
                showSelectedImages(imageUrls);
            });

        });


// modal nhiều hình ảnh
// modal nhiều hình ảnh
$(document).ready(function() {
    $('.view-images-btn').click(function() {
        var projectId = $(this).data('id'); // Lấy ID của dự án từ thuộc tính dữ liệu
        console.log(projectId); // In ra ID của dự án để kiểm tra
        $.ajax({
            url: '<?= plugin_dir_url(__FILE__) . 'modalimage.php'; ?>',
            type: 'POST',
            data: { projectId: projectId },
            success: function(response) {
                // Trước khi hiển thị modal, hãy xóa bất kỳ modal nào đang hiển thị
                $('#imagemodalpro').modal('hide'); // Ẩn modal hiện tại nếu đang hiển thị
                $('#modal-content2').html(response);
                $('#imagemodalpro').modal('show'); // Hiển thị modal mới
            },
            error: function(xhr, status, error) {
                console.error('Lỗi: ' + error);
            }
        });
    });
});



       
    // Tổng tiền 
    document.addEventListener("DOMContentLoaded", function() {
    // Lắng nghe sự kiện khi trường input total amount thay đổi
    document.getElementById("total_amount").addEventListener("input", function() {
        // Lấy giá trị nhập vào từ trường input
        let input_value = this.value;

        // Loại bỏ tất cả các ký tự không phải số và dấu phẩy (phân cách hàng nghìn)
        let numeric_value = input_value.replace(/[^\d,]/g, '');

        // Chuyển đổi giá trị thành số thực
        let amount = parseFloat(numeric_value.replace(/,/g, ''));

        // Kiểm tra xem giá trị có hợp lệ không
        if (!isNaN(amount)) {
            // Định dạng số tiền với hàng nghìn phân cách bằng dấu chấm, không có số lẻ
            let formatted_string = numberWithCommas(amount.toFixed(0));

            // Hiển thị giá trị đã chuyển đổi lại trong trường input
            this.value = formatted_string;
        }
    });
});

// Hàm tự định nghĩa để thêm dấu chấm làm phân cách hàng nghìn
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}



    </script>

</body>

</html>
