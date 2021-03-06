DROP DATABASE IF EXISTS csis3280bcc;

CREATE DATABASE IF NOT EXISTS csis3280bcc;

USE csis3280bcc;

CREATE TABLE IF NOT EXISTS customer (
    customerId SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(12) NOT NULL
	) ENGINE = INNODB;
	
CREATE TABLE IF NOT EXISTS item (
    itemId SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	description VARCHAR(100) NOT NULL,
	price DECIMAL(8,2) NOT NULL
	) ENGINE = INNODB;	
	
	
CREATE TABLE IF NOT EXISTS orders (
    orderId SMALLINT NOT NULL,
	customerId SMALLINT NOT NULL,
	itemId SMALLINT NOT NULL,
	qtty  SMALLINT NOT NULL,
	total  DECIMAL(8,2) NOT NULL,
	PRIMARY KEY(orderId, itemId),
	FOREIGN KEY (customerId)
        REFERENCES customer(customerId),
    FOREIGN KEY (itemId)
        REFERENCES item(itemId)		
	) ENGINE = INNODB;
	
	

	
	
	
	