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
	 * id for the sensor reading
	 * @var int $readingId;
	 **/
	private $readingId;





















	public function jsonSerialize() {
		$fields = get_objects_vars($this);
		return($fields);
	}
}