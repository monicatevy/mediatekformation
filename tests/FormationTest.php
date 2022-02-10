<?php
namespace app\tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Formation;

/**
 * Description of FormationTest
 *
 * @author monicatevy
 */
class FormationTest extends TestCase {
    
    public function testGetPublishedAtString(){
        $formation = new Formation();
        $formation->setPublishedAt(new \DateTime("2022-02-10"));
        $this->assertEquals("10/02/2022", $formation->getPublishedAtString());
    }
}
