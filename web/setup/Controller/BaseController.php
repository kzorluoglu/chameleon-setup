<?php

class BaseController
{

    protected array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function render($view, $data = []): void
    {
        $data['full_url'] = $this->getFullUrl();
        extract($data, EXTR_OVERWRITE);
        require_once SetupTool::SETUP_TOOL_PATH . '/View/' . $view . '.php';
    }

    protected function getPDO(string $hostname, string $port, string $databaseName, string $username, string $password): PDO
    {
        $pdoConenctionString = sprintf(
            'mysql:host=%s:%s;dbname=%s',
            $hostname,
            $port,
            $databaseName
        );

        return new \PDO(
            $pdoConenctionString,
            $username,
            $password,
            [PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    protected function redirect(string $string): void
    {
        header("Location: $string");
        exit;
    }

    public function echoEventData($datatext): void
    {
        echo "data: " . implode("\ndata: ", explode("\n", $datatext)) . "\n\n";
    }

    private function getFullUrl(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]";
    }
}