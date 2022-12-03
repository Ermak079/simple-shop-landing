<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class SectionsPicturesMigration_100
 */
class SectionsPicturesMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {

    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        $sql = "CREATE TABLE `sections_pictures` (
	`section_id` INT(11) NOT NULL,
	`picture_id` INT(11) NOT NULL
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;
";
        self::$connection->execute($sql);

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
