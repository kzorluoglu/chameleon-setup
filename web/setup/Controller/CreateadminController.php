<?php

class CreateadminController extends BaseController implements PageControllerInterface
{

    private CMSUser $cmsUser;

    public function __construct(array $request)
    {
        parent::__construct($request);

        require_once SetupTool::SETUP_TOOL_PATH.'/Model/CMSUser.php';

        $this->cmsUser = new CMSUser();
    }

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

            $this->cmsUser->setId($this->getUUID());
            $this->cmsUser->setLogin($this->request['admin_username']);
            $this->cmsUser->setName($this->request['admin_username']);
            $this->cmsUser->setCryptedPassword($this->getPasswordHash($this->request['admin_password']));
            $this->cmsUser->setEmail($this->request['admin_email']);

            /** @var bool|array $status */
            $user = $this->createUser($pdo, $this->cmsUser);

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
    private function createUser(PDO $pdo, CMSUser $cmsUser)
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

        $statement->bindValue(':id', $cmsUser->getId(), PDO::PARAM_STR);
        $statement->bindValue(':cmsident', $cmsUser->getCmsIdent(), PDO::PARAM_STR);
        $statement->bindValue(':email', $cmsUser->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(':login', $cmsUser->getLogin(), PDO::PARAM_STR);
        $statement->bindValue(':crypted_pw', $cmsUser->getCryptedPassword(), PDO::PARAM_STR);
        $statement->bindValue(':name', $cmsUser->getName(), PDO::PARAM_STR);

        $statement->bindValue(':cms_language_id', $cmsUser->getCmsLanguageId(), PDO::PARAM_INT);
        $statement->bindValue(':languages', $cmsUser->getLanguages(), PDO::PARAM_STR);
        $statement->bindValue(':images', $cmsUser->getImages(), PDO::PARAM_INT);
        $statement->bindValue(':cms_current_edit_language', $cmsUser->getCmsCurrentEditLanguage(), PDO::PARAM_STR);
        $statement->bindValue(':allow_cms_login', $cmsUser->getAllowCMSLogin(), PDO::PARAM_INT);
        $statement->bindValue(':task_show_count', $cmsUser->getTaskShowCount(), PDO::PARAM_INT);
        $statement->bindValue(':is_system', $cmsUser->getIsSystem(), PDO::PARAM_INT);
        $statement->bindValue(':show_as_rights_template', $cmsUser->getShowAsRightsTemplate(), PDO::PARAM_INT);
        $statement->bindValue(':user_tbl_conf_hidden', $cmsUser->getUserTblConfHidden(), PDO::PARAM_INT);
        $statement->bindValue(':cms_workflow_transaction_id', $cmsUser->getCmsWorkflowTransactionId() , PDO::PARAM_INT);

        try {
            $statement->execute();
            $pdo->commit();

            return true;
        } catch (\PDOException $e) {
            $pdo->rollBack();
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
