<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        $error = $exception = array();

        if (!$errors || !$errors instanceof ArrayObject) {
            $error['message'] = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $error['message'] = 'Page not found';
                $error['code'] = 404;
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $error['message'] = 'Application error';
                $error['code'] = 500;
                break;
        }

        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($error['message'], $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $exception['message'] = $errors->exception->getMessage();
            $exception['trace'] = $errors->exception->getTraceAsString();
        }

        // Get the Twig
        $twig = $this->getInvokeArg('bootstrap')->getResource('twig');

        // Set response
        $this->getResponse()->appendBody(
        	$twig->render(
        		'error/error.phtml',
        		array(
        			'error' => $error,
        			'exception' => $exception,
        			'request_params' => var_export($errors->request->getParams(), true),
        		)
        	),
            'default'
        );
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');

        if (!$bootstrap->hasResource('Log')) {
            return false;
        }

        $log = $bootstrap->getResource('Log');

        return $log;
    }

}

