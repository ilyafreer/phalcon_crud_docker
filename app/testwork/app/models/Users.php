<?php
namespace App\Models;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $did;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $family;

    /**
     *
     * @var string
     */
    public $patronymic;

    public function getSequenceName()
    {
        return 'users_did_seq';
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
//        $this->setSource("users");
        $this->setConnectionService('db');
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
