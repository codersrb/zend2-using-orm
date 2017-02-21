<?php
namespace Application\Model;


use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class User implements InputFilterAwareInterface
{
    public $pkUserID;
    public $userFullName;
    public $userEmail;
    public $userGender;
    public $userAdded;
    public $userStatus;

	protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->pkUserID     = (isset($data['pkUserID'])) ? $data['pkUserID'] : null;
        $this->userFullName = (isset($data['userFullName'])) ? $data['userFullName'] : null;
        $this->userEmail  = (isset($data['userEmail'])) ? $data['userEmail'] : null;
        $this->userGender  = (isset($data['userGender'])) ? $data['userGender'] : null;
        $this->userAdded  = (isset($data['userAdded'])) ? $data['userAdded'] : null;
        $this->userStatus  = (isset($data['userStatus'])) ? $data['userStatus'] : null;
    }


	// Add content to these methods:
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
	 	throw new \Exception("Not used");
	}



	public function getInputFilter()
	{
		if(!$this->inputFilter)
		{
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				 'name'     => 'pkUserID',
				 'required' => true,
				 'filters'  => array(
				     array('name' => 'Int'),
				 ),
			));

			 $inputFilter->add(array(
			     'name'     => 'userFullName',
			     'required' => true,
			     'filters'  => array(
			         array('name' => 'StripTags'),
			         array('name' => 'StringTrim'),
			     ),
			     'validators' => array(
			         array(
			             'name'    => 'StringLength',
			             'options' => array(
			                 'encoding' => 'UTF-8',
			                 'min'      => 1,
			                 'max'      => 100,
			             ),
			         ),
			     ),
			 ));

		 $inputFilter->add(array(
		     'name'     => 'userEmail',
		     'required' => true,
		     'filters'  => array(
		         array('name' => 'StripTags'),
		         array('name' => 'StringTrim'),
		     ),
		     'validators' => array(
		         array(
		             'name'    => 'StringLength',
		             'options' => array(
		                 'encoding' => 'UTF-8',
		                 'min'      => 1,
		                 'max'      => 100,
		             ),
		         ),
		     ),
		 ));

		 $inputFilter->add(array(
		     'name'     => 'userStatus',
		     'required' => true,
		     'filters'  => array(
		         array('name' => 'StripTags'),
		         array('name' => 'StringTrim'),
		     ),
		     'validators' => array(
		         array(
		             'name'    => 'StringLength',
		             'options' => array(
		                 'encoding' => 'UTF-8',
		                 'min'      => 1,
		                 'max'      => 100,
		             ),
		         ),
		     ),
		 ));

		 $this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}
