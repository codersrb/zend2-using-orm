<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Validator\File\IsImage;
use Zend\Validator\File\Size;
use Zend\File\Transfer\Adapter\Http;

use Application\Forms\UserForm;
use Exception;

use Application\Model\User;


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

	public function addAction()
	{
		$form = new UserForm();

		$request = $this->getRequest();
		if($request->isPost())
		{
		 	$user = new User();
		 	$form->setInputFilter($user->getInputFilter());
		 	$form->setData($request->getPost());

			 if($form->isValid())
			 {
			     $user->exchangeArray($form->getData());
			     $this->getAlbumTable()->saveAlbum($user);

			     // Redirect to list of albums
			     return $this->redirect()->toRoute('app', ['controller' => 'user']);
			 }
		}
		return new ViewModel([
			'form' => $form
		]);
	}

	public function viewAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);

		if(!$id)
		{
			return $this->redirect()->toRoute('app', array('controller' => 'user'));
		}


		try
		{
			$model = $this->getUserTable()->findOne($id);
		}
		catch(Exception $ex)
		{
			return $this->redirect()->toRoute('app', array('controller' => 'user'));
		}

		return new ViewModel([
			'model' => $model
		]);
	}


	public function editAction()
	{

		$id = (int) $this->params()->fromRoute('id', 0);

		return new ViewModel();
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
