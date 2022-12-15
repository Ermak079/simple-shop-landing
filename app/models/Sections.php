<?php



class Sections extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $picture_id;

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
        return 'sections';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sections[]|Sections|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sections|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function toApi()
    {
        $products = Products::find([
            'section_id =' . $this->id
        ]);
        $res = [];

        foreach ($products as $product)
        {
            $res[] = $product->toApi();
        }
        $pictures = null;
        if ($this->picture_id){
            $pictures = Pictures::findFirst("id = " . $this->picture_id);
            $pictures = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/img/' . $pictures->file_name;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'background' => $pictures,
            'goods' => $res
        ];
    }

}
