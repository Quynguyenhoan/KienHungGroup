TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `prevent_duplicate_statistics` \nBEFORE INSERT ON `wordpress_statistics`\nFOR EACH ROW \nBEGIN\n    DECLARE duplicate_count INT;\n\n    -- Kiểm tra xem có bản ghi nào trùng lặp không\n    SELECT COUNT(*) INTO duplicate_count\n    FROM `wordpress_statistics`\n    WHERE \n        `Date` = NEW.`Date`\n        AND `Projects_Completed` = NEW.`Projects_Completed`\n        AND `Projects_Under_Warranty` = NEW.`Projects_Under_Warranty`\n        AND `Total_News` = NEW.`Total_News`\n        AND `Total_Customers` = NEW.`Total_Customers`\n        AND `Total_Services` = NEW.`Total_Services`;\n\n    -- Nếu tìm thấy bản ghi trùng lặp, ngăn chặn việc chèn bản ghi mới\n    IF duplicate_count > 0 THEN\n        SIGNAL SQLSTATE \'45000\'\n        SET MESSAGE_TEXT = \'Duplicate entry is not allowed in wordpress_statistics\';\n    END IF;\nEND'
sql_modes=1098907648
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_unicode_ci'
db_cl_names='utf8mb4_vietnamese_ci'
created=1716609750347176
