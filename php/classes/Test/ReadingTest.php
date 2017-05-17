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
		$reading = new Reading(null, $this->reading->getReadingId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
		$this->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoReading = Reading::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
		$this->assertEquals($pdoReading->getReadingSensorId(), $this->sensor->geSensorId());
		$this->assertEquals($pdoReading->getSensorValue(), $this->VALID_SENSORVALUE);
		$this->assertEquals($pdoReading->getSensorDateTime()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
	}

    /**
     *
     * test inserting a Reading that already exists
     *
     * @expectedException \PDOException
     **/
    public function testInsertInvalidReading() : void {
        // create a reading with a non null sensorId and watch it fail
        $reading = new ReadingTest(PiMirrorTest::INVALID_KEY, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->insert($this->getPDO());
    }

    /**
     * test insert a Reading, editing it, and then updating it
     **/
    public function testUpdateValidReading() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("reading");

        // create a new Sensor and insert into mySQL
        $reading = new Reading(null, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATE);
        $reading->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoReading = Sensor::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $this->assertEquals($pdoReading->getSensorValue(), $this->VALID_SENSORVALUE);
        $this->assertEquals($pdoReading->getSensorDateTime(), $this->VALID_SENSORDATETIME);
    }

    /**
     * test updating a Reading that does not exist
     *
     * @expectedException \PDOException
     **/
    public function testUpdateInvalidReading() {
        // create a Sensor and try to update it without actually inserting it
        $reading = new Reading(null, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->update($this->getPDO());
    }

    /**
     * test creating a Reading and then deleting it
     **/
    public function testDeleteValidReading() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("reading");

        // create a new Sensor and insert into mySQL
        $reading = new Sensor(null, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->insert($this->getPDO());

        // delete the Sensor from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $reading->insert($this->getPDO());

        // grab the data from mySQL and enforce the Sensor does not exist
        $pdoReading = Reading::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
        $this->assertNull($pdoReading);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("reading"));
    }

    /**
     * test deleting a Reading that does not exist
     *
     * @expectedException \PDOException
     **/
    public function testDeleteInvalidReading(): void {
        // create a Sensor and try to delete it without acutally inserting it
        $reading = new Reading(null, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->delete($this->getPDO());
    }

    /**
     * test inserting a reading and regrabbing it from mySQL
     **/
    public function testGetValidReadingByReadingId() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("reading");

        // create a new Sensor and insert into mySQL
        $reading = new Reading(null, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoReading = Reading::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $this->assertEquals($pdoReading->getSensorValue(), $this->VALID_SENSORVALUE);
        $this->assertEquals($pdoReading->getSensorDateTime(), $this->VALID_SENSORDATETIME);
    }

    /**
     * test grabbing a Reading that does not exist
     **/
    public function testGetInvalidReadingByReadingId() : void {
        // grab a sensor id that exceeds the maximum allowable sensor id
        $reading = Sensor::getReadingByReadingId($this->getPDO(), PiMirrorTest::INVALID_KEY);
        $this->assertNull($reading);
    }
}