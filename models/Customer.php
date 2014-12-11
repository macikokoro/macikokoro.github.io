<?php
namespace app\models;
use lithium\data\Connections;

/**
 * Class Customer
 *
 * @property id
 * @property  string first_name
 * @property string  last_name
 * @property string email
 * @property string password
 * @property string password_hash
 * @property string profile_url
 * @property string type
 */
class Customer extends \lithium\data\Model{


    public function locations($id) {

        /* removes null or false values with array_filter() */
        $conditions = array_filter(array('id' => $companyid, 'state' => $state));

        /* pass $conditions array to the Locations model, find all, order by city */
        $locations = Customer::find('all', array(
            'conditions' => $conditions,
            'order' => array('city' => 'ASC')
        ));

        return compact('locations');

    }
    /**
     * @param $id
     * @return Customer
     * @throws \InvalidArgumentException
     */
    public static function findById($id){

        $db = Connections::get(Customer::meta('connection'));
        $records = $db->read('SELECT * FROM customers where id = ?',array($id));
        if (isset($records) && sizeof($records) == 1){
            $customer = json_decode(json_encode($records[0]), FALSE);
            return $customer;
        }

        throw new \InvalidArgumentException("We found more than 1 or 0 records ");
    }


    /**
     * @param $email
     * @return Customer
     */
    public static function findByEmail($email){
        $db = Connections::get(Customer::meta('connection'));
        $records = $db->read('SELECT * FROM customers where email = ?',array($email));
        if (isset($records) && sizeof($records) == 1){
            $customer = json_decode(json_encode($records[0]), FALSE);
            return $customer;
        }
        return $record;
    }

    public function toObject(){
    }



}