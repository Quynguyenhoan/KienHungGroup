TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `update_created_modified_dates5` BEFORE INSERT ON `baohanh` FOR EACH ROW BEGIN\n    SET NEW.CreatedDate = NOW();\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER `default_warranty_duration` BEFORE INSERT ON `BaoHanh` FOR EACH ROW\nBEGIN\n    -- Kiểm tra nếu thời gian bảo hành được chèn là NULL\n    IF NEW.ThoiGianBaoHanh IS NULL THEN\n        -- Cập nhật thời gian bảo hành mặc định là 24 tháng\n        SET NEW.ThoiGianBaoHanh = 24;\n    END IF;\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER `update_modified_date_on_edit` BEFORE UPDATE ON `baohanh` FOR EACH ROW\nBEGIN\n    SET NEW.ModifiedDate = NOW();\nEND'
sql_modes=1098907648 1098907648 1098907648
definers='root@localhost' 'root@localhost' 'root@localhost'
client_cs_names='utf8mb4' 'utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_unicode_ci' 'utf8mb4_unicode_ci' 'utf8mb4_unicode_ci'
db_cl_names='utf8mb4_vietnamese_ci' 'utf8mb4_vietnamese_ci' 'utf8mb4_vietnamese_ci'
created=1715487681624695 1715510820457987 1715488374260362
