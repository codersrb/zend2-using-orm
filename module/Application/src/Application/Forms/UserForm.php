<?php
namespace Application\Forms;

use Zend\Form\Form;

 class UserForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('user');

         $this->add(array(
             'name' => 'pkUserID',
             'type' => 'Hidden',
         ));

         $this->add(array(
             'name' => 'userFullName',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Full name',
             ),
         ));

         $this->add(array(
             'name' => 'userEmail',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Email',
             ),
         ));

		 $this->add(array(
             'name' => 'userStatus',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Status',
             ),
         ));

         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Save',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
