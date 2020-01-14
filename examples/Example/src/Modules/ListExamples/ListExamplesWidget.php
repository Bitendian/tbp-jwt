<?php

namespace Bitendian\JWT\Example\Modules\ListExamples;

use Bitendian\TBP\UI\AbstractWidget;
use Bitendian\TBP\UI\Templater;
use Bitendian\TBP\Utils\Router;

class ListExamplesWidget extends AbstractWidget
{
    public $examples;

    public function fetch(&$params)
    {
        $this->examples = [];
        $context = new \stdClass();

        $context->Href = Router::getRoute('generate-token', 'en_US.UTF8');
        $context->Name = 'Generate token';
        $this->examples[] = new Templater(__DIR__ . DIRECTORY_SEPARATOR . 'Example.template', $context);

        $context->Href = Router::getRoute('token-process', 'en_US.UTF8');
        $context->Name = 'Token process';
        $this->examples[] = new Templater(__DIR__ . DIRECTORY_SEPARATOR . 'Example.template', $context);

        $context->Href = Router::getRoute('client-flow', 'en_US.UTF8');
        $context->Name = 'Client flow';
        $this->examples[] = new Templater(__DIR__ . DIRECTORY_SEPARATOR . 'Example.template', $context);
    }

    public function render()
    {
        return new Templater(__DIR__ . DIRECTORY_SEPARATOR . 'ListExamples.template', $this);
    }
}
