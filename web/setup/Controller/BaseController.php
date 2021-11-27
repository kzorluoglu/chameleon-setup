<?php

class BaseController
{

    protected array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function render($view, $data = [])
    {
        extract($data);
        require_once SetupTool::SETUP_TOOL_PATH.'/View/' . $view . '.php';
    }
}