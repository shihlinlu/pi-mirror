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
	 * formats the state variables for JSON serialization
	 *
	 * @return  array resulting state variables
	 */



	public function jsonSerialize() {
		$fields = get_objects_vars($this);
		return($fields);
	}
}