<?php 
    /**
    * Controller for User
    * Author: Mauricio Diaz
    * Date: 04-09-2019
    */
    class ServiceHandler
    {
        private $_url = '';

        private $_params = '';

        private $_httpResponseStatus;

        public function __construct($baseUrl, array $params = [])
        {
            $this->_params = http_build_query($params, '&amp');

            $this->_url = $baseUrl;
        }

        public function getRequest()
        {
            $url = $this->_url . '?' . $this->_params;
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

            $response = curl_exec($curl);
            $this->_httpResponseStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            return json_decode($response);
        }

        public function postRequest()
        {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $this->_url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->_params);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            $this->_httpResponseStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            return json_decode($response);
        }

        /*private function _buildUrl($baseUrl, array $params = [])
        {
            $paramsString = '';
            foreach ($params as $key => $value) {
                $paramsString .= $key . '=' . $value;
            }
            return $baseUrl . '?' . $paramsString;
        }*/

        public function isValidResponse()
        {
            return $this->getResponseStatus() === 200 ? true : false;
        }

        public function getResponseStatus()
        {
            return $this->_httpResponseStatus;
        }
    }