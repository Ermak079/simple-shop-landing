<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class PicturesMigration_100
 */
class PicturesMigration_100 extends Migration
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
        $sql = "CREATE TABLE `pictures` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`file_name` VARCHAR(100) NOT NULL DEFAULT '0' COLLATE 'utf8mb4_unicode_ci',
	`title` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`description` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;";
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
