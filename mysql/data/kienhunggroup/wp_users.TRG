TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `update_customer_data` BEFORE INSERT ON `wp_users` FOR EACH ROW BEGIN\n      -- Thêm dữ liệu vào bảng Customer\n    INSERT INTO customer (Customer_Name, Customer_Email)\n    VALUES (NEW.user_login, NEW.user_email);\n\n    -- Kiểm tra điều kiện 2: Nếu user_id của wp_usermeta trùng với ID của wp_users\n    IF EXISTS (SELECT 1 FROM wp_usermeta WHERE user_id = NEW.ID) THEN\n        -- Không thực hiện thêm dữ liệu vào bảng Customer\n        -- Sử dụng NOOP để không thực hiện bất kỳ hành động nào\n        SET @dummy = 0; -- NOOP\n    END IF;\nEND'
sql_modes=1098907648
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_unicode_ci'
db_cl_names='utf8mb4_vietnamese_ci'
created=1715571068019579
