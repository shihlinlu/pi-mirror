<?php
namespace Edu\Cnm\PiMirror\Test;

use Edu\Cnm\PiMirror\Sensor;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * FULL PHPUnit test for the Reading class
 *
 * This is a complete PHPUnit test for the Sensor class. It is complete because all mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Sensor
 * @author Luc Flynn <lflynn7@cnm.edu>
 **/
class ReadingTest extends PiMirrorTest {

    /**
     * valid reading unit to use
     * @var string $VALID_SENSORVALUE
     **/
    protected $VALID_SENSORVALUE = NULL;

    /**
     * valid reading DATETIME to use
     * @var string $VALID_SENSORDATETIME
     **/

    protected $VALID_SENSORDATETIME;

    /**
     * leaving $VALID_SENSORVALUE FOR LATER
     * -LUC
     */

    /**
     * test grabbing a valid Tweet by sunset and sunrise date
     *
     *
     *
     */

    public function testGetValidSensorByDate(): void {
        //count num of rows
        $numRows= $this->getConnection()->getRowCount('reading');

        $reading = new Reading(null, $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME)
            $reading->insert($this->getPDO());

        $results = Reading::getReadingByReadingDate($this->PDO(), $this->VALID_SENSORVALUE, $this->VALID_SENSORDATETIME);
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("reading"));
        $this->assertCount(1, $results);

        //enforce that no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\pi-mirrors\\Reading", $results);

        //use the first result to make sure that the inserted meets expectations

        $pdoReading = $results[0];
        $this->assertEquals($pdoReading->getReadingId(), $reading-getReadingId());
        $this->assertEquals($pdoReading->getSensorValue(), $reading-getSensorValue());
        $this->assertEquals($pdoReading->getReadingDate()->getTimestamp(), $this->VALID_SENSORDATETIME->getTimestamp());
    }

}