<?php
namespace Application\Model;

class Admin
{
    public $uid;
    public $uname;
    public $passwd;

    public function exchangeArray($data)
    {
        $this->uid     = (isset($data['uid'])) ? $data['uid'] : null;
        $this->uname = (isset($data['uname'])) ? $data['uname'] : null;
        $this->passwd  = (isset($data['passwd'])) ? $data['passwd'] : null;
    }
}
