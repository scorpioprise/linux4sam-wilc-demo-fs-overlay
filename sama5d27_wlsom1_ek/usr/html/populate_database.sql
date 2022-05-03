GRANT ALL PRIVILEGES ON *.* TO 'www-data'@'localhost' IDENTIFIED VIA unix_socket;

DROP DATABASE IF EXISTS wallbox;
CREATE DATABASE wallbox;
use wallbox;

# #################### TABLE CARDS ##########################
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_no` varchar(50) NOT NULL,
  `name` text DEFAULT NULL,
  `tempo` datetime DEFAULT current_timestamp(),
  `status` tinytext DEFAULT 'checked',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_no` (`card_no`)
);


# ###################  TABLE USERS ###########################
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tempo` datetime DEFAULT current_timestamp(),
  `auth` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `id` (`id`,`username`)
);
INSERT INTO `users`(`username`, `password`, `auth`) VALUES ('admin', '$2y$10$dW0ohdRh9ZnAp3Cg8XnofuCB9dFet57lpZWACNG4MpHt5l/i2dDKy', '0'); INSERT INTO `users`(`username`, `password`, `auth`) VALUES ('installer', '$2y$10$qjvVWD0gNabdrGzn5Y//6eHNVZ7yw.0L4EKOs4Tj5tLOnPcLPR4Gi', '1'); INSERT INTO `users`(`username`, `password`, `auth`) VALUES ('user', '$2y$10$TN/KCwotAhKsVJ8vSIuxR.vixTMtC1ME0.UlZs/ZasbCXNeLjPbZm', '2');

# ################### TABLE TRANSACTION ######################
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tempo` datetime DEFAULT current_timestamp(),
  `card_no` int(10) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration` int(10) DEFAULT NULL,
  `delivered_kwh` int(10) DEFAULT NULL,
  `error` varchar(20) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `card_no` (`card_no`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`card_no`) REFERENCES `cards` (`card_no`) 
);

##################### TABLE CONFIGURATION ####################
CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `description` varchar(600) DEFAULT NULL,
  `visibility` int(11) DEFAULT 2,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`)
);

##################### TABLE ERRORS ####################
CREATE TABLE IF NOT EXISTS `errors` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `date` datetime NOT NULL DEFAULT current_timestamp(),
 `value` varchar(100) NOT NULL,
 `severity` varchar(50) NOT NULL,
 `parameter` int(10) NOT NULL,
 PRIMARY KEY (`id`)
);

system echo "================ table USERS ================";
describe users;
system echo "================ table CARDS ================";
describe cards;
system echo "================ table TRANSACTIONS ================";
describe transactions;
system echo "================ table ERRORS ================";
describe errors;

