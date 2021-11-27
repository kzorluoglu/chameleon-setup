<?php
session_start();
require 'Interfaces/PageControllerInterface.php';
require 'Controller/BaseController.php';

class SetupTool
{
    public const SETUP_TOOL_PATH = __DIR__;
    public const PROJECT_PATH = self::SETUP_TOOL_PATH.'/../../';
    public const COMPOSER_BINARY_PATH = self::SETUP_TOOL_PATH.'/composer.phar';
    public static $phpBinaryPath;

    public function __construct(array $request)
    {
        $this->request = $request;
        self::$phpBinaryPath = $this->getPHPBinaryPath();
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

    private function getPHPBinaryPath()
    {
        $phpBinaryPath = exec('which php');
        if ($phpBinaryPath === '') {
            throw new \Exception('PHP binary not found');
        }
        return $phpBinaryPath;
    }


}

$newSetup = new SetupTool($_REQUEST);