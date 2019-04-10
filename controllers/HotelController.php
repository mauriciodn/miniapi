<?php 
    /**
    * Controller for User
    * Author: Mauricio Diaz
    * Date: 04-09-2019
    */
    require_once(__DIR__ . '\helpers\ServiceHanlder.php');
    require_once(__DIR__ . '\helpers\ViewHelper.php');

    class HotelController
    {
        private $_view;

        public function init($url)
        {
            $this->_view = new View('Hotels.php');

            $this->_view->render();

        }

        public function search($url, $params)
        {
            $result = '';

            $serviceHandler = new ServiceHandler($url, $params);

            $hotelsObj = $serviceHandler->getRequest();

            if (!empty($hotelsObj) && $serviceHandler->getResponseStatus() == 200) {
                $result = $hotelsObj->hotels;
            }

            return $result;
        }
    }