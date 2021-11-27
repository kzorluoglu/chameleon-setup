<?php

class CreateadminController extends BaseController implements PageControllerInterface
{

    private const CMS_DEFAULT_LANGUAGE_ID = 24;

    public function index(): void
    {
        $created = false;
        $error = '';

        if ($_POST) {
            $pdo = $this->getPDO(
                $_SESSION['mysql_information']['mysql_host'],
                $_SESSION['mysql_information']['mysql_port'],
                $_SESSION['mysql_information']['mysql_databaseName'],
                $_SESSION['mysql_information']['mysql_username'],
                $_SESSION['mysql_information']['mysql_password'],
            );

            /** @var bool|array $status */
            $user = $this->createUser(
                $pdo,
                $this->getUUID(),
                $this->request['admin_username'],
                $this->request['admin_email'],
                $this->getPasswordHash($this->request['admin_password'])
            );

            if($user === true) {
                $created = true;
            }

            if ($user instanceof \Exception) {
                $error = $user->getMessage();
            }
        }

        $this->render('createadmin', [
            'created' => $created,
            'error' => $error,
        ]);
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


    /**
     * @return bool|PDOException
     */
    private function createUser(PDO $pdo, string $userId, string $username, string $password, string $email)
    {

        $query = sprintf(
            "INSERT INTO `cms_user` 
    (`id`, `cmsident`, `email`, `login`,  `crypted_pw`, `name`, `cms_language_id`, `languages`,
     `images`, `cms_current_edit_language`,
     `allow_cms_login`, `task_show_count`, `is_system`,
     `show_as_rights_template`, `user_tbl_conf_hidden`,
     `cms_workflow_transaction_id`) 
     VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s',
             '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            $userId,
            1,
            $email,
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
            '1',
            null,
            null,
        );

        try {
            $pdo->exec($query);
            return true;
        } catch (\PDOException $e) {
            return $e;
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