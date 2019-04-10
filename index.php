<?php
    session_start();

    const APP_PATH = __DIR__;

    require_once('controllers/HotelController.php');
    require_once('controllers/IndexController.php');

    $indexController = new IndexController();

    $indexController->run();
