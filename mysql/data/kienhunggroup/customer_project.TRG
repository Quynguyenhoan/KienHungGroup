TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER after_insert_customer_project_IsFromContact\nAFTER INSERT ON customer_project\nFOR EACH ROW\nBEGIN\n    IF NEW.MaDuAn IS NOT NULL THEN\n        UPDATE customer\n        SET IsFromContact = 4\n        WHERE Id = NEW.MaKhachHang;\n    END IF;\nEND'
sql_modes=1098907648
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_unicode_ci'
db_cl_names='utf8mb4_vietnamese_ci'
created=1715872218213478
