--  primary data stored in SQL is indoor air quality from Sensly HAT
DROP TABLE IF EXISTS reading;
DROP TABLE IF EXISTS sensor;

CREATE TABLE sensor (
	sensorId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	sensorUnit VARCHAR(8) NOT NULL,
	sensorDescription VARCHAR(32) NOT NULL,
	-- this declares the primary key for the entity
	PRIMARY KEY (sensorId)
);

CREATE TABLE reading (
	readingId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	readingSensorId INT UNSIGNED NOT NULL,
	sensorValue DECIMAL(12,6) NOT NULL,
	sensorDateTime TIMESTAMP(6) NOT NULL,
	INDEX (readingSensorId),
	FOREIGN KEY (readingSensorId) REFERENCES sensor(sensorId),
	PRIMARY KEY(readingId)
);
