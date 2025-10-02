CREATE DATABASE IF NOT EXISTS `deputados_database`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON `deputados_database`.* TO 'user'@'%';
FLUSH PRIVILEGES;