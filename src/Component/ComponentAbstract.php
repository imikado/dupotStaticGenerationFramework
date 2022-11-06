<?php

namespace Dupot\StaticGenerationFramework\Component;

abstract class ComponentAbstract
{
    protected $paramList = [];

    public function renderViewWithParamList(string $viewPath, array $paramList)
    {
        $this->paramList = $paramList;

        ob_start();
        include($viewPath);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
