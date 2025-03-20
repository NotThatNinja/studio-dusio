-- Insert example data into `alerts` table
INSERT INTO `alerts` (`id`, `date`, `title`, `text`) VALUES
(1, NOW(), 'System Maintenance', 'The system will undergo maintenance on March 25th.'),
(2, NOW(), 'New Feature Released', 'We are excited to announce a new feature in our platform.'),
(3, NOW(), 'Security Update', 'A critical security update has been applied to the system.');

-- Insert example data into `reviews` table
INSERT INTO `reviews` (`id`, `date`, `name`, `surname`, `text`, `approved`) VALUES
(1, NOW(), 'John', 'Doe', 'I am very satisfied with the service provided.', 1),
(2, NOW(), 'Jane', 'Smith', 'The experience was okay, but there is room for improvement.', 0),
(3, NOW(), 'Alice', 'Johnson', 'The support team was very helpful and resolved my issue quickly.', 1),
(4, NOW(), 'Bob', 'Brown', 'I am not satisfied with the product quality.', 0),
(5, NOW(), 'Charlie', 'White', 'I highly recommend this service to everyone.', 1);
