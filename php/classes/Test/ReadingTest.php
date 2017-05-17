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
	 * test inserting a valid Reading that already exists
	 * @expectedException \PDOException
	 **/



    /**
     * test inserting a valid Valid_sennsordatetime
     */

    public function testGetValidReadingBySensorValue() : void {
        //count the number of rows and save it for later

        $numRows = $this->getConnection()->getRowCount("reading");

        //grab the data from mySQL and enforce the fields math our expectations
        $results = ReadingTest::getReadingBySensorValue($this->getPDO(),$reading->getSensorValue());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $this->assertCount(1, $results);

        //enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\pi-mirror\\ReadingTest", $results);

        //grab the result from the array and validate it
        $pdoReadingTest = $results(0);
        $this->assertEquals($pdoReadingTest->getSensorValue(), $this->VALID_SENSORVALUE);
        //format the date too seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoReadingTest->getSensorDateTime()->getTimeStamp(), $this->VALID_SENSORDATETIME->getTimestamp());

    }

    /**
     * test grabbing a valid Tweet by sunset and sunrise date
     *
     */

    public function testGetValidSensorByDate(): void {
        //count num of rows
        $numRows= $this->getConnection()->getRowCount('reading');

        $reading = new ReadingTest(null, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
            $reading->insert($this->getPDO());

        $results = ReadingTest::getReadingByReadingDate($this->PDO(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $this->assertCount(1, $results);

        //enforce that no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\pi-mirrors\\Reading", $results);

        //use the first result to make sure that the inserted meets expectations

        $pdoReading = $results[0];
        $this->assertEquals($pdoReading->getReadingId(), $reading->getReadingTestId());
        $this->assertEquals($pdoReading->getSensorValue(), $reading->getSensorValue());
        $this->assertEquals($pdoReading->getReadingDate()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
    }

}