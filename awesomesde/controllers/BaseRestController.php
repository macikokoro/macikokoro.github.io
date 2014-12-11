<?php

namespace app\controllers;

class BaseRestController  extends \lithium\action\Controller {

    // HTTP Status Codes
    const HTTP_STATUS_OK = 200;
    const HTTP_STATUS_CREATED = 201;
    const HTTP_STATUS_ACCEPTED = 202;

    const HTTP_STATUS_BAD_REQUEST = 400;
    const HTTP_STATUS_UNAUTHORIZED = 401;
    const HTTP_STATUS_FORBIDDEN = 403;
    const HTTP_STATUS_NOT_FOUND = 404;
    const HTTP_STATUS_METHOD_NOT_ALLOWED = 405;
    const HTTP_STATUS_ERROR = 500;

    const OPTIONAL_TRUE=true;

    /**
     * Disables auto rendering
     */
    protected function _init()
    {
        parent::_init();
        $this->_render['auto'] = false;
    }

    /**
     * @param array $params
     * @return string
     * @description Builds out JSON success response object for API calls
     */
    protected function success($code, $params)
    {
        $this->response->status($code);
        header('Content-type: application/json');
        return json_encode(
            array(
                'status' => $code,
                'response' => $params
            ));

    }


    /**
     * @param array $params
     * @return string
     * @description Builds out JSON error response object for API calls
     */
    protected function error($code, array $params = array(), $logLevel = null)
    {

        header('Content-type: application/json');
        $this->response->status($code);
        return json_encode(
            array(
                'status' => $code,
                'error' => $params,
            )
        );

    }

    /**
     * Validates that the input is not empty or NULL
     *
     * @param $data the array that we want to verify.
     * @param $element the key in the array that we want to validate.
     * @param bool $optional Provides information if the element is optional or required , by default it is required.
     * @return null If the elements is optional and no values is provided in the $data then NULL is returned otherwise.
     * an invalid argument exception is thrown.
     * @throws \InvalidArgumentException
     */
    protected  function validateElement($data,$element,$optional=false,$default=null){
        if (isset($data[$element]) && strlen($data[$element]) > 0){
            return $data[$element];
        }

        if ($optional){
            return $default;
        }

        throw new \InvalidArgumentException( "The following required " . $element . " was not valid " . $data[$element] . "from" . json_encode($data));
    }

    public  function toInterface($object){
        $newArray = array();
        $newArray['implement'] = 'implement something';
        return $newArray;
    }

    public  function toInterfaceArray($array){
        if (!isset($array)){
            throw new \Exception("No Array to build the interface from ");
        }
        $arrayResponse = array();
        foreach($array as $object){
            $arrayResponse[] =$this->toInterface($object);
        }
        return $arrayResponse;
    }
}