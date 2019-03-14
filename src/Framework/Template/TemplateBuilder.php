<?php

namespace Romano\Framework\Template;

use Romano\Framework\Exception\UnknownTemplateEngineException;

class TemplateBuilder
{
    private $renderBlocks;

    private $options = [
        'twig' => [
            'extends' => '{% extends "$1" %}',
            'block' => "{% block $1 %}\n$2{% endblock %}",
            'include' => '{% include "$1" %}',
            'comment' => "{# $1 #}\n\n",
        ]
    ];

    /**
     * TemplateBuilder constructor.
     *
     * @param string $engine
     *
     * @throws UnknownTemplateEngineException
     */
    public function __construct(string $engine = 'twig')
    {
        if (!isset($this->options[$engine])) {
            throw new UnknownTemplateEngineException($engine);
        }

        $this->options = $this->options[$engine];
    }

    public function render(): string
    {
        $render = '';

        foreach ($this->renderBlocks as $renderBlock) {
            $blockType = key($renderBlock);
            $blockValue = $renderBlock[$blockType];

            switch ($blockType) {
                case 'comment':
                    $render .= str_replace('$1', $blockValue, $this->options['comment']);
                    break;
                case 'extends':
                    $render .= str_replace('$1', $blockValue, $this->options['extends']);
                    break;
                case 'block':
                    $render .= str_replace(['$1', '$2'], $blockValue, $this->options['block']). "\n";
                    break;
            }
        }

        return $render;
    }

    public function addComment(string $comment): void
    {
        $this->renderBlocks[]['comment'] = $comment;
    }

    public function addBlock(array $block): void
    {
        $this->renderBlocks[]['block'] = $block;
    }

    # only one extend is allowed
    public function extends(string $extend): void
    {
        $this->renderBlocks[]['extends'] = $extend;
    }
}