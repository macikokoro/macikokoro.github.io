<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;

use app\models\Authenticator;
use app\models\Customers;

class LoginController extends \lithium\action\Controller
{


    public function index()
    {
        if (isset($this->request->query['hidden'])) {
            $hidden = $this->request->query['hidden'];
        }
        if (isset($this->request->query['error'])) {
            $errorMessage = $this->request->query['error'];
        }
        return compact("controller", "hidden", "errorMessage");
    }

    public function doLogin()
    {
        //If the use retries to login and his session information
        //is already set then we don't have to go further.
        $isLoggedInEmail = $this->getLoginCheckCookie();

        if (isset($isLoggedInEmail)){
            $customer = Customers::findByEmail($isLoggedInEmail);
            if (isset($customer)){
                $this->redirect('../CandidateDashboard');
            }
            return;
        }

        $data = $this->request->query;
        $errorMessage = "The username and password does not match.Please try with a valid username";

        if (!isset($data['provider'])) {

            if (!isset($data['username']) || !isset($data['password'])){
                $this->redirect("../login?hidden=false&error=" . "Please provide username and password");
                return;
            }
            $email = $data['username'];
            $password = $data['password'];
            if (Customers::isExistingCustomer($email)) {
                $customer = Customers::findByEmail($email);
                if ($customer->authenticate($password)) {
                    $this->handleSuccess($customer);
                    return;
                } else {
                    $this->handleFailure($errorMessage);
                    return;
                }
            }
            //treat it as a new customer
            if (!isset($customer)) {
                $customer = Customers::newCustomerIfNotExists($data['username'], $data['password']);
                $this->handleSuccess($customer);
                return;
            }
            //for all other cases just redirect to login page with error message
        }

        if (isset($data['provider'])) {
            $provider = $data['provider'];
            $authenticator = new Authenticator();
            $userProfile = $authenticator->authenticate($provider);

            if ($userProfile) {
                $customer = Customers::newCustomerFromProviderIfNotExists($userProfile->getEmail(),
                    $userProfile->getFirstName(),
                    $userProfile->getLastName(),
                    $userProfile->getFirstName(),
                    $userProfile->getUrl(),
                    $userProfile->getCity(),
                    $userProfile->getState(),
                    $userProfile->getZip(),
                    $userProfile->getStreet());
                /**
                 * $customer Customers
                 */
                $customer->getEmail();
                $this->handleSuccess($customer);
                return;
            }
        }

        $this->handleFailure($errorMessage);
        return;
    }

    public function resetPassword()
    {
        $data = $this->request->query;
        $customer = Customers::findByEmail($data['username']);
        $customer->setPasswordHash1('Welcome');
    }

    /**
     * @param Customers $customer
     */
    private function setCookies($customer)
    {
        setcookie("user_email", $customer->getEmail($customer));
    }

    /**
     * @param Customers $customer
     */
    private function setSession($customer)
    {
        $_SESSION['session_user_id'] = $customer->getId($customer);
    }

    /**
     * @param Customers $customer
     */
    public function handleSuccess($customer)
    {
        $this->setCookies($customer);
        $this->setSession($customer);
        $this->redirect('../CandidateDashboard');
    }

    /**
     * @param $errorMessage
     */
    public function handleFailure($errorMessage)
    {
        $this->redirect("../login?hidden=false&error=" . $errorMessage);
    }

    /**
     * @return mixed
     */
    public function getLoginCheckCookie()
    {
        if (isset($_COOKIE['user_email'])){
            return $_COOKIE['user_email'];
        }
        return null;
    }

}

?>