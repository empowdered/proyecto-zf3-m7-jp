<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * Description of LoginController
 *
 * @author jpmunoz
 */
class LoginController extends AbstractActionController{
    //put your code here
    function __construct(){
      
    }
    function indexAction(){
        return new ViewModel();
    }
}
