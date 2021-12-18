<?php


class DatabaseimportController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {
        $mysqlInformation = $_SESSION['mysql_information'];
        if(isset($mysqlInformation) === false) {
            $this->redirect('setup?page=databasevalidation');
        }

        ini_set("output_buffering", "0");
        ob_implicit_flush(true);
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        try {
            $pdo = $this->getPDO(
                $mysqlInformation['mysql_host'],
                $mysqlInformation['mysql_port'],
                $mysqlInformation['mysql_database_name'],
                $mysqlInformation['mysql_username'],
                $mysqlInformation['mysql_password'],
            );
        } catch (PDOException $e) {
            $this->echoEventData($e->getMessage());
            exit();
        }

        $databaseFile = $this->readDatabaseFile($mysqlInformation['install_demo_data']);

        $this->echoEventData("Database import started");
        $sqlLines = explode(";\n", $databaseFile);
        foreach ($sqlLines as $key => $val) {
            try {
                $this->echoEventData($val);
                $pdo->exec($val);
            }catch (\PDOException $e) {
                $this->echoEventData("Error: ".$e->getMessage());
                exit();
            }
        }

        $this->echoEventData("Done!");
    }

    private function readDatabaseFile(bool $installDemoData): string
    {
        $path = SetupTool::SETUP_TOOL_PATH."/Database/shop-database.sql";
        if($installDemoData === true) {
            $path = SetupTool::SETUP_TOOL_PATH."/Database/shop-database-with-demo-data.sql";
        }
        if(false === file_exists($path)) {
            throw new \Exception(sprintf("Database file (%s) not found.", $path));
        }
        return file_get_contents($path);
    }

}
