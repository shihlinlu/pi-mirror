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

	/**
	 * mutator method for sensor id
	 *
	 * @param int|null $newSensorId new value of Sensor id
	 * @throws \RangeException if $newSensorId is not positive
	 * @throws \TypeError if $newSensorId is not an integer
	 **/

	/**
	 * accessor method for sensor unit
	 *
	 * @return string value of sensor unit--this is the measurement (e.g., PPM, %, celsius)
	 */

	/**
	 * mutator method for sensor unit
	 *
	 * @param string $newSensorUnit new value of sensor unit
	 * @throws \InvalidArgumentException if $newSensorUnit is not a string or insecure
	 * @throws \RangeException if $newSensorUnit is not exactly 8 characters
	 * @throws \TypeError if $newSensorUnit is not a string
	 **/

	/**
	 * accessor method for sensor description
	 *
	 * @return string value of sensor description
	 **/

	/**
	 * mutator method for sensor description
	 *
	 * @param string $newSensorDescription new value of sensor description
	 * @throws \InvalidArgumentException if $newSensorDescription is not a string or insecure
	 * @throws \RangeException if $newSensorDescription is not exactly 32 characters
	 * @throws \TypeError if $newSensorDescription is not a string
	 **/






	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}