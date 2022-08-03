<?php

class DatabasevalidationController extends BaseController implements PageControllerInterface
{

    /**
     * @throws JsonException
     */
    public function index(): void
    {
        $connected = false;
        $error = '';

        $databaseInformation = $this->getDatabaseInformation($this->request);

        if ($_POST) {
            $dbConnection = $this->validateDatabaseConnection();

            if ($dbConnection instanceof PDO) {
                $connected = true;
            }

            if ($dbConnection instanceof PDOException) {
                $connected = false;
                $error = $dbConnection->getMessage();
            }

        }


        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'dbConnection' => $dbConnection ?? false,
            'databaseInformation' => $databaseInformation,
            'connected' => $connected,
            'error' => $error,
        ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /**
     * @return PDO|PDOException
     */
    private function validateDatabaseConnection()
    {
        try {
            return $this->getPDO(
                $this->request['hostname'],
                $this->request['port'],
                $this->request['name'],
                $this->request['username'],
                $this->request['password'],
            );
        } catch (\PDOException $e) {
            return $e;
        }
    }

    private function getDatabaseInformation(array $request)
    {

        return [
            'hostname' => $request['hostname'],
            'port' => $request['port'],
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => $request['password'],
            'install_demo_data' => $request['install_demo_data'] ?? false,
        ];
    }
}