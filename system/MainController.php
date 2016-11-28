<?php

/**
 * MainController - All Controllers must extends this class
 */
class MainController extends UserLogin {

    /**
     * DataBase connection using PDO
     * @access public
     */
    public $db;

    /**
     * Classe phpass 
     * @see http://www.openwall.com/phpass/
     * @access public
     */
    public $phpass;

    /**
     * Page Title
     * @access public
     */
    public $title;

    /**
     * Verifies if the page needs login
     * @access public
     */
    public $loginRequired = false;

    /**
     * Verify if the permission is required to proceed some action
     * @access public
     */
    public $permissionRequired = 'any';

    /**
     * Controller Params
     * @access public
     */
    public $params = array();

    /**
     * Configures all the class to crates Controller enviroment
     * @access public
     */
    public function __construct($params = array()) {

        // Instances DataBase Object
        $this->db = new Database();

        // Phpass Class
        $this->phpass = new PasswordHash(8, false);

        // Environment params
        $this->params = $params;

        // Verify login
        //$this->checkUserLogin();
    }

    /**
     * Load the model itself
     * @access public
     */
    public function loadModel($sModelName = false) {

        // loadModel will return false if can't find model
        if (!$sModelName){
            return false;
        }

        // including file
        $sModelPath = BASE_PATH . '/model/' . $sModelName . '.php';

        // Verifies if file exists
        if (file_exists($sModelPath)) {

            // Call file
            require_once $sModelPath;

            // Split (if it can) the path to get model's name
            $aModelName = explode('/', $sModelName);

            // Get only final name (the real one)
            $sModelName = end($aModelName);
            
            // Verifies if the class exists
            if (class_exists($sModelName)) {
                // Return the object with the class
                return new $sModelName($this->db, $this);
            }
        } else {
            return false;
        }
    }
    
    public function loadView($sViewName = false) {

        // loadView will return false if can't find view
        if (!$sViewName){
            return false;
        }

        // including file
        $sViewPath = BASE_PATH . '/view/View' . $sViewName . '.php';

        // Veries if exists
        if (file_exists($sViewPath)) {
            
            // Call file
            require_once $sViewPath;
            // Split (if it can) the path to get model's name
            $aViewName = explode('/', $sViewName);

            // Get only final name (the real one)
            $sViewName = end($aViewName);
            $sCompleteViewClass = 'View'.$sViewName;
            
            // Verifies if the class exists
            if (class_exists($sCompleteViewClass)) {
                // Return the object with the class
                return new $sCompleteViewClass();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
}
