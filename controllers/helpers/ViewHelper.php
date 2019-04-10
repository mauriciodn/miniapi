<?php 
    /**
    * Controller for User
    * Author: Mauricio Diaz
    * Date: 04-09-2019
    */
    class View
    {
        private $_viewToRender;

        public function __construct($view)
        {
            $this->_viewToRender = $view;
        }

        public function render($data = [])
        {
            //header('Location: views/' . $this->_viewToRender);
            require_once('views/' . $this->_viewToRender);
        }

        public function redirect($page)
        {
            header('Location: views/' . $page);
        }
    }