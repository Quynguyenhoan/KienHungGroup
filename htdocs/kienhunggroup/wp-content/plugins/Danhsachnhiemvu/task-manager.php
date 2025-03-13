<?php
/**
 * Plugin Name: Task Manager
 * Description: Plugin quản lý công việc với 4 hộp nhiệm vụ.
 * Version: 1.0
 * Author: Quy
 */

// Đảm bảo mã chỉ chạy khi được gọi từ WordPress
if (!defined('ABSPATH')) {
    exit;
}
function task_manager_enqueue_scripts() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'task_manager_enqueue_scripts');
// Kết nối với cơ sở dữ liệu và tạo bảng nếu chưa tồn tại
function task_manager_install() {
    global $wpdb;
    $table_name = 'tasks'; // Cập nhật tên bảng
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        task VARCHAR(255) NOT NULL,
        category INT NOT NULL,
        start_date DATE,
        end_date DATE,
        status TINYINT(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'task_manager_install');

// Thêm hook để tạo menu quản lý thống kê
add_action('admin_menu', 'tast_management_menu');

// Chức năng tạo mục menu quản lý thống kê
function tast_management_menu() {
    add_menu_page(
        'Quản lý Công việc',   // Tiêu đề trang
        'Nhiệm vụ',        // Tiêu đề menu
        'manage_options',      // Khả năng
        'tast-management',  // Slug
        'tast_management_page',  // Hàm hiển thị trang
        'dashicons-list-view', // Biểu tượng menu
    );
}

// Hiển thị trang quản trị
function tast_management_page() {
    ?>
    <div class="wrap">
        <h1>Quản lý Công việc</h1>
        <?php display_task_boxes_admin(); ?>
    </div>
    <?php
}


// Hiển thị các hộp nhiệm vụ trong trang quản trị
function display_task_boxes_admin() {
    ?>
    <div class="container">
        <div class="statistics-row">
            <?php
            $categories = array(
                1 => 'Việc vừa quan trọng vừa cần gấp',
                2 => 'Việc quan trọng nhưng chưa cần gấp',
                3 => 'Việc cần gấp nhưng không quan trọng',
                4 => 'Việc không cần gấp cũng không quan trọng'
            );

            foreach ($categories as $category_id => $category_name) {
                ?>
                <div class="statistics-box">
                    <h5><?php echo $category_name; ?></h5>
                    <ol class="task-list" id="task-list-<?php echo $category_id; ?>">
                        <?php
                        global $wpdb;
                        $table_name = 'tasks'; // Cập nhật tên bảng
                        $tasks = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE category = %d LIMIT 3", $category_id));
                        foreach ($tasks as $task) {
                            $status_text = $task->status ? ' (Hoàn thành)' : ' (Chưa hoàn thành)';
                            echo "<li data-task-id='" . esc_attr($task->id) . "'>" . esc_html($task->task) . " (Bắt đầu: " . esc_html($task->start_date) . " - Kết thúc: " . esc_html($task->end_date) . ") " . $status_text . " <button class='btn btn-warning' onclick='editTask(" . esc_attr($task->id) . ")'>Sửa</button> <button class='btn btn-dark' onclick='deleteTask(" . esc_attr($task->id) . ")'>Xóa</button> <button class='btn btn-success' onclick='completeTask(" . esc_attr($task->id) . ")'>Hoàn thành</button></li>";
                        }
                        ?>
                    </ol>
                    <input type="text" id="task-input-<?php echo $category_id; ?>" placeholder="Nhập nhiệm vụ" class="form-control mb-2">
                    <input type="date" id="start-date-<?php echo $category_id; ?>" class="form-control mb-2" placeholder="Ngày bắt đầu">
                    <input type="date" id="end-date-<?php echo $category_id; ?>" class="form-control mb-2" placeholder="Ngày kết thúc">
                    <button class="btn btn-primary" onclick="addTask(<?php echo $category_id; ?>)">Thêm</button>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script>
        function addTask(categoryId) {
            var taskInput = document.getElementById('task-input-' + categoryId);
            var startDate = document.getElementById('start-date-' + categoryId).value;
            var endDate = document.getElementById('end-date-' + categoryId).value;
            var taskTitle = taskInput.value.trim();
            if (taskTitle === '') {
                alert('Vui lòng nhập nhiệm vụ');
                return;
            }

            var data = {
                'action': 'add_task',
                'title': taskTitle,
                'category': categoryId,
                'start_date': startDate,
                'end_date': endDate,
                'nonce': '<?php echo wp_create_nonce('add_task_nonce'); ?>'
            };

            jQuery.post(ajaxurl, data, function(response) {
                if (response.success) {
                    var taskList = document.getElementById('task-list-' + categoryId);
                    var li = document.createElement('li');
                    li.textContent = taskTitle + ' (Bắt đầu: ' + startDate + ' - Kết thúc: ' + endDate + ') (Chưa hoàn thành)';
                    li.setAttribute('data-task-id', response.data.task_id);
                    var editButton = document.createElement('button');
                    editButton.textContent = 'Sửa';
                    editButton.onclick = function() { editTask(response.data.task_id); };
                    var deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Xóa';
                    deleteButton.onclick = function() { deleteTask(response.data.task_id); };
                    var completeButton = document.createElement('button');
                    completeButton.textContent = 'Hoàn thành';
                    completeButton.onclick = function() { completeTask(response.data.task_id); };
                    li.appendChild(editButton);
                    li.appendChild(deleteButton);
                    li.appendChild(completeButton);
                    taskList.appendChild(li);
                    taskInput.value = '';
                    document.getElementById('start-date-' + categoryId).value = '';
                    document.getElementById('end-date-' + categoryId).value = '';
                } else {
                    alert(response.data);
                }
            });
        }

        function editTask(taskId) {
            var taskTitle = prompt('Sửa nhiệm vụ:');
            var startDate = prompt('Ngày bắt đầu:');
            var endDate = prompt('Ngày kết thúc:');
            if (taskTitle && startDate && endDate) {
                var data = {
                    'action': 'edit_task',
                    'task_id': taskId,
                    'title': taskTitle,
                    'start_date': startDate,
                    'end_date': endDate,
                    'nonce': '<?php echo wp_create_nonce('edit_task_nonce'); ?>'
                };
                jQuery.post(ajaxurl, data, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data);
                    }
                });
            }
        }

        function deleteTask(taskId) {
            if (confirm('Bạn có chắc chắn muốn xóa nhiệm vụ này?')) {
                var data = {
                    'action': 'delete_task',
                    'task_id': taskId,
                    'nonce': '<?php echo wp_create_nonce('delete_task_nonce'); ?>'
                };
                jQuery.post(ajaxurl, data, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data);
                    }
                });
            }
        }

        function completeTask(taskId) {
            var data = {
                'action': 'complete_task',
                'task_id': taskId,
                'nonce': '<?php echo wp_create_nonce('complete_task_nonce'); ?>'
            };
            jQuery.post(ajaxurl, data, function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.data);
                }
            });
        }
    </script>
    <?php
}

// Xử lý AJAX để thêm nhiệm vụ
function handle_add_task() {
    check_ajax_referer('add_task_nonce', 'nonce');

    $title = sanitize_text_field($_POST['title']);
    $category = intval($_POST['category']);
    $start_date = sanitize_text_field($_POST['start_date']);
    $end_date = sanitize_text_field($_POST['end_date']);

    if (empty($title) || empty($category)) {
        wp_send_json_error('Dữ liệu không hợp lệ');
    }

    global $wpdb;
    $table_name = 'tasks'; // Cập nhật tên bảng

    $result = $wpdb->insert(
        $table_name,
        array(
            'task' => $title,
            'category' => $category,
            'start_date' => $start_date,
            'end_date' => $end_date
        )
    );

    if ($result === false) {
        wp_send_json_error('Lỗi khi lưu nhiệm vụ');
    }

    wp_send_json_success(array('task_id' => $wpdb->insert_id));
}
add_action('wp_ajax_add_task', 'handle_add_task');

// Xử lý AJAX để sửa nhiệm vụ
function handle_edit_task() {
    check_ajax_referer('edit_task_nonce', 'nonce');

    $task_id = intval($_POST['task_id']);
    $title = sanitize_text_field($_POST['title']);
    $start_date = sanitize_text_field($_POST['start_date']);
    $end_date = sanitize_text_field($_POST['end_date']);

    if (empty($task_id) || empty($title) || empty($start_date) || empty($end_date)) {
        wp_send_json_error('Dữ liệu không hợp lệ');
    }

    global $wpdb;
    $table_name = 'tasks'; // Cập nhật tên bảng

    $result = $wpdb->update(
        $table_name,
        array(
            'task' => $title,
            'start_date' => $start_date,
            'end_date' => $end_date
        ),
        array('id' => $task_id)
    );

    if ($result === false) {
        wp_send_json_error('Lỗi khi cập nhật nhiệm vụ');
    }

    wp_send_json_success();
}
add_action('wp_ajax_edit_task', 'handle_edit_task');

// Xử lý AJAX để xóa nhiệm vụ
function handle_delete_task() {
    check_ajax_referer('delete_task_nonce', 'nonce');

    $task_id = intval($_POST['task_id']);

    if (empty($task_id)) {
        wp_send_json_error('Dữ liệu không hợp lệ');
    }

    global $wpdb;
    $table_name = 'tasks'; // Cập nhật tên bảng

    $result = $wpdb->delete($table_name, array('id' => $task_id));

    if ($result === false) {
        wp_send_json_error('Lỗi khi xóa nhiệm vụ');
    }

    wp_send_json_success();
}
add_action('wp_ajax_delete_task', 'handle_delete_task');

// Xử lý AJAX để hoàn thành nhiệm vụ
function handle_complete_task() {
    check_ajax_referer('complete_task_nonce', 'nonce');

    $task_id = intval($_POST['task_id']);

    if (empty($task_id)) {
        wp_send_json_error('Dữ liệu không hợp lệ');
    }

    global $wpdb;
    $table_name = 'tasks'; // Cập nhật tên bảng

    $result = $wpdb->update(
        $table_name,
        array('status' => 1),
        array('id' => $task_id)
    );

    if ($result === false) {
        wp_send_json_error('Lỗi khi cập nhật trạng thái nhiệm vụ');
    }

    wp_send_json_success();
}
add_action('wp_ajax_complete_task', 'handle_complete_task');

// CSS cho plugin
function task_manager_admin_styles() {
    ?>
    <style>
        .statistics-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 20px 0;
        }

        .statistics-box {
            flex: 0 0 calc(48% - 10px);
            box-sizing: border-box;
            border: 5px solid #ddd;
            margin-bottom: 10px;
            padding: 20px;
            text-align: center;
        }

        .statistics-box h5 {
            font-size: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .statistics-box p {
            font-size: 14px;
            margin: 0;
        }

        .task-list {
            list-style-type: decimal;
            padding-left: 20px;
            text-align: left;
        }

        .db {
            text-align: center;
        }
    </style>
    <?php
}
add_action('admin_head', 'task_manager_admin_styles');
