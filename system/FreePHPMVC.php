<?php

/**
 * FreePHPMVC - Manages the entire MVC
 *
 * @name FreePHPMVC
 * @package FreePHPMVC
 * @author Lucas Marques Dutra <dutr4@outlook.com>
 * @version 1.0
 * @since 2016-11-25
 * @copyright (c) 2016, Lucas Marques Dutra - General Public License v.3 / Copyleft Software
 */
class FreePHPMVC {

    /**
     * Application Controller
     *
     * Receives the controller name through the URL first structure
     * http://example.com/controllerName/
     *
     * @access private
     */
    private $controller;

    /**
     * Application actions (controller methods)
     *
     * Receives the action through the URL second structure 
     * http://example.com/controllerName/action
     *
     * @access private
     */
    private $action;

    /**
     * Application Parameters (the controller's function params)
     *
     * Receive an array through the third structure to beyond:
     * http://example.com/controllerName/action/param1/param2/paramX...
     *
     * @access private
     */
    private $params;

    /**
     * Class constructor
     * Get controller, action and params, then configures it all
     */
    function __construct() {
       
        // Get the controller values, action and params through the URL, and configures it
        $this->getUrlData();
            
        //Verify if controller exists. In false case, loads the default controller
        if (!$this->controller) {
            $this->startControllerDefault();
        } else {
            $this->tryDefinedController();
        }
        
    }

    /**
     * Get params from $_GET['path'] and condfigures its properties
     * The URL must be formatted like this:
     * http://www.example.com/controller/action/parame1/parame2/etc...
     */
    public function getUrlData() {

        // Verifica se o parâmetro path foi enviado
        if (isset($_GET['path'])) {

            // Get the value of $_GET['path']
            $path = $_GET['path'];

            // Cleans dirty data
            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);

            // Cria um array de parâmetros
            $path = explode('/', $path);
            // Configura as propriedades 
            $this->controller  = 'Controller';
            $this->controller .= arrayKey($path, 0);
            $this->action = arrayKey($path, 1);

            // Configura os parâmetros
            if (arrayKey($path, 2)) {
                unset($path[0]);
                unset($path[1]);

                // Os parâmetros sempre virão após a ação
                $this->params = array_values($path);
            }
        }
    }

    public function startControllerDefault() {
        // Add default controller
        require_once BASE_PATH . '/controller/Controller'.APP_HOME.'.php';
        
        // Creates controller Defined as home by the user
        $oControllerName = 'Controller'.APP_HOME;
        
        $this->controller = new $oControllerName();

        // execute index method
        $this->controller->index();
    }

    public function tryDefinedController() {

        // If the controller file not exists, go to 404 defined page
        $sControllerFile = BASE_PATH . '/controller/Controller' . $this->controller . '.php';

        if (file_exists($sControllerFile)) {
            // Include controller name
            require_once $sControllerFile;

            // Removes invalid characters from controller name to generate the ClassName
            // If the file name is "ControllerBlog" for example, the class name should be ControllerBlog too
            $this->controller = preg_replace('/[^a-zA-Z]/i', '', $this->controller);

            // If the class name/file still not existing, go to 404 page 
            if (class_exists($this->getController())) {
                // now it creates the controller class and send params
                $oController = $this->getController($this->getParams());
                $this->setController($oController); 
                $this->tryDefinedMethod();
                
                /* All occurrences below send to the 404 page if the requirements were not attended */
            } else {
                require_once PAGE_404;
            }
        } else {
            require_once PAGE_404;
        }
    }
    
    /**
     * Verifies if the controller has method/action
     * in case of true, load it, else tries to call index method/action
     */
    public function tryDefinedMethod() {
        // if method exists, call it and send the params
        if (method_exists($this->controller, $this->action)) {
            $this->controller->{$this->action}($this->params);
        } else {
            //if does not have a defined method, so the application will call the "index method"
            $this->callIndexMethod();
        }
    }
    
    /**
     * Tries to call the index method in the setted controller
     * if cannot load, go to 404 page
     */
    public function callIndexMethod() {
        if (!$this->action && method_exists($this->controller, 'index')) {
            $this->controller->index($this->params);
        } else {
            require_once PAGE_404;
        }
    }

    public function getController($aParams = null) {
        return $this->controller($aParams);
    }

    public function getAction() {
        return $this->action;
    }

    public function getParams() {
        return $this->params;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function setParams($params) {
        $this->params = $params;
    }
    
}
