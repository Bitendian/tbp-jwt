<?php

namespace Bitendian\JWT\Example\Layouts;

use Bitendian\TBP\UI\AbstractWidget;
use Bitendian\TBP\UI\Templater;

class EmptyLayout extends AbstractWidget
{
    public $component;

    /**
     * EmptyLayout constructor.
     * @param $component AbstractWidget
     */
    public function __construct($component)
    {
        $this->component = $component;
    }

    public function fetch(&$params)
    {
        $this->component->fetch($params);
    }

    public function render()
    {
        return new Templater(__DIR__ . DIRECTORY_SEPARATOR . 'EmptyLayout.template', $this);
    }
}
