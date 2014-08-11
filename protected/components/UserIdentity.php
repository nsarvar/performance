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

        if ($user === NULL)
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
            foreach (array('role', 'login') as $state)
                $states[$state] = $this->userModel->$state;
            $states['user_id']         = $this->userModel->id;
            $states['group_id']        = ($this->userModel->group_id !== NULL) ? $this->userModel->group_id : false;
            $states['organization_id'] = ($this->userModel->organization_id !== NULL) ? $this->userModel->organization_id : false;
        }

        return $states;
    }
}