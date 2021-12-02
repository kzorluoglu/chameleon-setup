<?php

class HomeController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {
        $this->render('home');
    }
}
