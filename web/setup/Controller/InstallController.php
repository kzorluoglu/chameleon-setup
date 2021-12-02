<?php

class InstallController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {
        $this->render('install', [
            'debug' => $this->request['debug'] ?? false
        ]);
    }

}