<?php

class DatabasevalidationController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {
        $connected = false;
        $error = '';

        $this->setSessionDatabaseInformation($this->request);
        $databaseInformation = $this->getDatabaseInformation();

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


        $this->render('databasevalidation', [
            'dbConnection' => $dbConnection ?? false,
            'databaseInformation' => $databaseInformation,
            'connected' => $connected,
            'error' => $error,
        ]);
    }

    /**
     * @return PDO|PDOException
     */
    private function validateDatabaseConnection()
    {
        try {
            return $this->getPDO(
                $this->request['mysql_host'],
                $this->request['mysql_port'],
                $this->request['mysql_database_name'],
                $this->request['mysql_username'],
                $this->request['mysql_password'],
            );
        } catch (\PDOException $e) {
            return $e;
        }
    }

    /** @return null|array */
    private function hasSessionDatabaseInformation(): ?array
    {
        return $_SESSION['mysql_information'] ?? null;
    }

    private function setSessionDatabaseInformation(array $request): void
    {
        $_SESSION['mysql_information'] =
            [
                'mysql_host' => $request['mysql_host'],
                'mysql_port' => $request['mysql_port'],
                'mysql_database_name' => $request['mysql_database_name'],
                'mysql_username' => $request['mysql_username'],
                'mysql_password' => $request['mysql_password'],
                'install_demo_data' => $request['install_demo_data'] ?? false,
            ];
    }

    private function getDatabaseInformation()
    {
        $databaseInformation = $this->hasSessionDatabaseInformation();

        if ($databaseInformation !== null) {
            return $databaseInformation;
        }

        return [
            'mysql_host' => '',
            'mysql_port' => '',
            'mysql_database_name' => '',
            'mysql_username' => '',
            'mysql_password' => '',
            'install_demo_data' => '',
        ];
    }
}