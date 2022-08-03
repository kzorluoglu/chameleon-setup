<?php
require 'Interfaces/PageControllerInterface.php';
require 'Controller/BaseController.php';

class SetupTool
{
    public const SETUP_TOOL_PATH = __DIR__;
    public const PROJECT_PATH = self::SETUP_TOOL_PATH . '/../../';
    public const COMPOSER_BINARY_PATH = self::SETUP_TOOL_PATH . '/composer.phar';
    public static string $phpBinaryPath;
    private array $request;

    /**
     * @throws Exception
     */
    public function __construct()
    {

        $this->request = $this->getRequest();
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

        if ($page === '') {
            throw new \RuntimeException('Route not defined');
        }

        $requiredController = self::SETUP_TOOL_PATH . '/Controller/' . ucfirst($page) . 'Controller.php';
        $pageController = ucfirst($page) . 'Controller';

        require $requiredController;
        return new $pageController($this->request);
    }

    private function getPHPBinaryPath(): string
    {
        $phpBinaryPath = exec('which php');
        if ($phpBinaryPath === '') {
            throw new \RuntimeException('PHP binary not found');
        }

        return $phpBinaryPath;
    }

    /**
     * @throws JsonException
     */
    private function getRequest(): array
    {
        $request = $_REQUEST;
        return $this->parseBodyAsRequestParameter($request);
    }

    private function parseBodyAsRequestParameter(array $request)
    {

        $jsonBody = json_decode(file_get_contents('php://input'), true, 512);

        if (true === empty($jsonBody)) {
            return $request;
        }

        foreach ($jsonBody as $key => $value) {
            if (array_key_exists($key, $request)) {
                continue;
            }

            $request[$key] = $value;
        }

        return $request;

    }


}

$newSetup = new SetupTool($_REQUEST);