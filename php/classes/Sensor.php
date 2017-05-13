<?php
namespace Edu\Cnm\PiMirror;
require_once("autoload.php");
/**
 * Pi Mirror Sensor profile
 *
 * @author Shihlin Lu <slu5@cnm.edu>
 * @version 1.0.0
 **/
class Sensor implements \JsonSerializable {
	/**
	 * id for this Sensor; this is the primary key
	 * @var int $sensorId;
	 **/
	private $sensorId;
	/**
	 * measurement unit for this Sensor
	 * @var string $sensorUnit;
	 **/
	private $sensorUnit;
	/**
	 * actual content in text format that describes this Sensor
	 * @var string $sensorDescription
	 **/
	private $sensorDescription;

/**
 * constructor for this Sensor
 *
 * @param int|null $newSensorId id of this Sensor or null if new sensor
 * @param string $newSensorUnit string containing measurement unit of this Sensor
 * @param string $newSensorDescription string containing actual content data of this Sensor
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers, negative floats)
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 * @documentation https://php.net/manual/en/language.oop5.decon.php
 **/
	public function __construct(?int $newSensorId, string $newSensorUnit, string $newSensorDescription) {
		try {
			$this->setSensorId($newSensorId);
			$this->setSensorUnit($newSensorUnit);
			$this->setSensorDescription($newSensorDescription);
		} // determine what exception was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for sensor id
	 *
	 * @return int|null value of sensor id
	 */
	public function getSensorId(): ?int {
		return($this->sensorId);
	}
	/**
	 * mutator method for sensor id
	 *
	 * @param int|null $newSensorId new value of Sensor id
	 * @throws \RangeException if $newSensorId is not positive
	 * @throws \TypeError if $newSensorId is not an integer
	 **/
	public function setSensorId(?int $newSensorId): void {
		// if sensor id is null immediately return it
		if($newSensorId === null) {
			$this->sensorId = null;
			return;
		}

		// verify the profile id is positive
		if($newSensorId <= 0) {
			throw(new \RangeException("sensor id is not positive"));
		}

		// convert and store the sensor id
		$this->sensorId = $newSensorId;
	}
	/**
	 * accessor method for sensor unit
	 *
	 * @return string value of sensor unit--this is the measurement (e.g., PPM, %, celsius)
	 */
	public function getSensorUnit(): string {
		return($this->sensorUnit);
	}
	/**
	 * mutator method for sensor unit
	 *
	 * @param string $newSensorUnit new value of sensor unit
	 * @throws \InvalidArgumentException if $newSensorUnit is not a string or insecure
	 * @throws \RangeException if $newSensorUnit is not exactly 8 characters
	 * @throws \TypeError if $newSensorUnit is not a string
	 **/
	public function setSensorUnit(string $newSensorUnit): void {
		// verify that the sensor unit is secure
		$newSensorUnit = trim($newSensorUnit);
		/**
		 * need to ensure that the following is the correct filter (only filter that allows %)
		 */
		$newSensorUnit = filter_var($newSensorUnit, FILTER_SANITIZE_URL);
		if(empty($newSensorUnit) === true) {
			throw(new \InvalidArgumentException("unit is empty or insecure"));
		}

		// verify the sensor unit will fit in the database
		if(strlen($newSensorUnit) > 8) {
			throw(new \RangeException("sensor unit is too large"));
		}

		// store the sensor unit
		$this->sensorUnit = $newSensorUnit;
	}
	/**
	 * accessor method for sensor description
	 *
	 * @return string value of sensor description
	 **/
	public function getSensorDescription() : string {
		return($this->sensorDescription);
	}
	/**
	 * mutator method for sensor description
	 *
	 * @param string $newSensorDescription new value of sensor description
	 * @throws \InvalidArgumentException if $newSensorDescription is not a string or insecure
	 * @throws \RangeException if $newSensorDescription is not exactly 32 characters
	 * @throws \TypeError if $newSensorDescription is not a string
	 **/
	public function setSensorDescription(string $newSensorDescription): void {
		// verify that the sensor description is secure
		$newSensorDescription = trim($newSensorDescription);
		$newSensorDescription = filter_var($newSensorDescription, FILTER_SANTIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newSensorDescription) === true) {
			throw(new \InvalidArgumentException("description is empty or insecure"));
		}

		// verify that the sensor description will fit in the database
		if(strlen($newSensorDescription) > 32) {
			throw(new \RangeException("sensor description is too large"));
		}

		// store the sensor description
		$this->sensorDescription = $newSensorDescription;
	}

	/**
	 * inserts this Sensor into mySQL
	 *
	 * @param \PDO $pdo PDO connection obejct
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		// enforce the sensorId is null (i.e., don't insert a sensor that already exists)
		if($this->sensorId !== null) {
			throw(new \PDOException("not a new sensor"));
		}

		//create query template
		$query = "INSERT INTO sensor(sensorId, sensorUnit, sensorDescription) VALUES(:sensorId, :sensorUnit, :sensorDescription)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["sensorId" => $this->sensorId, "sensorUnit" => $this->sensorUnit, "sensorDescription" => $this->sensorDescription];
		$statement->execute($parameters);

		// update the null sensorId with mySQL just gave us
		$this->sensorId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this Sensor from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the sensorId is not null (i.e., don't delete a sensor that hasn't been inserted)
		if($this->sensorId === null) {
			throw(new \PDOException("unable to delete a sensor that does not exist"));
		}

		//create query template
		$query = "DELETE FROM sensor WHERE sensorId = :sensorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["sensorId" => $this->sensorId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Sensor in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) : void {
		// enforce the sensorId is not null (i.e., don't update a sensor that hasn't been inserted)
		if($this->sensorId === null) {
			throw(new \PDOException("unable to update a sensor that does not exist"));
		}

		// create query template
		$query = "UPDATE sensor SET sensorUnit = :sensorUnit, sensorDescription = :sensorDescription WHERE sensorId = :sensorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["sensorUnit" => $this->sensorUnit, "sensorDescription" => $this->sensorDescription];
		$statement->execute($parameters);
	}

	/**
	 * get Sensor by sensor id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $sensorId sensor id to search for
	 * @return Sensor|null Sensor or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getSensorBySensorId(\PDO $pdo, int $sensorId) :
	?Sensor {
		// sanitize the sensor id before searching
		if($sensorId <= 0) {
			throw(new \PDOException("sensor id is not positive"));
		}

		// create query template
		$query = "SELECT sensorId, sensorUnit, sensorDescription FROM sensor WHERE sensorId = :sensorId";
		$statement = $pdo->prepare($query);

		// bind the sensor id to the place holder in the template
		$parameters = ["sensorId" => $sensorId];
		$statement->execute($parameters);

		// grab the Sensor from my SQL
		try {
			$sensor = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$sensor = new Sensor($row["sensorId"], $row["sensorUnit"], $row["sensorDescription"]);
			}
		} catch (\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($sensor);
	}

	/**
	 * gets all Sensors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray of all sensors found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllSensors(\PDO $pdo) : \SplFixedArray {
		// create query template
		$query = "SELECT sensorId, sensorUnit, sensorDescription FROM sensor";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of all sensors
		$sensors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$sensor = new Sensor($row["sensorId"], $row["sensorUnit"], $row["sensorDescription"]);
				$sensors[$sensors->key()] = $sensor;
				$sensors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($sensors);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}