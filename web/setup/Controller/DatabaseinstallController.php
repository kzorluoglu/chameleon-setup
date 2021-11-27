<?php


class DatabaseinstallController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {

        if(isset($_SESSION['mysql_information']) === false) {
            $this->redirect('setup?page=databasevalidation');
        }

        $this->render('databaseinstall');
    }


}