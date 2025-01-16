<?php 

namespace App\Controller;

class MainController extends AppController
{

    public function home()
    {
        $this->set('pageTitle', 'Home Page');
        
        //Return View in folder: Main/home
    }

}