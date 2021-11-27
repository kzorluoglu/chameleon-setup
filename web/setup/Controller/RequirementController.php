<?php

class RequirementController extends BaseController implements PageControllerInterface
{

    private float $requiredPhpVersion = 7.4;
    private array $requiredPhpExtensions = [ 'curl', /*'memcached',*/ 'mbstring', 'mysqli', 'pdo_mysql', 'zip', 'tidy'];

    public function index(): void
    {
        $phpVersionRequirements = [
            'required' => $this->requiredPhpVersion,
            'installed_version' => PHP_VERSION,
            'passed' => (PHP_VERSION >= $this->requiredPhpVersion),
        ];

        $installable = $this->isInstallable($phpVersionRequirements, $this->requiredPhpExtensions);

        $this->render('install', [
            'title' => 'Requirements',
            'phpVersionRequirements' => $phpVersionRequirements,
            'installable' => $installable,
            'system_requirements' => $this->checkSystemRequirementsStep(),
        ]);
    }

    public function checkSystemRequirementsStep()
    {
        $installedPhpExtensions = [];
        foreach ($this->requiredPhpExtensions as $requiredPhpExtension) {
            $installedPhpExtensions[] = [
                'name' => $requiredPhpExtension,
                'passed' => extension_loaded($requiredPhpExtension),
            ];
        }

        return $installedPhpExtensions;
    }

    private function isInstallable(array $phpVersionRequirements, array $requiredPhpExtensions)
    {
        $installable = $phpVersionRequirements['passed'];
        foreach ($requiredPhpExtensions as $requiredPhpExtension) {
            if(extension_loaded($requiredPhpExtension) === false) {
                $installable = false;
                continue;
            }
        }

        return $installable;
    }
}