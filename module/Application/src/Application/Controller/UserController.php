<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Validator\File\IsImage;
use Zend\Validator\File\Size;
use Zend\File\Transfer\Adapter\Http;

use Application\Forms\EditBarForm;


/**
 * Controller
 *
 * @author Saurabh Sharma
 *
 * @version 1.0
 *
 */

 // \Zend\Debug\Debug::dump($data->buffer() );

class UserController extends AbstractActionController
{

	/**
	 * @var Auth Holder property
	 */
    protected $auth;
    protected $userTable;

	/**
	 * @todo Constructor method.
	 * @todo To autoload dependencies
	 */
    public function __construct()
    {
        if (!$this->auth instanceof AuthenticationService)
		{
			$this->auth = new AuthenticationService();
        }
    }

    /**
     * @todo Index Action
     */
    public function indexAction()
	{
		/** Check if logged-in */
        if(!$this->auth->hasIdentity())
		{
			$this->redirect()->toRoute('admin-login');
        }


        $data = $this->getUserTable()->fetchAll();

        return new ViewModel([
			'users' => $data,
			'title' => 'User Listing'
		]);
    }

	public function viewAction()
	{
		return new ViewModel([
			'title' => 'View'
		]);
	}



	/**
     * Return existing User Table
     *
     * @return \Application\Model\UserTable | NULL
     */
	 public function getUserTable()
     {
         if(!$this->userTable)
		 {
             $sm = $this->getServiceLocator();
             $this->userTable = $sm->get('Application\Model\UserTable');
         }
         return $this->userTable;
     }

}
