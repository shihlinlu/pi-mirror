-- primary data stored in SQL is indoor air quality from Sensly HAT
DROP TABLE IF EXISTS environment;

CREATE TABLE environment (
	environmentId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	environmentName VARCHAR(50) NOT NULL,
	environmentDescription VARCHAR(1000) NOT NULL,
	environmentTemperature DECIMAL(2,2) NOT NULL,
	environmentHumidity DECIMAL(2,2) NOT NULL,
	environmentPressure DECIMAL(2,2) NOT NULL,
	environmentCO DECIMAL(5,2) NOT NULL,
	environmentAmmonia DECIMAL (5,2) NOT NULL,
	environmentCO2 DECIMAL (5,2) NOT NULL,
	environmentLPG DECIMAL (5,2) NOT NULL,
	environmentPropane DECIMAL (5,2) NOT NULL,
	environmentPM DECIMAL (5,2) NOT NULL,
	environmentEthanol DECIMAL (5,2) NOT NULL,
	environmentHydrogen DECIMAL (5,2) NOT NULL,
	environmentMethane DECIMAL (5,2) NOT NULL,
	environmentAcetone DECIMAL (5,2) NOT NULL,
	environmentMethyl DECIMAL (5,2) NOT NULL,
	UNIQUE(environmentName),
	-- this declares the primary key for the entity
	PRIMARY KEY (environmentId)
);
