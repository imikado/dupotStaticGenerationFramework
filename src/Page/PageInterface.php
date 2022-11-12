<?php

namespace Dupot\StaticGenerationFramework\Page;

interface PageInterface
{
    public function getFilename(): string;
    public function render(): string;
}
