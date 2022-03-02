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
  `card_no` varchar(20) DEFAULT NULL,
  `wallbox_status` varchar(20) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `delivered_kwh` varchar(20) DEFAULT NULL,
  `error` varchar(20) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `card_no` (`card_no`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`card_no`) REFERENCES `cards` (`card_no`) );

##################### TABLE CONFIGURATION ####################
CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `owner` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`)
);


INSERT IGNORE INTO configuration VALUES(0,'minimum_current_available_vehicle','float','1.0','Ampere','dsp');
INSERT IGNORE INTO configuration VALUES(1,'minimum_available_power','float','300.0','Watt','dsp');
INSERT IGNORE INTO configuration VALUES(2,'rfid_validity_timeout','uint32_t','60000','msec','dsp');
INSERT IGNORE INTO configuration VALUES(3,'rfid_swipe_validity_timeout','uint32_t','3000','msec','dsp');
INSERT IGNORE INTO configuration VALUES(4,'userstop_short_press','uint16_t','500','msec','dsp');
INSERT IGNORE INTO configuration VALUES(5,'userstop_long_press','uint16_t','5000','msec','dsp');
INSERT IGNORE INTO configuration VALUES(6,'userstop_verylong_press','uint16_t','10000','msec','dsp');
INSERT IGNORE INTO configuration VALUES(7,'led_light_on_time','uint16_t','1000','msec','dsp');
INSERT IGNORE INTO configuration VALUES(8,'led_light_off_time','uint16_t','1000','msec','dsp');
INSERT IGNORE INTO configuration VALUES(9,'led_light_on_time_fast','uint16_t','150','msec','dsp');
INSERT IGNORE INTO configuration VALUES(10,'led_light_off_time_fast','uint16_t','150','msec','dsp');
INSERT IGNORE INTO configuration VALUES(11,'short_circuit_current','float','100','Ampere','dsp');
INSERT IGNORE INTO configuration VALUES(12,'enable_fixed_power_inhibit_mid','bool','false','','dsp');
INSERT IGNORE INTO configuration VALUES(13,'customer_username','string','','','microchip');
INSERT IGNORE INTO configuration VALUES(14,'customer_password','string','','','microchip');
INSERT IGNORE INTO configuration VALUES(15,'facility_configuration_id','int','0x40','','dsp');
INSERT IGNORE INTO configuration VALUES(16,'builder_name','string','','','microchip');
INSERT IGNORE INTO configuration VALUES(17,'facility_configuration','uint8_t','','facility_configuration','dsp');
INSERT IGNORE INTO configuration VALUES(18,'meter_power_rating','uint32_t','14000','Watt','dsp');
INSERT IGNORE INTO configuration VALUES(19,'modbus_address','int','','','microchip');
INSERT IGNORE INTO configuration VALUES(20,'activation_timestamp','uint32_t','','sec','dsp');
INSERT IGNORE INTO configuration VALUES(21,'language','string','it-IT','','microchip');
INSERT IGNORE INTO configuration VALUES(22,'polling_period_realtime_mqtt_data','int','5','sec','dsp');
INSERT IGNORE INTO configuration VALUES(23,'wallbox_type','uint8_t','0x80','tipologia_wallbox','dsp');
INSERT IGNORE INTO configuration VALUES(24,'wallbox_id','string','','','microchip');
INSERT IGNORE INTO configuration VALUES(25,'wallbox_serial_number','string','','','microchip');
INSERT IGNORE INTO configuration VALUES(26,'wallbox_rated_power','uint32_t','14000','Watt','dsp');
INSERT IGNORE INTO configuration VALUES(27,'max_temperature_on','float','60.0','celsius','dsp');
INSERT IGNORE INTO configuration VALUES(28,'min_temperature_off','float','40.0','celsius','dsp');
INSERT IGNORE INTO configuration VALUES(29,'min_voltage','float','180.0','Volt','dsp');
INSERT IGNORE INTO configuration VALUES(30,'max_voltage','float','280.0','Volt','dsp');
INSERT IGNORE INTO configuration VALUES(31,'wallbox_connection_timeout','int','','sec','microchip');
INSERT IGNORE INTO configuration VALUES(32,'wallbox_modbus_address','int','','','microchip');
INSERT IGNORE INTO configuration VALUES(33,'wallbox_ocpp_server_ip_address','uint32_t','','IP','microchip');
INSERT IGNORE INTO configuration VALUES(34,'wallbox_ocpp_ip_server_port','int','','IP','microchip');
INSERT IGNORE INTO configuration VALUES(35,'wallbox_ocpp_url_server','string','','url','microchip');

describe users;
describe configuration;
describe cards;
describe transactions;


