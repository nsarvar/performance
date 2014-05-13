<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    public $role;

    public function __construct($username, $password)
    {
        parent::__construct($username, $password);
    }

    public function authenticate()
    {
        $users = array(
            // username => password
            'demo' => 'demo',
            'admin' => 'admin',
        );
        if (!isset($users[$this->username]))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif ($users[$this->username] !== $this->password)
            $this->errorCode = self::ERROR_PASSWORD_INVALID; else
            $this->errorCode = self::ERROR_NONE;
        return !$this->errorCode;
    }
}