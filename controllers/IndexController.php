<?php 
    /**
    * Controller for User
    * Author: Mauricio Diaz
    * Date: 04-09-2019
    */
    require_once(APP_PATH . '\controllers\helpers\ServiceHanlder.php');

    require_once(APP_PATH . '\controllers\helpers\ViewHelper.php');

    class IndexController
    {
        const AIRLINES_URL = 'https://beta.id90travel.com/airlines';

        const SESSION_URL = 'https://beta.id90travel.com/session.json';

        const HOTELS_URL = 'https://beta.id90travel.com/api/v1/hotels.json';

        private $_view;

        public function __construct()
        {
            $this->_view = new View('Index.php');
        }

        public function run()
        {
            if (empty($_POST['loginForm'])) {
                if (isset($_SESSION['user'])) {
                    $this->_getSearchPage();
                } else {
                    $this->_prepareView();
                }
            } else {
                $params = $this->_setPostParams();
                if (empty($params)) {
                    $this->_view->redirect('../index.php?error=mf');
                } else {
                    $this->_validateRequest(self::SESSION_URL, $params, 'postRequest');
                }
            }
        }

        private function _prepareView()
        {
            $serviceHandler = new ServiceHandler(self::AIRLINES_URL);

            $airlines = $serviceHandler->getRequest();

            $this->_view->render($airlines);
        }

        private function _setPostParams()
        {
            $params = array();
            $values = $_POST['loginForm'];
            if (isset($values['user']) && isset($values['password']) && isset($values['airline'])) {
                $params = array(
                    'session[username]' => $values['user'],
                    'session[password]' => $values['password'],
                    'session[airline]' => $values['airline'],
                    'session[remember_me]' => 1
                );
                $this->_validateRequest(self::SESSION_URL, $params, 'postRequest');
            } else {
                $this->_view->redirect('../index.php?error=mf');
            }
            return $params;
        }

        private function _setGetParams()
        {
            $params = array();
            $values = $_GET['hotelSearchForm'];
            if (isset($values['destination']) && isset($values['checkin']) && isset($values['checkout']) && isset($values['guests'])) {
                $params = array(
                    'guests[]' => $values['guests'],
                    'checkin' => $values['checkin'],
                    'checkout' => $values['checkout'],
                    'destination' => $values['destination'],
                    'rooms' => 1,
                    'sort_criteria' => 'Overall',
                    'sort_order' => 'desc',
                    'per_page' => '25',
                    'page' => '1',
                    'currency' => 'USD',
                );
            }

            return $params;
        }

        private function _validateRequest($url, $params, $httpMethod)
        {
            $serviceHandler = new ServiceHandler($url, $params);

            $userObj = $serviceHandler->$httpMethod();

            if (!empty($userObj) && $serviceHandler->getResponseStatus() === 200) {
                $_SESSION['user'] = $userObj->member;
                $this->_getSearchPage();
            } else {
                $this->_view->redirect('../index.php?error=badUser&status=' . $serviceHandler->getResponseStatus());
            }

        }

        private function _getSearchPage()
        {
            $hotelController = new HotelController();
            $hotelController->init(self::HOTELS_URL);            
        }

    }