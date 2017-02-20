<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class AdminTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getAdmin($uid)
    {
        $uid  = (int) $uid;
        $rowset = $this->tableGateway->select(array('uid' => $uid));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $uid");
        }
        return $row;
    }

	public function getAdminByUsername($uname)
    {
        $rowset = $this->tableGateway->select(array('uname' => $uname));
        $row = $rowset->current();
        if(!$row)
		{
            throw new \Exception("Could not find row $uname");
        }
        return $row;
    }

	public function loginFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new InputFactory();

        $inputFilter->add($factory->createInput(array(
            'name' => 'uname',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 1,
                        'max' => 100
                    )
                )
            )
        )));

        $inputFilter->add($factory->createInput(array(
            'name' => 'passwd',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true
                )
            )
        )));

        return $inputFilter;
    }

    public function saveAlbum(Album $album)
    {
        $data = array(
            'uname' => $album->uname,
            'passwd'  => $album->passwd,
        );

        $uid = (int)$album->uid;
        if ($uid == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($uid)) {
                $this->tableGateway->update($data, array('uid' => $uid));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteAlbum($uid)
    {
        $this->tableGateway->delete(array('uid' => $uid));
    }
}
