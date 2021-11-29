<?php

use Symfony\Component\Yaml\Yaml;

require_once SetupTool::SETUP_TOOL_PATH.'/../../vendor/autoload.php';

class CheckconfigController extends BaseController implements PageControllerInterface
{

    private const PARAMETERS_YAML_PATH =  SetupTool::SETUP_TOOL_PATH.'/../../app/config';
    private const PARAMETERS_YAML_FILE_PATH = self::PARAMETERS_YAML_PATH.'/parameters.yml';
    private const PARAMETERS_YAML_FILE_PATH_DIST = self::PARAMETERS_YAML_PATH.'/parameters.yml.dist';
    private ArrayIterator $configs;

    public function __construct(array $request)
    {
        parent::__construct($request);

        if(empty($this->configs) === true) {
            $this->createConfigs();
        }
    }

    public function index(): void
    {
        $checked = false;
        if ($_POST) {
            $savedConfig = $this->saveConfig();

            if($savedConfig === true) {
                $checked = true;
            }
        }

        $this->render('checkconfig', [
            'configs' => $this->getConfigs(),
            'checked' => $checked
        ]);
    }

    /**
     * @return ArrayIterator|bool
     */
    private function getConfigs()
    {

        if($this->configs !== null) {
            return $this->configs;
        }

        if (file_exists(self::PARAMETERS_YAML_FILE_PATH)) {
            return $this->readConfig();
        }

        return false;
    }

    private function createConfigs()
    {
        if($this->createParametersYamlFile() === false) {
            $this->render('checkconfig', [
                'error' => 'Could not create parameters.yaml file'
            ]);
        }

        $this->setConfig($this->readConfig());
        $this->updateDatabaseConfigs();
    }

    private function createParametersYamlFile(): bool
    {
        return copy(self::PARAMETERS_YAML_FILE_PATH_DIST,self::PARAMETERS_YAML_FILE_PATH) === true;
    }

    private function readConfig(): ArrayIterator
    {
        return new ArrayIterator(Yaml::parseFile(self::PARAMETERS_YAML_FILE_PATH));
    }

    private function updateDatabaseConfigs()
    {
        $configs  = (array)$this->getConfigs();
        $configs['parameters']['database_host'] = $_SESSION['mysql_information']['mysql_host'];
        $configs['parameters']['database_port'] = $_SESSION['mysql_information']['mysql_port'];
        $configs['parameters']['database_name'] = $_SESSION['mysql_information']['mysql_databaseName'];
        $configs['parameters']['database_user'] = $_SESSION['mysql_information']['mysql_username'];
        $configs['parameters']['database_password'] = $_SESSION['mysql_information']['mysql_password'];
        $this->configs = new ArrayIterator($configs);
    }

    public function setConfig(ArrayIterator $configs): void
    {
        $this->configs = $configs;
    }

    public function saveConfig(): bool
    {
        /** remove default page from request array */
        unset($this->request['page']);

        $configArray = $this->preparePostedConfigs();
        $newYamlDump = Yaml::dump($configArray);
        $saved = file_put_contents(self::PARAMETERS_YAML_FILE_PATH, $newYamlDump);

        if ($saved === false) {
            return false;
        }
        return true;
    }

    private function preparePostedConfigs(): array
    {
        $configArray = [];
        foreach ($this->request as $key => $value) {
            if (is_array($value) === false) {
                $configArray[$key] = $value;
                continue;
            }

            foreach ($value as $subValue)
            {
                $configArray[$key][$subValue['key']] = $subValue['value'];
            }
        }

        return $configArray;
    }
}