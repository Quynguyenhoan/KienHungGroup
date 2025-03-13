TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `update_created_modified_dates9` BEFORE INSERT ON `service` FOR EACH ROW BEGIN\n    SET NEW.CreatedDate = NOW();\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER `update_modified_date_on_edit_service` BEFORE UPDATE ON `service` FOR EACH ROW BEGIN\n    SET NEW.ModifiedDate = NOW();\nEND'
sql_modes=1098907648 1098907648
definers='root@localhost' 'root@localhost'
client_cs_names='utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_unicode_ci' 'utf8mb4_unicode_ci'
db_cl_names='utf8mb4_vietnamese_ci' 'utf8mb4_vietnamese_ci'
created=1715489452925538 1715489561960614
