<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header('Content-type: application/json');

class Setup
{
    const CMS_DEFAULT_LANGUAGE_ID = 24;
    private float $requiredPhpVersion = 7.0;
    private array $requiredPhpExtensions = [ 'curl', 'memcached', 'mbstring', 'mysqli', 'pdo_mysql', 'zip', 'tidy'];

    public function checkExtensionLoaded(string $extension): bool
    {
        return extension_loaded($extension);
    }

    public function checkSystemRequirementsStep()
    {
        $responseData = [];
        foreach ($this->requiredPhpExtensions as $requiredPhpExtension) {
            $responseData['installedPhpExtensions'][] = [
                'name' => $requiredPhpExtension,
                'installed' => extension_loaded($requiredPhpExtension),
            ];
        }

        $responseData['phpVersion'] = [
            'required' => $this->requiredPhpVersion,
            'installed_version' => PHP_VERSION,
            'installed' => (PHP_VERSION >= $this->requiredPhpVersion),
        ];

        return $this->returnResponse($responseData);
    }

    private function returnResponse(array $response)
    {
        return \json_encode($response);
    }

    public function checkDatabaseConnectionStep()
    {
        $bodyDataArray = \json_decode(file_get_contents('php://input'), TRUE);

        $responseData['databaseConnection'] = [];
        if(empty($bodyDataArray) === false) {
            $responseData['databaseConnection'] = $this->connectDatabase($bodyDataArray);
        }

        return $this->returnResponse($responseData);
    }

    private function connectDatabase(array $bodyDataArray): array
    {
        try {
            $this->getPDO($bodyDataArray);

            return [
                'connection' => true,
            ];
        } catch (\PDOException $e) {
            return [
                'connection' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function installDatabaseStep()
    {
        $bodyDataArray = \json_decode(file_get_contents('php://input'), TRUE);
        $pdo = $this->getPDO($bodyDataArray);

        $databaseFile = $this->readDatabaseFile();

        $sqlLines = explode(";\n", $databaseFile);
        foreach ($sqlLines as $key => $val) {
            try {
                $pdo->exec($val);
            }catch (\PDOException $e) {
                return $this->returnResponse([
                    'status' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        return $this->returnResponse([
            'status' => true
        ]);

    }

    private function getPDO(array $bodyDataArray): PDO
    {
        $pdoConenctionString = sprintf(
            'mysql:host=%s:%s;dbname=%s',
            $bodyDataArray['mysqlHost'],
            $bodyDataArray['mysqlPort'],
            $bodyDataArray['mysqlDatabaseName']
        );

        return new \PDO(
            $pdoConenctionString,
            $bodyDataArray['mysqlUsername'],
            $bodyDataArray['mysqlPassword'],
            [PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    /**
     * @return false|string
     */
    private function readDatabaseFile()
    {
        $path = __DIR__."/setup/database/shop-database.sql";
        if(false === file_exists($path)) {
            throw new \Exception(sprintf("Database file (%s) not found.", $path));
        }
        return file_get_contents($path);
    }

    public function createAdminStep()
    {
        $bodyDataArray = \json_decode(file_get_contents('php://input'), TRUE);
        $pdo = $this->getPDO($bodyDataArray);
        $userId = $this->getUUID();
        $username = $bodyDataArray['adminUsername'];
        $password = $this->getPasswordHash($bodyDataArray['adminPassword']);

        return $this->returnResponse($this->createUser($pdo, $userId, $username, $password));
    }

    /**
     * @param $adminPassword
     * @return false|string|null
     */
    private function getPasswordHash($adminPassword)
    {
        return password_hash($adminPassword, PASSWORD_BCRYPT, [
            'cost' => 10,
        ]);
    }

    private function createUser(PDO $pdo, string $userId, string $username, string $password): array
    {
        $query = sprintf(
            "INSERT INTO `cms_user` 
    (`id`, `cmsident`, `login`, `crypted_pw`, `name`, `cms_language_id`, `languages`,
     `images`, `cms_current_edit_language`, `allow_cms_login`, `task_show_count`, `is_system`, `show_as_rights_template`) 
     VALUES ('%s', 'null', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            $userId,
            $username,
            $password,
            $username,
            self::CMS_DEFAULT_LANGUAGE_ID,
            'en',
            '1',
            'en',
            '1',
            '5',
            '1',
            '1'
        );

        try {
            $pdo->exec($query);
            return [
                'status' => true,
            ];
        } catch (\PDOException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    private function getUUID()
    {
        $chars = bin2hex(random_bytes(16));
        $uuid = substr($chars, 0, 8).'-';
        $uuid .= substr($chars, 8, 4).'-';
        $uuid .= substr($chars, 12, 4).'-';
        $uuid .= substr($chars, 16, 4).'-';
        $uuid .= substr($chars, 20, 12);
        return $uuid;
    }

}


$setup = new Setup();
if($_REQUEST['step'] === 'CheckSystemRequirements')
{
    echo $setup->checkSystemRequirementsStep();
}

if($_REQUEST['step'] === 'checkDatabase')
{
    echo $setup->checkDatabaseConnectionStep();
}

if($_REQUEST['step'] === 'InstallDatabase')
{
    echo $setup->installDatabaseStep();
}

if($_REQUEST['step'] === 'createAdmin')
{
    echo $setup->createAdminStep();
}
