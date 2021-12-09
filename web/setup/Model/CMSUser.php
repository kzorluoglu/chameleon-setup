<?php

class CMSUser
{
    private const CMS_DEFAULT_LANGUAGE_ID = 24;
    private const LANGUAGE = 'de';

    private string $id;
    private string $cmsIdent;
    private string $email;
    private string $login;
    private string $cryptedPassword;
    private string $name;
    private string $cmsLanguageId;
    private string $languages;
    private string $cmsCurrentEditLanguage;
    private int $allowCMSLogin;
    private int $taskShowCount;
    private int $isSystem;
    private int $showAsRightsTemplate;
    private int $userTblConfHidden;
    private int $cmsWorkflowTransactionId;
    private string $images;

    public function __construct()
    {
        $this->id = 1;
        $this->cmsIdent = random_int(1, 999999999);
        $this->cmsLanguageId = self::CMS_DEFAULT_LANGUAGE_ID;
        $this->languages = self::LANGUAGE;
        $this->cmsCurrentEditLanguage = self::LANGUAGE;
        $this->allowCMSLogin = 1;
        $this->taskShowCount = 5;
        $this->images = 1;
        $this->isSystem = 1;
        $this->showAsRightsTemplate = 1;
        $this->userTblConfHidden = 1;
        $this->cmsWorkflowTransactionId = 1;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getCmsIdent(): string
    {
        return $this->cmsIdent;
    }

    public function setCmsIdent(string $cmsIdent): void
    {
        $this->cmsIdent = $cmsIdent;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getCryptedPassword(): string
    {
        return $this->cryptedPassword;
    }

    public function setCryptedPassword(string $cryptedPassword): void
    {
        $this->cryptedPassword = $cryptedPassword;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCmsLanguageId()
    {
        return $this->cmsLanguageId;
    }

    public function setCmsLanguageId($cmsLanguageId): void
    {
        $this->cmsLanguageId = $cmsLanguageId;
    }

    public function getLanguages(): string
    {
        return $this->languages;
    }

    public function setLanguages(string $languages): void
    {
        $this->languages = $languages;
    }

    public function getCmsCurrentEditLanguage(): string
    {
        return $this->cmsCurrentEditLanguage;
    }

    public function setCmsCurrentEditLanguage(string $cmsCurrentEditLanguage): void
    {
        $this->cmsCurrentEditLanguage = $cmsCurrentEditLanguage;
    }

    public function getAllowCMSLogin(): int
    {
        return $this->allowCMSLogin;
    }

    public function setAllowCMSLogin(int $allowCMSLogin): void
    {
        $this->allowCMSLogin = $allowCMSLogin;
    }

    public function getTaskShowCount(): int
    {
        return $this->taskShowCount;
    }

    public function setTaskShowCount(int $taskShowCount): void
    {
        $this->taskShowCount = $taskShowCount;
    }

    public function getIsSystem(): int
    {
        return $this->isSystem;
    }

    public function setIsSystem(int $isSystem): void
    {
        $this->isSystem = $isSystem;
    }

    public function getShowAsRightsTemplate(): int
    {
        return $this->showAsRightsTemplate;
    }

    public function setShowAsRightsTemplate(int $showAsRightsTemplate): void
    {
        $this->showAsRightsTemplate = $showAsRightsTemplate;
    }

    public function getUserTblConfHidden(): int
    {
        return $this->userTblConfHidden;
    }

    public function setUserTblConfHidden(int $userTblConfHidden): void
    {
        $this->userTblConfHidden = $userTblConfHidden;
    }

    public function getCmsWorkflowTransactionId(): int
    {
        return $this->cmsWorkflowTransactionId;
    }

    public function setCmsWorkflowTransactionId(int $cmsWorkflowTransactionId): void
    {
        $this->cmsWorkflowTransactionId = $cmsWorkflowTransactionId;
    }

    public function getImages(): string
    {
        return $this->images;
    }

    public function setImages(string $images): void
    {
        $this->images = $images;
    }

}
