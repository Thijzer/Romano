<?php

namespace Romano\Framework\Resource;

use Romano\Framework\File\File;
use Romano\Framework\Template\TemplateBuilder;

class ResourceManager
{
    private $scopeCollection = [];
    /** @var TemplateBuilder */
    private $templateBuilder;

    public function __construct(TemplateBuilder $templateBuilder)
    {
        $this->templateBuilder = $templateBuilder;
    }

    public function renderScopeData($controller)
    {
        if (isset($this->scopeCollection[$controller])) {
            return $this->scopeCollection[$controller];
        }

        list($ctrl, $method) = explode('@', $controller);

        if (\is_callable($class = ucfirst($ctrl), $method)) {
            $class = new $class();
            $this->scopeCollection[$controller] = $class->$method();
        }
    }

    public function render(Resource $resource, string $storePath)
    {
        if (!$resource->hasBlocks()) {
            leave('no html blocks defined');
        }

        $baseCacheFile = new File(path('view_cache'). $storePath);

        $this->templateBuilder->addComment('Generated file from Resource :: '.date('F Y'));

        $this->templateBuilder->extends($resource->getBaseFile());

        if ($resource->isLocked()) {
            $this->templateBuilder->addComment('locked');
        }

        foreach ($resource->getBlocks() as $blockName => $blockParts) {
            $content = '';
            foreach ($blockParts as $blockPart) {
                if (!$blockPart->exists()) {
                    leave($blockPart->filename.' is not a real block');
                }
                $content .= $blockPart->getContent();
            }
            $this->templateBuilder->addBlock([$blockName, $content]);
        }

        $render = $this->templateBuilder->render();

//        if (!$baseCacheFile->exists()) {
//            if (!is_dir($baseCacheFile->getDirectory())) {
//                mkdir($baseCacheFile->getDirectory());
//            }
//            $baseCacheFile->setContent($render)->save();
//        } elseif ($baseCacheFile->getHash()->isGeneratedFrom($render)) {
//            $baseCacheFile->setContent($render)->save();
//        }

        return $render;
    }

    public function getCollectedData(Resource $resource): array
    {
        return array_merge(...array_map(function ($controller) {
            return $this->renderScopeData($controller);
        }, array_merge(...$resource->getScopes())));
    }
}


//    public function addToScope($name, $scope): void
//    {
//        $this->collectedData = array_merge($this->collectedData, array($name => $scope));
//    }