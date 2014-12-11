<?php
namespace app\models;

class Customers extends \lithium\data\Model
{
    private $id;
    private $first_name;
    private $last_name;
    private $profile_url;
    private $user_photo_url;
    private $display_name;
    private $city;
    private $region;
    private $zip;
    private $address;
    private $email;
    private $password_hash_1;
    private $type;

    /**
     * @param $email
     * @param $password
     * @param null $firstName
     * @param null $lastName
     * @param string $type
     * @return Customers|object
     */
    public static function newCustomerIfNotExists($email, $password, $firstName = null, $lastName = null, $type = 'candidate')
    {
        $customer = Customers::findByEmail($email);
        if (isset($customer)) {
            return $customer;
        }
        $customer = Customers::create();
        $customer->email = $email;
        $customer->password_hash_1 = hash('md5', $password);
        $customer->first_name = $firstName;
        $customer->last_name = $lastName;
        $customer->type = $type;
        $customer->save();
        return $customer;
    }

    /**
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $displayName
     * @param $profileUrl
     * @param $city
     * @param $region
     * @param $zip
     * @param $address
     * @param string $type
     * @return Customers|object
     */
    public static function newCustomerFromProviderIfNotExists($email,
                                                              $firstName,
                                                              $lastName,
                                                              $displayName,
                                                              $profileUrl,
                                                              $city,
                                                              $region,
                                                              $zip,
                                                              $address,
                                                              $type = 'candidate')
    {
        $customer = Customers::findByEmail($email);
        if (!isset($customer)) {
            $customer = Customers::create();
        }

        $customer->email = $email;
        $customer->first_name = Customers::onlySetIfNotNull($customer->first_name, $firstName);
        $customer->last_name = Customers::onlySetIfNotNull($customer->last_name, $lastName);
        $customer->display_name = Customers::onlySetIfNotNull($customer->display_name, $displayName);
        $customer->profile_url = Customers::onlySetIfNotNull($customer->profile_url, $profileUrl);
        $customer->city = Customers::onlySetIfNotNull($customer->city, $city);
        $customer->region = Customers::onlySetIfNotNull($customer->region, $region);
        $customer->zip = Customers::onlySetIfNotNull($customer->zip, $zip);
        $customer->address = Customers::onlySetIfNotNull($customer->address, $address);
        $customer->type = $type;

        $customer->save();

        return $customer;
    }

    private function onlySetIfNotNull($target, $source)
    {
        if (!empty($source)) {
            return $source;
        }
        return $target;
    }

    /**
     * @param $id
     * @return Customers
     * @throws \InvalidArgumentException
     */
    public static function findById($id)
    {
        $record = Customers::find('first', array(
            'conditions' => array(
                'id' => $id
            )
        ));

        return Customers::copy($record);
    }


    /**
     * @param $email
     * @return Customers
     */
    public static function findByEmail($email)
    {
        $record = Customers::find('first', array(
            'conditions' => array(
                'email' => $email
            )
        ));
        return Customers::copy($record);
    }

    /**
     * @param $record
     * @return Customers object
     */
    public static function copy($record)
    {
        return $record;
    }


    public static function isExistingCustomer($email)
    {
        $customer = Customers::findByEmail($email);
        if ($customer->email) {
            return true;
        }
        return false;
    }

    public function authenticate($password)
    {
        if (isset($password) && isset($this->password_hash_1) && $this->password_hash_1 == hash('md5', $password)) {
            return true;
        }
        return false;
    }


    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail($record = null)
    {
        if (isset($record)) {
            return $record->email;
        }
        return $this->email;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getFirstName($record = null)
    {
        if (isset($record)) {
            return $record->first_name;
        }

        return $this->first_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getLastName($record = null)
    {
        if (isset($record)) {
            return $record->last_name;
        }

        return $this->last_name;
    }

    /**
     * @param mixed $password_hash_1
     */
    public function setPasswordHash1($password_hash_1)
    {
        $this->password_hash_1 = $password_hash_1;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash1($record = null)
    {

        if (isset($record)) {
            return $record->password_hash_1;
        }
        return $this->password_hash_1;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType($record = null)
    {
        if (isset($record)) {
            return $record->type;
        }

        return $this->type;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress($record = null)
    {
        if (isset($record)) {
            return $record->address;
        }
        return $this->address;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCity($record = null)
    {
        if (isset($record)) {
            return $record->city;
        }

        return $this->city;
    }

    /**
     * @param mixed $display_name
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
    }

    /**
     * @return mixed
     */
    public function getDisplayName($record = null)
    {
        if (isset($record)) {
            return $record->display_name;
        }

        return $this->display_name;
    }

    /**
     * @param mixed $profile_url
     */
    public function setProfileUrl($profile_url)
    {
        $this->profile_url = $profile_url;
    }

    /**
     * @return mixed
     */
    public function getProfileUrl($record = null)
    {
        if (isset($record)) {
            return $record->profile_url;
        }

        return $this->profile_url;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getRegion($record = null)
    {
        if (isset($record)) {
            return $record->region;
        }
        return $this->region;
    }

    /**
     * @param mixed $user_photo_url
     */
    public function setUserPhotoUrl($user_photo_url)
    {
        $this->user_photo_url = $user_photo_url;
    }

    /**
     * @return mixed
     */
    public function getUserPhotoUrl($record = null)
    {

        if (isset($record)) {
            return $record->user_photo_url;
        }
        return $this->user_photo_url;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getZip($record = null)
    {
        if (isset($record)) {
            return $record->zip;
        }

        return $this->zip;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId($record = null)
    {
        if (isset($record)) {
            return $record->id;
        } else {
            return $this->id;
        }

    }
}