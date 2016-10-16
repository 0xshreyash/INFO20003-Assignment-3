DROP TABLE IF EXISTS `OrderLineItem`;

DROP TABLE IF EXISTS `Spatula`;

DROP TABLE IF EXISTS `Order`;

# Spatula table 
CREATE TABLE IF NOT EXISTS `Spatula`(
	`idSpatula` INT NOT NULL AUTO_INCREMENT, 
    `ProductName` VARCHAR(50) NOT NULL,
    `Type` ENUM('Food', 'Drugs', 'Paints', 'Plaster') NOT NULL,
    `Size` VARCHAR(50) NOT NULL,
    `Colour` VARCHAR(50) NOT NULL,
    `Price` DECIMAL(10, 2) NOT NULL, 
    `QuantityInStock` INT NOT NULL,
	PRIMARY KEY(`idSpatula`)
)ENGINE = InnoDB;

# Order Table
CREATE TABLE IF NOT EXISTS `Order` (
	`idOrder` INT NOT NULL AUTO_INCREMENT, 
    `RequestedTime` DATETIME NOT NULL, 
	`ResponsibleStaffMember` VARCHAR(100) NOT NULL,
    `CustomerData` VARCHAR(300) NOT NULL,
    PRIMARY KEY(`idOrder`)
)ENGINE = InnoDB;

# OrderLineItem associative entity
CREATE TABLE IF NOT EXISTS `OrderLineItem` (
	`idSpatula` INT NOT NULL,
    `idOrder` INT NOT NULL,
    `Quantity` INT NOT NULL, 
    PRIMARY KEY(`idSpatula`, `idOrder`),
    FOREIGN KEY (`idSpatula`)
    REFERENCES `Spatula` (`idSpatula`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
    FOREIGN KEY (`idOrder`)
    REFERENCES `Order` (`idOrder`)
    ON DELETE RESTRICT 
    ON UPDATE CASCADE
)ENGINE = InnoDB;


# dummy data
INSERT INTO `Spatula` 
(`ProductName`, `Type`, `Size`, `Colour`, `Price`, `QuantityInStock`) VALUES
	('S2', 'Food', '10', 'Black', 7.25, 21), 
    ('S4', 'Drugs', '12', 'Blue', 10.75, 40),
    ('S6', 'Paints', '14', 'Green', 14.00, 12),
    ('S8', 'Plaster', '16', 'Red', 8.5, 15),
    ('S10', 'Paints', '18', 'Golden', 6.5, 18),
    ('S12', 'Plaster', '16', 'Black', 12.25, 0),
    ('S14', 'Drugs', '14', 'Brown', 20.5, 0),
    ('S16', 'Food', '12', 'Violet', 13.50, 0),
    ('S18', 'Paints', '20', 'Pink', 15.25, 0),
    ('S20', 'Food', '10', 'Teal', 10.55, 0);

# check statements
SELECT * FROM `Spatula`;
SELECT * FROM `Order`; 
SELECT * FROM `OrderLineItem`;
    

    
    
	
	
