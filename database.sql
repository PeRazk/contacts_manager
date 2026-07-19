DROP TABLE IF EXISTS `contacts`;
DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `color` VARCHAR(7) NOT NULL DEFAULT '#6C757D'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `contacts` (
`id` INT AUTO_INCREMENT PRIMARY KEY,
    `last_name` VARCHAR(100) NOT NULL,
    `first_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    `job_title` VARCHAR(100) NOT NULL,
    `department_id` INT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `departments` (`name`, `color`) VALUES
('Administration', '#6C757D'),
('Commercial', '#65B32E'),
('Gestion de projet', '#F97316'),
('Développement', '#1599E6'),
('Webdesign / UI-UX', '#A855F7'),
('Marketing & Communication', '#EC4899');

INSERT INTO `contacts` (`first_name`, `last_name`, `email`, `phone`, `job_title`, `department_id`) VALUES
('Darlene', 'Robinson', 'darlene@workagency.com', '0612345678', 'Cheffe de projet', 3),
('Jacob', 'Jones', 'jacob@workagency.com', '0687654321', 'Directeur des ventes', 2),
('Diane', 'Cooper', 'diane@workagency.com', '0745128963', 'Designer UX/UI', 5),
('Ronald', 'Richards', 'ronald@workagency.com', '0642536475', 'Développeur fullstack', 4),
('Jenny', 'Wilson', 'jenny@workagency.com', NULL, 'Assistante de direction', 1),
('James', 'Thompson', 'james@workagency.com', '0764534275', 'Chargé de communication', 6);
