<?php
namespace Edu\Cnm\PiMirror\Test;

use Edu\Cnm\PiMirror\{Sensor, Reading};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * FULL PHPUnit test for the Reading class
 *
 * This is a complete PHPUnit test for the Sensor class. It is complete because all mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Reading
 * @author Luc Flynn <lflynn7@cnm.edu>
 * @author Shihlin Lu <slu5@cnm.edu>
 **/
class ReadingTest extends SensorTest {
	/**
	 * Sensor that created the Reading; this is for foreign key relations
	 * @var Sensor sensor
	 **/
	protected $sensor = null;

    /**
     * valid reading unit to use
     * @var int $VALID_SENSORVALUE
     **/
    protected $VALID_SENSORVALUE = 123456789101112.123456;

    /**
     * timestamp of the Reading; this starts as null and is assigned later
     * @var \DateTime $VALID_SENSORDATETIME
     **/

    protected $VALID_SENSORDATETIME = null;

	/**
	 * valid timestamp to use as sunriseReadingDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * valid timestamp to use as sunsetReadingDate
	 **/
	protected $VALID_SUNSETDATE = null;

	/**
	 * test inserting a valid Reading and verify that the actual mySQL data matches
	 */
	public function testInsertValidReading() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("reading");

		// create a new Reading and insert it into mySQL
		$reading = new Reading(null, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
		$this->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoReading = Reading::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
		$this->assertEquals($pdoReading->getReadingSensorId(), $this->sensor->getSensorId());
		$this->assertEquals($pdoReading->getSensorValue(), $this->VALID_SENSORVALUE);
		$this->assertEquals($pdoReading->getSensorDateTime()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
	}

    /**
     * test inserting a valid Valid_sennsordatetime
     */

    public function testInsertValidReading(): void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("reading");

        // create a new Sensor and insert into mySQL
        $reading = new reading(null, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);

        // var_dump($sensor);

        $reading->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoReading = Reading::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
        $this->assertEquals($numRows +1, $this->getConnection()->getRowCount("sensor"));
        $this->assertEquals($pdoSensor->getSensorUnit(), $this->VALID_SENSORUNIT);
        $this->assertEquals($pdoSensor->getSensorDescription(), $this->VALID_SENSORDESCRIPTION);
    }

    /**
     *
     * test inserting a Sensor that already exists
     *
     * @expectedException \PDOException
     **/
    public function testInsertInvalidSensor() : void {
        // create a sensor with a non null sensorId and watch it fail
        $sensor = new Sensor(PiMirrorTest::INVALID_KEY, $this->VALID_SENSORUNIT, $this->VALID_SENSORDESCRIPTION);
        $sensor->insert($this->getPDO());
    }

    /**
     * test insert a Sensor, editing it, and then updating it
     **/
    public function testUpdateValidSensor() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("sensor");

        // create a new Sensor and insert into mySQL
        $sensor = new Sensor(null, $this->VALID_SENSORUNIT, $this->VALID_SENSORDESCRIPTION);
        $sensor->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoSensor = Sensor::getSensorBySensorId($this->getPDO(), $sensor->getSensorId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sensor"));
        $this->assertEquals($pdoSensor->getSensorUnit(), $this->VALID_SENSORUNIT);
        $this->assertEquals($pdoSensor->getSensorDescription(), $this->VALID_SENSORDESCRIPTION);
    }

    /**
     * test updating a Sensor that does not exist
     *
     * @expectedException \PDOException
     **/
    public function testUpdateInvalidSensor() {
        // create a Sensor and try to update it without actually inserting it
        $sensor = new Sensor(null, $this->VALID_SENSORUNIT, $this->VALID_SENSORDESCRIPTION);
        $sensor->update($this->getPDO());
    }

    /**
     * test creating a Sensor and then deleting it
     **/
    public function testDeleteValidSensor() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("sensor");

        // create a new Sensor and insert into mySQL
        $sensor = new Sensor(null, $this->VALID_SENSORUNIT, $this->VALID_SENSORDESCRIPTION);
        $sensor->insert($this->getPDO());

        // delete the Sensor from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sensor"));
        $sensor->insert($this->getPDO());

        // grab the data from mySQL and enforce the Sensor does not exist
        $pdoSensor = Sensor::getSensorBySensorId($this->getPDO(), $sensor->getSensorId());
        $this->assertNull($pdoSensor);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("sensor"));
    }

    /**
     * test deleting a Sensor that does not exist
     *
     * @expectedException \PDOException
     **/
    public function testDeleteInvalidSensor(): void {
        // create a Sensor and try to delete it without acutally inserting it
        $sensor = new Sensor(null, $this->VALID_SENSORUNIT, $this->VALID_SENSORDESCRIPTION);
        $sensor->delete($this->getPDO());
    }

    /**
     * test inserting a Sensor and regrabbing it from mySQL
     **/
    public function testGetValidSensorBySensorId() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("sensor");

        // create a new Sensor and insert into mySQL
        $sensor = new Sensor(null, $this->VALID_SENSORUNIT, $this->VALID_SENSORDESCRIPTION);
        $sensor->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoSensor = Sensor::getSensorBySensorId($this->getPDO(), $sensor->getSensorId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sensor"));
        $this->assertEquals($pdoSensor->getSensorUnit(), $this->VALID_SENSORUNIT);
        $this->assertEquals($pdoSensor->getSensorDescription(), $this->VALID_SENSORDESCRIPTION);
    }

    /**
     * test grabbing a Sensor that does not exist
     **/
    public function testGetInvalidSensorBySensorId() : void {
        // grab a sensor id that exceeds the maximum allowable sensor id
        $sensor = Sensor::getSensorBySensorId($this->getPDO(), PiMirrorTest::INVALID_KEY);
        $this->assertNull($sensor);
    }
}