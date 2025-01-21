<?php

namespace App\Controller;

class MainController extends AppController
{
    /**
     * Home Method
     *
     * @return null - Renders the view
     */
    public function home()
    {
        $this->set('pageTitle', 'Home Page');

        return null; //Return View in folder: Main/home
    }
}
