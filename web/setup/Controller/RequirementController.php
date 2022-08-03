<?php

class RequirementController extends BaseController implements PageControllerInterface
{

    private float $requiredPhpVersion = 7.4;
    private array $requiredPhpExtensions = ['curl', /*'memcached',*/
        'mbstring', 'mysqli', 'pdo_mysql', 'zip', 'tidy'];


    /**
     * @throws JsonException
     */
    public function index(): void
    {
        $phpVersionRequirements = [
            'required' => $this->requiredPhpVersion,
            'installed_version' => PHP_VERSION,
            'passed' => (PHP_VERSION >= $this->requiredPhpVersion),
        ];

        $installedPhpExtensions = $this->checkSystemRequirementsStep();

        $installable = $this->isInstallable($phpVersionRequirements, $installedPhpExtensions);

        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'phpVersionRequirements' => $phpVersionRequirements,
            'installable' => $installable,
            'system_requirements' => $installedPhpExtensions,
        ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        exit;
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
            if ($requiredPhpExtension['passed'] === false) {
                $installable = false;
                continue;
            }
        }

        return $installable;
    }
}
