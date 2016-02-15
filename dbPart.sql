-- http://www.formget.com/ajax-image-upload-php/
-- https://www.youtube.com/watch?v=tufJwoQ0Xuo
-- http://stackoverflow.com/questions/3748/storing-images-in-db-yea-or-nay
-- http://www.w3schools.com/php/php_file_upload.asp

DROP DATABASE dbPart;
CREATE DATABASE IF NOT EXISTS dbPart;
USE dbPart;
-- tbPart
CREATE TABLE tbType (
	id 			INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	type 		VARCHAR(4),
	descr 		VARCHAR(255)
) DEFAULT CHARSET=utf8 ENGINE=InnoDB;
-- tbSupplier
CREATE TABLE tbSupplier (
	id 			INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	company 	VARCHAR(255), 
	contact 	VARCHAR(255), 
	address1 	VARCHAR(255),
	address2 	VARCHAR(255),
	city 		VARCHAR(255),
	state 		VARCHAR(255),
	country		VARCHAR(255),
	postcode 	VARCHAR(255),
	phone 		VARCHAR(30),
	mobile		VARCHAR(30),
	fax 		VARCHAR(30),
	email 		VARCHAR(255),
	www 		VARCHAR(255),
	active		BOOLEAN DEFAULT TRUE
) DEFAULT CHARSET=utf8 ENGINE=InnoDB;
-- tbPart
CREATE TABLE tbPart (
	id				INT NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE,
	-- prefix			CHAR(1) NOT NULL, -- forget this idea duplicate info prefix is just extension of type!!
	-- part_number		VARCHAR(255) NOT NULL UNIQUE,
	descr			VARCHAR(255),
	image 			VARCHAR(255),
	-- typeid			INT,
	active			BOOLEAN DEFAULT TRUE
	-- FOREIGN KEY (typeid) REFERENCES tbType(id)
) DEFAULT CHARSET=utf8 ENGINE=InnoDB AUTO_INCREMENT=300000;
-- tbSupplierPart
CREATE TABLE tbSupplierPart (
--	id				INT NOT NULL AUTO_INCREMENT UNIQUE,
	supplierid		INT NOT NULL,
	partid			INT NOT NULL,
	sup_part_number VARCHAR(255),
	img 			varchar(255),
	FOREIGN KEY (supplierid) REFERENCES tbSupplier(id),
	FOREIGN KEY (partid) REFERENCES tbPart(id),
	PRIMARY KEY (supplierid, partid)
) DEFAULT CHARSET=utf8 ENGINE=InnoDB AUTO_INCREMENT=300000;
-- tbDrawing
CREATE TABLE tbDrawing (
	id				INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	partid			INT,
	drawing_number	VARCHAR(255) NOT NULL,
	rev				VARCHAR(3) DEFAULT '0',
	pdf				VARCHAR(255),
	dwg				VARCHAR(255),
	FOREIGN KEY (partid) REFERENCES tbPart(id)
) DEFAULT CHARSET=utf8 ENGINE=InnoDB;

CREATE TABLE tbCatergory (
	partid			INT NOT NULL,
	typeid			INT NOT NULL,
	FOREIGN KEY (partid) REFERENCES tbPart(id),
	FOREIGN KEY (typeid) REFERENCES tbType(id),
	PRIMARY KEY (partid, typeid)
) DEFAULT CHARSET=utf8 ENGINE=InnoDB;

CREATE TABLE tbUser (
    username    VARCHAR(255) NOT NULL,
    password    CHAR(32) NOT NULL,
    email       varchar(255),
    PRIMARY KEY (username, password)
) DEFAULT CHARSET=utf8 ENGINE=InnoDB;

INSERT INTO tbUser VALUES ('neas', md5(CONCAT('password', 'mickey mouse')), 'neas@transcrete.com');

-- #Fill Table with DATA
INSERT into tbType (type, descr) VALUES ('RAW', 'Raw material');
INSERT into tbType (type, descr) VALUES ('HYD', 'Hydraulic components');
INSERT into tbType (type, descr) VALUES ('ELE', 'Electrical components');
INSERT INTO tbType (type, descr) VALUES ('MEC', 'Mechanical components');
INSERT INTO tbType (type, descr) VALUES ('PUR', 'Purchased components');
INSERT into tbType (type, descr) VALUES ('POW', 'Truck, engine and PTO components');
INSERT into tbType (type, descr) VALUES ('SUB', 'Sub contract requirement');
INSERT into tbType (type, descr) VALUES ('CON', 'Consumable components');

INSERT INTO tbSupplier SET company = 'TRANSCRETE';

INSERT INTO tbSupplier SET company = 'ASHDOWNS';
INSERT INTO tbSupplier SET company = 'COLUSSI ENGINEERING';
INSERT INTO tbSupplier SET company = 'JTD ENGINEERING';
INSERT INTO tbSupplier SET company = 'POWERCLIPPER';
INSERT INTO tbSupplier SET company = 'PRINCE';


-- INSERT IGNORE INTO tbPart 
-- SET 
-- -- prefix = 'P',
-- -- SET part_number = CONCAT('P', 300000),
-- 	descr = 'RELAY CHANGE OVER  24V 30A 5 PIN',
-- 	image = 'img/300000.jpg';
-- 	-- typeid = '3';

-- INSERT IGNORE INTO tbPart 
-- SET 
-- -- prefix = 'P',
-- -- SET part_number = CONCAT('P', LAST_INSERT_ID() + 1),
-- 	descr = 'INTERPUMP WS202', 
-- 	-- typeid = '5';
-- 	image = 'img/300001.jpg';

-- INSERT IGNORE INTO tbPart 
-- SET 
-- -- prefix = 'P',
-- -- SET part_number = CONCAT('P', LAST_INSERT_ID() + 1),
-- -- SET part_number = '35T-301',
-- 	descr = 'TROJAN CLEVIS PIN (3/4")', 
-- 	image = 'img/300002.jpg';
-- 	-- typeid = '4';

-- INSERT IGNORE INTO tbPart 
-- SET 
-- -- prefix = 'P',
-- -- SET part_number = CONCAT('P', LAST_INSERT_ID() + 1),
-- -- SET part_number = 'T0055',
-- 	descr = 'TRUCK SIDE DECK SHEET', 
-- 	image = 'img/300003.jpg';
-- 	-- typeid = '1';



-- the below can be uncommented after js inserts partnumbers

-- INSERT IGNORE INTO tbSupplierPart (supplierid, partid, sup_part_number)
-- VALUES
-- (2, 300000,'0 332 209 203'),
-- (4, 300002, 'SEAOARD 19.05 PIN'),
-- (3, 300001, 'WS202'),
-- (5, 300002, 'HARDENED PIN 3/4'),
-- (1, 300002, '35T-301'),
-- (6, 300003, 'DECK SIDE SHEET');
	
-- INSERT INTO tbDrawing (partid, drawing_number, rev) 
-- VALUES 
-- (300002, '35T-301', 'A'),
-- (300003, 'T0055', 'B');

-- **** **** **** **** **** **** **** **** **** **** **** ****