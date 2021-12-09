<?php


class ComposerinstallController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {
        ini_set("output_buffering", "0");
        ob_implicit_flush(true);
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $composerInstallCommand = $this->getComposerInstallCommand();

        if( isset($this->request['debug']) && $this->request['debug'] === 'true') {
            $this->echoEventData("Debug mode is on!");
            $composerInstallCommand = "ping -c 5 google.com";
        }

        $this->echoEventData($composerInstallCommand);

        $proc = popen($composerInstallCommand, 'r');
        while (!feof($proc)) {
            $this->echoEventData(fread($proc, 4096));
        }
        $this->echoEventData("Done!");
    }

    public function getComposerInstallCommand(): string
    {
        return sprintf('cd %s && %s %s install 2>&1', SetupTool::PROJECT_PATH, SetupTool::$phpBinaryPath, SetupTool::COMPOSER_BINARY_PATH);
    }
}
