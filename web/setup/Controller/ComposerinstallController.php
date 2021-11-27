<?php


class ComposerinstallController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {
        ob_end_flush();
        ini_set("output_buffering", "0");
        ob_implicit_flush(true);
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $this->echoEventData("Start!");
        $debug = sprintf("Debug Mode: %s", ($this->request['debug'] === 'true') ? 'on' : 'off');
        $this->echoEventData($debug);
        $composerInstallCommand = $this->getComposerInstallCommand();

        if($this->request['debug'] === 'true') {
            $composerInstallCommand = "ping -c 5 google.com";
        }

        $proc = popen($composerInstallCommand, 'r');
        while (!feof($proc)) {
            $this->echoEventData(fread($proc, 4096));
        }
        $this->echoEventData("Finish!");
    }

    public function echoEventData($datatext) {
        echo "data: ".implode("\ndata: ", explode("\n", $datatext))."\n\n";
    }

    public function getComposerInstallCommand(): string
    {
        $projectPath = SetupTool::SETUP_TOOL_PATH.'/../../';
        $getPhpBinaryPath = shell_exec('which php');
        $composer = SetupTool::SETUP_TOOL_PATH.'/composer.phar';

        return sprintf('cd %s && %s %s install', $projectPath, $getPhpBinaryPath, $composer);
    }
}