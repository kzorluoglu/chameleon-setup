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
                $_SESSION['mysql_information']['mysql_database_name'],
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

            if ($user === true) {
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
        $pdo->beginTransaction();
        $statement = $pdo->prepare(
            'INSERT INTO `cms_user` 
    (`id`, `cmsident`, `email`, `login`,  `crypted_pw`, `name`, `cms_language_id`, `languages`,
     `images`, `cms_current_edit_language`,
     `allow_cms_login`, `task_show_count`, `is_system`,
     `show_as_rights_template`, `user_tbl_conf_hidden`,
     `cms_workflow_transaction_id`) 
     VALUES
            (:id, :cmsident, :email, :login, :crypted_pw, :name, :cms_language_id, :languages,
             :images, :cms_current_edit_language,
             :allow_cms_login, :task_show_count, :is_system,
             :show_as_rights_template, :user_tbl_conf_hidden,
             :cms_workflow_transaction_id)'
        );

        $defaultIdValue = 1;
        $randomInt = random_int($defaultIdValue, 999999999);
        $CMSDEFAULTLANGUAGEID = self::CMS_DEFAULT_LANGUAGE_ID;
        $defaultLanguage = 'en';
        $defaultNullValue = null;
        $taskShowCount = 10;

        $statement->bindParam(':id', $userId, PDO::PARAM_STR);
        $statement->bindParam(':cmsident', $randomInt, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':login', $username, PDO::PARAM_STR);
        $statement->bindParam(':crypted_pw', $password, PDO::PARAM_STR);
        $statement->bindParam(':name', $username, PDO::PARAM_STR);

        $statement->bindParam(':cms_language_id', $CMSDEFAULTLANGUAGEID, PDO::PARAM_INT);
        $statement->bindParam(':languages', $defaultLanguage, PDO::PARAM_STR);
        $statement->bindParam(':images', $defaultIdValue, PDO::PARAM_INT);
        $statement->bindParam(':cms_current_edit_language', $defaultLanguage, PDO::PARAM_INT);
        $statement->bindParam(':allow_cms_login', $defaultIdValue, PDO::PARAM_INT);
        $statement->bindParam(':task_show_count', $taskShowCount, PDO::PARAM_INT);
        $statement->bindParam(':is_system', $defaultIdValue, PDO::PARAM_INT);
        $statement->bindParam(':show_as_rights_template', $defaultIdValue, PDO::PARAM_INT);
        $statement->bindParam(':user_tbl_conf_hidden', $defaultIdValue, PDO::PARAM_INT);
        $statement->bindParam(':cms_workflow_transaction_id', $defaultIdValue , PDO::PARAM_INT);

        try {
            $statement->execute();

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
