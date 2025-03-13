TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `update_created_modified_dates3` BEFORE INSERT ON `project` FOR EACH ROW BEGIN\n    SET NEW.CreatedDate = NOW();\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER `transfer_data_to_warranty` \nAFTER INSERT ON `project` \nFOR EACH ROW \nBEGIN\n    DECLARE ProjectId INT;\n    DECLARE Title VARCHAR(255);\n    DECLARE MoTa TEXT;\n    DECLARE CreatedBy TEXT; \n\n    -- Lấy dữ liệu từ bản ghi mới được chèn\n    SET ProjectId = NEW.Id;\n    SET Title = NEW.TenDuAn;\n    SET MoTa = NEW.Project_Description;\n    SET CreatedBy = NEW.CreatedBy;\n\n    -- Kiểm tra điều kiện PaymentStatus\n    IF NEW.PaymentStatus = \'Hoàn thành\' THEN\n        -- Chuyển dữ liệu từ Project sang BaoHanh\n        INSERT INTO BaoHanh (ProjectId, Title, MoTa, CreatedBy)\n        VALUES (ProjectId, Title, MoTa, CreatedBy);\n    END IF;\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER `update_modified_date_on_edit_project` BEFORE UPDATE ON `project` FOR EACH ROW BEGIN\n    SET NEW.ModifiedDate = NOW();\nEND'
sql_modes=1098907648 1098907648 1098907648
definers='root@localhost' 'root@localhost' 'root@localhost'
client_cs_names='utf8mb4' 'utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_unicode_ci' 'utf8mb4_unicode_ci' 'utf8mb4_unicode_ci'
db_cl_names='utf8mb4_vietnamese_ci' 'utf8mb4_vietnamese_ci' 'utf8mb4_vietnamese_ci'
created=1715489123847957 1716362948341178 1715489168874784
