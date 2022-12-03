<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ProductsSectionsMigration_200
 */
class ProductsSectionsMigration_200 extends Migration
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
        $sql = "CREATE TABLE `products_sections` (
	`product_id` INT(11) NOT NULL,
	`section_id` INT(11) NOT NULL
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
