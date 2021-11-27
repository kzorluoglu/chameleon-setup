<?php

require 'Interfaces/PageControllerInterface.php';
require 'Controller/BaseController.php';

class SetupTool
{
    const SETUP_TOOL_PATH = __DIR__;

    public function __construct(array $request)
    {
        $this->request = $request;
        $this->run();
    }

    private function run()
    {
        try {
            $pageController = $this->getPageController();
            $pageController->index();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getPageController(): PageControllerInterface
    {
       return $this->createPageController($this->request['page'] ?? '');
    }

    private function createPageController($page): PageControllerInterface
    {
        $requiredController = self::SETUP_TOOL_PATH.'/Controller/HomeController.php';
        $pageController = 'HomeController';

        if ($page !== '') {
            $requiredController =  self::SETUP_TOOL_PATH.'/Controller/'.ucfirst($page).'Controller.php';
            $pageController = ucfirst($page) . 'Controller';
        }

        require $requiredController;
        return new $pageController($this->request);
    }


}

$newSetup = new SetupTool($_REQUEST);