<?php
namespace Edu\Cnm\PiMirror;
require_once("autoload.php");
/**
 * Pi Mirror Reading profile
 *
 * @author dmartin61 <dmartin61@cnm.edu>
 * Edited by Shihlin Lu, Luc Flynn, and Tucker Logan
 * @version 1.0
 **/
class Reading implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for the sensor reading, primary key
	 * @var int $readingId;
	 **/
	private $readingId;
	/**
	 * the sensor from which the reading came from
	 * @var int $readingSensorId
	 **/
	private $readingSensorId;

	/**
	 * the value of the reading from the sensor
	 * 12 digits before the decimal
	 * and 6 digits after the decimal
	 * @var float $sensorValue
	 **/
	private $sensorValue;

	/**
	 * date and time of when the sensor's reading was recorded
	 * made for 6 digits
	 * @var \DateTime $sensorDateTime
	 **/
	private $sensorDateTime;

	/**
	 * constructor for this Reading
	 *
	 * @param int|null $newReadingId id of the reading or null if new reading
	 * @param int $newReadingSensorId id of the sensor where the reading came from
	 * @param float $newSensorValue Decimal value of the sensor reading
	 * @param \DateTime|string|null $newSensorDateTime date and time when the reading was taken
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., string too long, negative integers, negative floats)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

		public function __construct(?int $newReadingId, int $newReadingSensorId, float $newSensorValue, $newSensorDateTime = null) {
			try {
				$this->setReadingId($newReadingId);
				$this->setReadingSensorId($newReadingSensorId);
				$this->setSensorValue($newSensorValue);
				$this->setSensorDateTime($newSensorDateTime);
			}
			//determine what exception type was thrown
			catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
		}

	/**
	 * accessor method for reading id
	 * @return int|null value of reading id
	 **/
	public function getReadingId(): int {
		return($this->readingId);
	}

	/**
	 * mutator method for reading id
	 *
	 * @param int|null $newReadingId value of reading id
	 * @throws \RangeException if $newReadingId is not positive
	 * @throws \TypeError if $newReadingId is not an integer
	 **/
	public function setReadingId(?int $newReadingId): void {
		//if reading is null return immediately
		if($newReadingId === null) {
			$this->readingId = null;
			return;
		}
		//verify the reading id is positive
		if($newReadingId <=0) {
			throw(new \RangeException("reading id is not positive"));
		}
		// convert and strong the reading id
		$this->readingId = $newReadingId;
	}

	/**
	 * accessor method for reading sensor id
	 * @return int the sensor in which the reading came from
	 **/

	public function getReadingSensorId(): int {
		return($this->readingSensorId);
	}
	/**
	 * mutator method for reading sensor id
	 *
	 * @param int $newReadingSensorId value of the readingSensorId
	 * @throws \RangeException if $newReadingSensorId is not positive
	 * @throws \TypeError if $newReadingSensorId is not an integer
	 **/
public function setReadingSensorId(int $newReadingSensorId) : void {
	//if reading sensor id is null return immediately
	if($newReadingSensorId === null) {
		$this->readingId = null;
		return;
	}
	//verify the reading sensor id is positive
	if($newReadingSensorId <= 0 ) {
		throw(new \RangeException("reading sensor id is not positive"));
	}

	// convert and store the reading sensor id
	$this->readingSensorId = $newReadingSensorId;
}

	/**
	 * accessor method for sensor value
	 *
	 * @return int the data value from the sensor's reading
	 **/
public function getSensorValue() :int {
	return($this->sensorValue);
}
	/**
	 * mutator method for sensor value
	 *
	 *@param float $newSensorValue the value from the sensor's reading
	 *@throws \InvalidArgumentException if $newSensorValue in not an integer or insecure
	 *@throws \RangeException if $newSensorValue is not positive
	 *@throws \TypeError if $newSensorValue is not an integer
	 **/

	public function setSensorValue(float $newSensorValue) : void {
		//this a way to float the reading data coming in
		$newSensorValue = filter_var($newSensorValue, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if(empty($newSensorValue) === true) {
			throw(new \InvalidArgumentException("the data does not exist!"));
		}

		$this->sensorValue = $newSensorValue;
	}

	/**
	 * accessor method for sensor date time
	 *
	 * @return \DateTime value of sensorDateTime
	 **/
public function getSensorDateTime(): \DateTime {
	return($this->sensorDateTime);
}
	/**
	 * mutator method for sensor date time
	 *
	 * @param \DateTime|string|null $newSensorDateTime sensor date as a DateTime object or string (or null to load current time) for when we got this sensor reading
	 * @throws \InvalidArgumentException if $newSensorDateTime is not a valid object or string
	 * @throws \RangeException if $newSensorDateTime is a date that does not exist
	 **/
public function setSensorDateTime($newSensorDateTime = null) : void {
// if the date is null, use the current date and time
	if($newSensorDateTime === null) {
		$this->sensorDateTime = new \DateTime();
		return;
	}
// store the sensor reading date using the ValidateDate trait
	try {
		$newSensorDateTime = self::validateDateTime($newSensorDateTime);
	} catch(\InvalidArgumentException | \RangeException $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	$this->sensorDateTime = $newSensorDateTime;
	return;
}

	/**
	 * inserts this new sensor reading data from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors object
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
public function insert(\PDO $pdo) : void {
	//enforce the readingId is null (i.e., don't insert a reading that already exists)
	if($this->readingId !== null) {
		throw(new \PDOException("not a new reading"));
	}
	//create query template
	$query = "INSERT INTO reading(readingSensorId, sensorValue, sensorDateTime) VALUES(:readingSensorId, :sensorValue, :sensorDateTime)";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holder in the template
	$formattedDate = $this->sensorDateTime->format("Y-m-d H:i:s.u");
	$parameters = ["readingSensorId" => $this->readingSensorId, "sensorValue" => $this->sensorValue, "sensorDateTime" => $formattedDate];
	$statement->execute($parameters);

	// update the null readingId with what mySQL gave us
	$this->readingId = intval($pdo->lastInsertId());
}

	/**
	 * deletes this reading from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) : void {
		//enforce the readingId is not null
		if($this->readingId === null) {
				throw(new \PDOException("unable to delete a reading that does not exist"));
		}

		//create query template
		$query = "DELETE FROM reading WHERE readingId = :readingId";
		$statement = $pdo->prepare($query);

		//bind the member variables to te place holder in the template
		$parameters = ["readingId" => $this->readingId];
		$statement->execute($parameters);
	}

	/**
	 * updates this reading in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
public function update(\PDO $pdo): void {
	//enforce the readingId is not null (i.e., don't update reading that has not been inserted)
	if($this->readingId === null){
		throw(new \PDOException("unable to update a reading that does not exist"));
	}
	//create query template
	$query = "UPDATE reading SET readingSensorId = :readingSensorId, sensorValue = :sensorValue, sensorDateTime = :sensorDateTime WHERE readingId = :readingId";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holders in the template
	$formattedDate = $this->sensorDateTime->format("Y-m-d H:i:s.u");
	$parameters = ["readingSensorId" => $this->readingSensorId, "sensorValue" => $this->sensorValue, "sensorDateTime" => $formattedDate, "readingId" => $this->readingId];
	$statement->execute($parameters);
}

	/**
	 * gets the reading by the readingId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $readingId reading id to search for
	 * @return Reading|null Reading found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
public static function getReadingByReadingId(\PDO $pdo, int $readingId) : ?Reading {
	//sanitize the readingId before searching
	if($readingId <= 0) {
		throw(new \PDOException("reading id is not positive"));
	}

	//create query template
	$query = "SELECT readingId, readingSensorId, sensorValue, sensorDateTime FROM reading WHERE readingId = :readingId";
	$statement = $pdo->prepare($query);

	//bind the reading id to the place holder in the template
	$parameters = ["readingId" => $readingId];
	$statement->execute($parameters);

	//grab the reading from mySQL
	try{
		$reading = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$reading = new Reading($row["readingId"], $row["readingSensorId"], $row["sensorValue"], $row["sensorDateTime"]);
		}
	} catch(\Exception $exception){
		// if the row could not be converted rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($reading);
}
	/**
	 * gets the Reading by sensor id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $readingSensorId sensor id to search by
	 * @return \SplFixedArray SplFixedArray of Readings found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getReadingByReadingSensorId(\PDO $pdo, int $readingSensorId) : \SplFixedArray {
		// sanitize the sensor id before searching
		if($readingSensorId <= 0) {
			throw(new \RangeException("reading sensor id must be positive"));
		}
		// create query template
		$query = "SELECT readingId, readingSensorId, sensorValue, sensorDateTime FROM reading WHERE readingSensorId = :readingSensorId";
		$statement = $pdo->prepare($query);

		// bind the reading sensor id to the place holder in the template
		$parameters = ["readingSensorId" => $readingSensorId];
		$statement->execute($parameters);

		// build an array of readings
		$readings = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$reading = new Reading($row["readingId"], $row["readingSensorId"], $row["sensorValue"], $row["sensorDateTime"]);
				$readings[$readings->key()] = $reading;
				$readings->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($readings);
	}

	/**
	 * gets a reading by sensor value
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param float $sensorValue reading value to search for
	 * @return \SplFixedArray SplFixedArray of readings found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public static function getReadingBySensorValue(\PDO $pdo, float $sensorValue) : \SplFixedArray {
		// sanitize the value before searching
		$sensorValue = filter_var($sensorValue, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if(empty($sensorValue) === true) {
			throw(new \PDOException("value is invalid"));
		}

		// create query template
		$query = "SELECT readingId, readingSensorId, sensorValue, sensorDateTime FROM reading WHERE sensorValue = :sensorValue";
		$statement = $pdo->prepare($query);

		// bind the reading value to the place holder in the template
		$parameters = ["sensorValue" => $sensorValue];
		$statement->execute($parameters);

		// build an array of readings
		$readings = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$reading = new Reading($row["readingId"], $row["readingSensorId"], $row["sensorValue"], $row["sensorDateTime"]);
				$readings[$readings->key()] = $reading;
				$readings->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($readings);
	}

	/**
	 * gets an array of readings based on its data
	 *
	 * @param \PDO $pdo connection object
	 * @param \DateTime $sunriseReadingDate beginning date to search for
	 * @param \DateTime $sunsetReadingDate ending date to search for
	 * @return \SplFixedArray of readings found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct dates are in the wrong format
	 * @throws \InvalidArgumentException if either sun dates are in the wrong format
	 **/
public static function getReadingBySensorDateTime (\PDO $pdo, $sunriseReadingDate, $sunsetReadingDate ) : \SplFixedArray {
	//enforce both date are present
	if((empty ($sunriseReadingDate) === true) || (empty($sunsetReadingDate) === true)) {
		throw (new \InvalidArgumentException("dates are empty of insecure"));
	}
	//ensure both dates are in the correct format and are in the correct format and are secure
	try{
		$sunriseReadingDate = self::validateDateTime($sunsetReadingDate);
		$sunsetReadingDate = self::validateDateTime($sunriseReadingDate);

	} catch(\InvalidArgumentException | \RangeException $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	//create query template
	$query = "SELECT readingId, readingSensorId, sensorValue, sensorDateTime from reading WHERE sensorDateTime >= :sunriseReadingDate AND sensorDateTime <= :sunsetReadingDate";
	$statement= $pdo->prepare($query);

	//format the dates so that mySQL can use them
	$formattedSunriseDate = $sunriseReadingDate->format("Y-m-d H:i:s.u");
	$formattedSunsetDate = $sunsetReadingDate->format("Y-m-d H:i:s.u");

	$parameters = ["sunriseReadingDate" => $formattedSunriseDate, "sunsetReadingDate" => $formattedSunsetDate];
	$statement->execute($parameters);

	//build an array of readings
	$readings = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);

	while(($row = $statement->fetch()) !== false) {
		try{
			$reading = new Reading($row["readingId"], $row["readingSensorId"], $row["sensorValue"], $row["sensorDateTime"]);
			$readings[$readings->key()] = $reading;
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($readings);
}
	/**
 * get all Readings
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of readings found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 */
public static function getAllReadings(\PDO $pdo): \SPLFixedArray {
	//create query template
	$query = "SELECT readingId, readingSensorId, sensorValue, sensorDateTime FROM reading";
	$statement = $pdo->prepare($query);
	$statement->execute();

	//build an array of readings
	$readings = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try{
			$reading = new Reading($row["readingId"], $row["readingSensorId"], $row["sensorValue"], $row["sensorDateTime"]);
			$readings[$readings->key()] = $reading;
			$readings->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($readings);
}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//format the date so that the front end can consume it
		$fields["sensorDateTime"]= round(floatval($this->sensorDateTime->format("U.u"))* 1000);
		return($fields);
	}
}