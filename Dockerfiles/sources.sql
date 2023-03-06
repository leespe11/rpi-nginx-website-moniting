USE `updownio`;
CREATE TABLE IF NOT EXISTS `updownio`.`servers` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(32) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` varchar(64) NOT NULL,
  `OS` varchar(64) DEFAULT NULL,
  `DHCP` tinyint(1) DEFAULT 1,
  `description` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `vmip` varchar(32) DEFAULT NULL,
  `wakeonlan` varchar(128) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `updownio`.`users` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(64) NOT NULL,
  PRIMARY KEY (`userid`)
);

CREATE TABLE IF NOT EXISTS `updownio`.`subnets` (
  `value` int NOT NULL
);

-- LOGIN INFO -> admin:admin
-- SHA256 sum of password
INSERT INTO `updownio`.`users` VALUES (1,'admin','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918','admin');
-- CREATE USER 'jobber'@'docker_jobber_1.docker_space-net' IDENTIFIED BY 'jobber!@1001';
CREATE USER 'jobber'@'172.28.1.6' IDENTIFIED BY 'jobber!@1001';
-- GRANT select, update, insert ON updownio.* TO 'jobber'@'docker_jobber_1.docker_space-net';
GRANT select, update, insert ON `updownio`.* TO 'jobber'@'172.28.1.6';
-- GRANT ALL PRIVILEGES ON *.* TO 'jobber'@'docker_jobber_1.docker_space-net' IDENTIFIED BY 'jobber!@1001' WITH GRANT OPTION;
-- GRANT ALL PRIVILEGES ON *.* TO 'jobber'@'172.28.1.6' IDENTIFIED BY 'jobber!@1001' WITH GRANT OPTION;