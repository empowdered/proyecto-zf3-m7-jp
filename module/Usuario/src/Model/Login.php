<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author jpmunoz
 */

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Authentication\Result;
use Zend\View\Exception\RuntimeException;

class Login {
    //put your code here
    private $auth;
    private $authAdapter;
    
    const NOT_IDENTIFY = 'notIdentity';
    const INVALID_CREDENTIAL = 'invalidCredential';
    const INVALID_USER = 'invalidUser';
    const INVALID_LOGIN = 'invalidLogin';
    
    protected $messages = [
        self::NOT_IDENTITY => "Not existent identity. A record with the supplied identity could not be found.",
        self::INVALID_CREDENTIAL => "Invalid credential. Supplied credential is invalid.",
        self::INVALID_USER => "Invalid User. Supplied credential is invalid",
        self::INVALID_LOGIN => "Invalid Login. Fields are empty"
    ];
    
    function __construct($dbAdapter,AuthenticationService $authService){
    $this->authAdapter = new AuthAdapter($dbAdapter,'usuarios','email','password');
    $this->auth = $authService;
    }
    function login($identifier, $password){
        if(!(empty($identifier)&&(!(empty($password))))){
            $this->authAdapter->setIdentity($identifier);
            $this->authAdapter->setCredential($password);
        
            $result = $this->auth->authenticate($this->authAdapter);
            
            switch($result->getCode()){
                case Result::FAILURE_ITENTITY_NOT_FOUND:
                    throw new RunTimeException($this->messages[self::INVALID_USER]);
                    break;
                case Result::SUCCESS:
                      if($result->isValid())
                      {            
                        $data = $this->authAdapter->getResultRowObject();
                        $this->auth->getStorage()->write($data); 
                      }else{
                         throw new 
                            ApplicationRuntimeException($this->messages[self::INVALID_USER]);
                      }break;
                default:
                     throw new RuntTimeException($this->messages[self::INVALID_LOGIN]);
                      break;
    }            
    }else{
        throw new RuntimeException($this->messages[self::INVALID_LOGIN]);
    }
    return $this;
}
    function logout(){
        $this->auth->clearIdentity();
        return $this;
    }
   function getIdentity() {
        if ($this->auth->hasIdentity()) {
            return $this->auth->getIdentity();
        }
        return null;
    }
     public function isLoggedIn() {
        return $this->auth->hasIdentity();
    }

    function hasIdentity() {
        return $this->auth->hasIdentity();
    }
    /**
     * @param string $messageString
     * @param string $messageKey    OPTIONAL
     * @return Login
     * @throws Exception
     */
    function setMessage($messageString, $messageKey = null) {
        if ($messageKey === null) {
            $keys = array_keys($this->messages);
            $messageKey = current($keys);
        }
        if (!isset($this->messages[$messageKey])) {
            throw new \Exception("No message exists for key '$messageKey'");
        }
        $this->messages[$messageKey] = $messageString;
        return $this;
    }

    /**
     * @param array $messages
     * @return Login
     */
    function setMessages(array $messages) {
        foreach ($messages as $key => $message) {
            $this->setMessage($message, $key);
        }
        return $this;
    }
}