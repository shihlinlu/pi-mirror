--  primary data stored in SQL is indoor air quality from Sensly HAT
DROP TABLE IF EXISTS environment;
DROP TABLE IF EXISTS reading;

CREATE TABLE sensor (
	sensorId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	sensorUnit VARCHAR(50) NOT NULL,
	sensorDescription VARCHAR(200) NOT NULL,
	-- this declares the primary key for the entity
	PRIMARY KEY (sensorId)
);

CREATE TABLE reading (
	readingId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	readingSensorId INT UNSIGNED NOT NULL,
	sensorValue DECIMAL(12,6) NOT NULL,
	sensorDateTime DATETIME NOT NULL,
	INDEX (readingSensorId),
	FOREIGN KEY (readingSensorId) REFERENCES sensor(sensorId),
	PRIMARY KEY(readingId)

);
