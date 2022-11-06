<?php

namespace Dupot\StaticGenerationFramework\Page;

use Exception;

abstract class PageAbstract
{
    protected $filename = null;
    protected $paramList = [];

    public function getFilename(): string
    {
        if ($this->filename === null) {
            throw new Exception('missing protected $filename in your Page class');
        }
        return $this->filename;
    }

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
