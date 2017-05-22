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
class ReadingTest extends PiMirrorTest  {
	/**
	 * Sensor that created the Reading; this is for foreign key relations
	 * @var Sensor sensor
	 **/
	protected $sensor = null;

    /**
     * data content value of sensor
     * @var int $VALID_SENSORVALUE
     **/
    protected $VALID_SENSORVALUE = '101092.123';

	/**
	 * data content of updated Reading
	 */
	protected $VALID_SENSORVALUE2 = '212121.653';

    /**
     * timestamp of the Reading; this starts as null and is assigned later
     * @var \DateTime $VALID_SENSORDATETIME
     **/

    protected $VALID_SENSORDATETIME = null;

	/**
	 * Valid timestamp to use as sunriseReadingDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetReadingDate
	 */
	protected $VALID_SUNSETDATE =null;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() : void {
		//run the default  setUp() method first
		parent::setUp();

		//create and insert a Sensor to own the test Reading
		$this->sensor = new Sensor(null, "PPM", "Carbon Dioxide sensor");
		$this->sensor->insert($this->getPDO());

		//calculate the date (just use the time the unit test was setup)
		$this->VALID_SENSORDATETIME = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new \DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}


	/**
	 * test inserting a valid Reading and verify that the actual mySQL data matches
	 */
	public function testInsertValidReading(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("reading");

		// create a new Reading and insert it into mySQL
		$reading = new Reading(null, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
		$reading->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoReading = Reading::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
		$this->assertEquals($pdoReading->getReadingSensorId(), $this->sensor->getSensorId());
		$this->assertEquals($pdoReading->getSensorValue(), $this->VALID_SENSORVALUE);
		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoReading->getSensorDateTime()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
	}

    /**
     *
     * test inserting a Reading that already exists
     *
     * @expectedException \PDOException
     **/
    public function testInsertInvalidReading() : void {
        // create a Sensor with a non null sensorId and watch it fail
        $sensor = new Reading(PiMirrorTest::INVALID_KEY, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $sensor->insert($this->getPDO());
    }

    /**
     * test insert a Reading, editing it, and then updating it
     **/
    public function testUpdateValidReading(): void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("reading");

        // create a new Reading and insert into mySQL
        $reading = new Reading(null, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->insert($this->getPDO());

        // edit the Reading and update it in mySQL
		 $reading->setSensorValue($this->VALID_SENSORVALUE2);
		 $reading->update($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoReading = Reading::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $this->assertEquals($pdoReading->getReadingSensorId(), $this->sensor->getSensorId());
        $this->assertEquals($pdoReading->getSensorValue(), $this->VALID_SENSORVALUE2);
        $this->assertEquals($pdoReading->getSensorDateTime()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
    }

    /**
     * test updating a Reading that does not exist
     *
     * @expectedException \PDOException
     **/
    public function testUpdateInvalidReading() : void {
        // create a Reading with a non null reading id and watch it fail
        $reading = new Reading(null, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->update($this->getPDO());
    }

    /**
     * test creating a Reading and then deleting it
     **/
    public function testDeleteValidReading() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("reading");

        // create a new Reading and insert into mySQL
        $reading = new Reading(null,$this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->insert($this->getPDO());

        // delete the Reading from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $reading->delete($this->getPDO());

        // grab the data from mySQL and enforce the Reading does not exist
        $pdoReading = Reading::getReadingByReadingId($this->getPDO(), $reading->getReadingId());
        $this->assertNull($pdoReading);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("reading"));
    }

    /**
     * test deleting a Reading that does not exist
     *
     * @expectedException \PDOException
     **/
    public function testDeleteInvalidReading() : void {
        // create a reading and try to delete it without actually inserting it
        $reading = new Reading(null, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->delete($this->getPDO());
    }

	/**
	 * test grabbing a Reading by reading id that does not exist
	 */
	public function testGetInvalidReadingByReadingId() : void {
		// grab a sensor id that exceeds the maximum allowable sensor id
		$reading = Reading::getReadingByReadingId($this->getPDO(), PiMirrorTest::INVALID_KEY);
		$this->assertNull($reading);
	}

    /**
     * test inserting a reading and regrabbing it from mySQL
     **/
    public function testGetValidReadingByReadingSensorId() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("reading");

        // create a new reading and insert into mySQL
        $reading = new Reading(null, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $reading->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = Reading::getReadingByReadingSensorId($this->getPDO(), $reading->getReadingSensorId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PiMirror\\Reading", $results);

        // grab the result from the array and validate it
		 $pdoReading = $results[0];
		 $this->assertEquals($pdoReading->getReadingSensorId(), $this->sensor->getSensorId());
		 $this->assertEquals($pdoReading->getSensorValue(), $this->VALID_SENSORVALUE);
		 // format the date to seconds since the beginning of time to avoid round off error
		 $this->assertEquals($pdoReading->getSensorDateTime()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
    }

    /**
     * test grabbing a Reading by sensor id that does not exist
     **/
    public function testGetInvalidReadingByReadingSensorId() : void {
        // grab a sensor id that exceeds the maximum allowable sensor id
        $reading = Reading::getReadingByReadingSensorId($this->getPDO(), PiMirrorTest::INVALID_KEY);
        $this->assertCount(0, $reading);
    }
	/**
	 * test grabbing a valid Reading by sunset and sunrise date
	 **/
	public function testGetValidReadingBySunDate() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("reading");

		// create a new Reading and insert it into the database
		$reading = new Reading(null, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
		$reading->insert($this->getPDO());

		// grab the reading from the database and see if it matches expectations
		$results = Reading::getReadingBySensorDateTime($this->getPDO(), $this->VALID_SUNRISEDATE, $this->VALID_SUNSETDATE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
		$this->assertCount(1, $results);

		// enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PiMirror\\Reading", $results);

		// use the first result to make sure that the inserted reading meets expectations
		$pdoReading = $results[0];
		$this->assertEquals($pdoReading->getReadingId(), $reading->getReadingId());
		$this->assertEquals($pdoReading->getReadingSensorId(), $reading->getReadingSensorId());
		$this->assertEquals($pdoReading->getSensorValue(), $reading->getSensorValue());
		$this->assertEquals($pdoReading->getSensorDateTime()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
	}

    /**
     * test grabbing all Readings
     **/
    public function testGetAllValidReadings() : void {
    	// count the number of rows and save it for later
		 $numRows = $this->getConnection()->getRowCount("reading");

		 // create a new Reading and insert it into my SQL
		 $reading = new reading(null, $this->sensor->getSensorId(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
		 $reading->insert($this->getPDO());

		 // grab the data from mySQL and enforce the fields match our expectations
		 $results = Reading::getAllReadings($this->getPDO());
		 $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
		 $this->assertCount(1, $results);
		 $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PiMirror\\Reading", $results);

		 // grab the result from the array and validate it
		 $pdoReading= $results[0];
		 $this->assertEquals($pdoReading->getReadingSensorId(), $this->sensor->getSensorId());
		 $this->assertEquals($pdoReading->getSensorValue(), $this->VALID_SENSORVALUE);
		 //format the date too seconds since the beginning of time to avoid round off error
		 $this->assertEquals($pdoReading->getSensorDateTime()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
	 }
}