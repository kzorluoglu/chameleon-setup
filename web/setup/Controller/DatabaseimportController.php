<?php


class DatabaseimportController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {

        if(isset($_SESSION['mysql_information']) === false) {
            $this->redirect('setup?page=databasevalidation');
        }

        ob_end_flush();
        ini_set("output_buffering", "0");
        ob_implicit_flush(true);
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $pdo = $this->getPDO(
            $_SESSION['mysql_information']['mysql_host'],
            $_SESSION['mysql_information']['mysql_port'],
            $_SESSION['mysql_information']['mysql_databaseName'],
            $_SESSION['mysql_information']['mysql_username'],
            $_SESSION['mysql_information']['mysql_password'],
        );

        $databaseFile = $this->readDatabaseFile();

        $this->echoEventData("Database import started");
        $sqlLines = explode(";\n", $databaseFile);
        $errorMessages = [];
        foreach ($sqlLines as $key => $val) {
            try {
                $this->echoEventData($val);
                $pdo->exec($val);
            }catch (\PDOException $e) {
                $this->echoEventData("Error: ".$e->getMessage());
            }
        }

        if(\count($errorMessages) === 0) {
            $this->echoEventData("Finish!");
        }

    }

    private function readDatabaseFile()
    {
        $path = SetupTool::SETUP_TOOL_PATH."/Database/shop-database.sql";
        if(false === file_exists($path)) {
            throw new \Exception(sprintf("Database file (%s) not found.", $path));
        }
        return file_get_contents($path);
    }

}