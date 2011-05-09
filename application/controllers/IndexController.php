<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $twig = $this->getInvokeArg('bootstrap')->getResource('twig');

        $this->getResponse()->appendBody(
        	$twig->render(
        		'index/index.phtml',
        		array(
        			'title' => 42,
        			'user' => '%username%',
        			'ip' => $_SERVER['REMOTE_ADDR']
        		)
        	),
            'default'
        );
    }
}
