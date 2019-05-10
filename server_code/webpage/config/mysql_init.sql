DROP DATABASE IF EXISTS `capstone_login`;
CREATE DATABASE capstone_login;
CREATE user 'capstone_login'@'localhost' IDENTIFIED BY 'capstone_login';
GRANT ALL PRIVILEGES ON capstone_login.* TO 'capstone_login'@'localhost';
