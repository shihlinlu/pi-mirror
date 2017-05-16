<?php
namespace Edu\Cnm\PiMirror;
require_once("autoload.php");
/**
 * Pi Mirror Reading profile
 *
 * @author dmartin61 <dmartin61@cnm.edu>
 * @version 1.0
 **/
class Reading implements \JsonSerializable {

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
	 * @var int $sensorValue
	 **/
	private $sensorValue;

	/**
	 * timestamp of when the sensor's reading was recorded
	 * made fo 6 digits
	 * @var string $sensorDateTime
	 **/
	private $sensorDateTime;

	/**
	 * constructor for this Reading
	 *
	 * @param int|null $readingId id of the reading or null if new reading
	 * @param int|null $readingSensorId id of the sensor where the reading came from
	 * @param int|null $sensorValue Decimal value of the sensor reading
	 * @param string $sensorDateTime Timestamp when the reading was taken
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., string too long, negative integers, negative floats)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

		public function __construct(?int $newReadingId, ?int $newReadingSensorId, ?int $sensorValue, string $sensorDateTime) {
			try {
				$this->setReadingId($newReadingId);
				$this->setReadingSensorId($newReadingSensorId);
				$this->setSensorValue($newSensorValue);
				$this->sensorDateTime($newSensorDateTime);
			}
			catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
		}

	/**
	 * accessor method for reading id
	 * @return int|null value of reading id
	 **/
	public function getReadingId(): ?int {
		return($this->readingId);
	}

	/**
	 * Mutator method for reading id
	 *
	 * @param int|null $newReadingId value of reading id
	 * @throws \RangeException if $newReadingId is not positive
	 * @throws \TypeError if $newReadingId is not an integer
	 **/
	public function setReadingId(int $newReadingId): void {
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
	 * Accessor method for readingSensorId
	 * @return int the sensor in which the reading came from
	 **/

	public function getReadingSensorId(): int {
		return($this->readingSensorId);
	}
	/**
	 * mutator method
	 *
	 * @param int|null $newReadingSensorId value of the readingSensorId
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
	 * accessor method for sensorValueId
	 *
	 * @return int the data value from the sensor's reading
	 **/
public function getSensorValue(int $newSensorValue) {
	return($this->sensorValue);
}
	/**
	 * mutator method for sensor reading
	 *
	 *@param int|null $sensorValue the value from the sensor's reading
	 *@throws \RangeException if $newSensorValue is not positive
	 *@throws \TypeError if $newSensorValue is not an integer
	 **/

	public function setSensorValue(int $newSensorValue) : void {
//if reading is null return immediately
//(not sure if I need this because...
		//if I use php function intval(null) will return 0)
		//http://php.net/manual/en/function.intval.php
		//nevermind that was from 5 years ago before tha age of php 7
		//if($newSensorValue === null) {
			//$this->sensorValue = null;
			//return;
		//}

		//verify the sensor value is a positive integer
		//if($newSensorValue <= 0) {
			//throw(new \RangeException("sensor value is not a positive integer"));
		//}
		// can environment sensors read negative values ?

			// I'm just going to move on with my life
			//this is a solution to keeping the data value raw very bloody raw
		$newSensorValue = filter_var($newSensorValue, FILTER_VALIDATE_FLOAT);
		if(empty($newSensorValue) === true) {
			throw(new \InvalidArgumentException("the data does not exist!"));
		}

		$this->sensorValue = $newSensorValue;
	}

	/**
	 * Accessor method for timestamp
	 *
	 * @return string $newTimeStamp when the reading was taken
	 **/
public function getSensorDateTime(): string {
	return($this->sensorDateTime);
}
	/**
	 * mutator method for timestamp
	 *
	 * @param \DateTime|string|null $newTimeStamp
	 **/












	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return  array resulting state variables
	 */



	public function jsonSerialize() {
		$fields = get_objects_vars($this);
		return($fields);
	}
}