<?php



class Products extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var double
     */
    public $price;

    /**
     *
     * @var string
     */
    public $count;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {

    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'products';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Products[]|Products|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Products|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function toApi()
    {
        $pp = ProductsPictures::findFirst('product_id =' . $this->id);
        $pictures = null;
        if ($pp){
            $pictures = Pictures::findFirst($pp->picture_id);
            $pictures = $pictures->file_name;
        }
        return [
            'name' => $this->name,
            'photo' => $pictures,
            'cost' => $this->price,
            'amount' =>$this->count
        ];
    }

}
