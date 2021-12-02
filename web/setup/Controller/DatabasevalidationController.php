<?php

class DatabasevalidationController extends BaseController implements PageControllerInterface
{

    public function index(): void
    {
        $connected = false;
        $error = '';

        if ($_POST) {
            $dbConnection = $this->validateDatabaseConnection();

            if ($dbConnection instanceof PDO) {
                $connected = true;
                $_SESSION['mysql_information'] = $this->request;
            }

            if ($dbConnection instanceof PDOException) {
                $connected = false;
                $error = $dbConnection->getMessage();
            }
        }

        $this->render('databasevalidation', [
            'dbConnection' => $dbConnection ?? false,
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
}