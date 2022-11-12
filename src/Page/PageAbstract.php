<?php

namespace Dupot\StaticGenerationFramework\Page;

abstract class PageAbstract
{
    protected $paramList = [];

    public function renderLayoutWithParamList(string $layoutPath, array $paramList): string
    {

        $this->paramList = $paramList;

        ob_start();
        include($layoutPath);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function generateTo(string $generationPath): void
    {
        file_put_contents($generationPath . '/' . $this->getFilename(), $this->render());
    }
}
