<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;

use Application\Model\Album;
use Application\Model\AlbumTable;

use Application\Model\Admin;
use Application\Model\AdminTable;

use Application\Model\User;
use Application\Model\UserTable;

class Module
{

	public function getServiceConfig()
    {
        return array(
            'factories' => array(
				/**
				 * @todo Gateway Adapter setup
				 */
                'Application\Model\AlbumTable' =>  function($sm)
				{
                    $tableGateway = $sm->get('AlbumTableGateway');
                    $table = new AlbumTable($tableGateway);
                    return $table;
                },
				'Application\Model\AdminTable' =>  function($sm)
				{
                    $tableGateway = $sm->get('AdminTableGateway');
                    $table = new AdminTable($tableGateway);
                    return $table;
                },
				'Application\Model\UserTable' =>  function($sm)
				{
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new UserTable($tableGateway);
                    return $table;
                },



				/**
				 * @todo Gateways
				 */
                'AlbumTableGateway' => function ($sm)
				{
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
				'AdminTableGateway' => function ($sm)
				{
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Admin());
                    return new TableGateway('tbl_admin', $dbAdapter, null, $resultSetPrototype);
                },
				'UserTableGateway' => function ($sm)
				{
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('tbl_users', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


	public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
		$routeMatch = $e->getRouteMatch();
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);


		// user identity in view model
        $auth = new AuthenticationService();
        $viewModel = $e->getApplication()
        ->getMvcEvent()
        ->getViewModel();


		$viewModel->identity = $auth->getIdentity();
        //end user identity in view model

        $app = $e->getTarget();
        $sm = $app->getServiceManager();
        $events = $app->getEventManager();
        // $events->attach($sm->get('Common\Listeners\ApiErrorListener'));
        // $events->attach($sm->get('Application\Listeners\OAuthListener'));
    }
}
