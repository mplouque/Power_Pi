USE `capstone_pi_readings`;

DROP TABLE IF EXISTS `data`;

CREATE TABLE `data` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`amps` float(7,4) NOT NULL,
	`watts` float(7,4) NOT NULL,
	`wattHours` float(21,4) NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `power_load`;

CREATE TABLE `power_load` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`state` varchar(10) NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);

