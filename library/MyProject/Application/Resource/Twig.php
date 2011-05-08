<?php
/**
 * MyProject
 *
 * @category   MyProject
 * @package    MyProject_Application
 * @subpackage Resource
 * @license    http://creativecommons.org/publicdomain/zero/1.0/  Public Domain
 */

/**
 * @see Zend_Application_Resource_ResourceAbstract
 */
//require_once 'Zend/Application/Resource/ResourceAbstract.php';


/**
 * Resource for initializing the Twig template engine
 *
 * @uses       MyProject_Application_Resource_ResourceAbstract
 * @category   MyProject
 * @package    MyProject_Application
 * @subpackage Resource
 * @license    http://creativecommons.org/publicdomain/zero/1.0/  Public Domain
 */
class MyProject_Application_Resource_Twig
    extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Twig_Environment
     */
    protected $_twig;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Twig_Environment
     */
    public function init()
    {
        return $this->getTwig();
    }

    /**
     * Initialize Twig engine
     *
     * @return Twig_Environment
     */
    public function getTwig()
    {
        if (null === $this->_twig) {
            $options = $this->getOptions();

            $loader = new Twig_Loader_Filesystem($options['templatesPath']);

            $this->_twig = new Twig_Environment(
                $loader,
                $options
        	);
        }

        return $this->_twig;
    }
}
