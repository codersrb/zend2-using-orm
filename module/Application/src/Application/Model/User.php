<?php
namespace Application\Model;

class User
{
    public $pkUserID;
    public $userFullName;
    public $userEmail;
    public $userGender;
    public $userAdded;
    public $userStatus;

    public function exchangeArray($data)
    {
        $this->pkUserID     = (isset($data['pkUserID'])) ? $data['pkUserID'] : null;
        $this->userFullName = (isset($data['userFullName'])) ? $data['userFullName'] : null;
        $this->userEmail  = (isset($data['userEmail'])) ? $data['userEmail'] : null;
        $this->userGender  = (isset($data['userGender'])) ? $data['userGender'] : null;
        $this->userAdded  = (isset($data['userAdded'])) ? $data['userAdded'] : null;
        $this->userStatus  = (isset($data['userStatus'])) ? $data['userStatus'] : null;
    }
}
