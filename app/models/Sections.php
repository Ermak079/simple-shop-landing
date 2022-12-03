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
        $ps = ProductsSections::find('section_id = ' . $this->id);
        $products = [];
        foreach ($ps as $item){
            $prod = Products::findFirst('id =' . $item->product_id);
            $products [] = $prod;
        }
        $sp = SectionsPictures::findFirst('section_id =' . $this->id);
        $pictures = null;
        if ($sp){
            $pictures = Pictures::findFirst($sp->picture_id);
        }
        return [
            'name' => $this->name,
            'pictures' => $pictures,
            'products' => $products
        ];
    }

}
