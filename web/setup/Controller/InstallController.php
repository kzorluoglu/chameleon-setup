<?php

class InstallController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {

        $this->render('install', [
            'title' => 'install',
            'debug' => $this->request['debug'] ?? false
        ]);
    }

    public function install()
    {
        $projectPath = SetupTool::SETUP_TOOL_PATH.'/../../';
        $getPhpBinaryPath = shell_exec('which php');
        $composer = SetupTool::SETUP_TOOL_PATH.'/composer.phar';
        $composerInstallCommand = sprintf('cd %s && %s %s install', $projectPath, $getPhpBinaryPath, $composer);
        var_dump($composerInstallCommand);

    }

}