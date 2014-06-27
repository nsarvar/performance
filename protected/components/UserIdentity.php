<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    public $role;
    public $userModel;

    public function __construct($username, $password)
    {
        parent::__construct($username, $password);
    }

    public function authenticate()
    {
        /**
         * @var $user User
         */
        $user = User::loadByLogin($this->username);

        if ($user->id === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif ($user->validatePassword($this->password) == false) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->errorCode = self::ERROR_NONE;
            $this->userModel = $user;
        }

        return !$this->errorCode;
    }

    public function getPersistentStates()
    {
        $states = array();
        if ($this->userModel) {
            foreach (array('role', 'login', 'group_id') as $state)
                $states[$state] = $this->userModel->$state;
        }
        return $states;
    }
}