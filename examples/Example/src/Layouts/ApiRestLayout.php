<?php

namespace Bitendian\JWT\Example\Layouts;

use Bitendian\TBP\REST\AbstractAPIRest;
use Bitendian\TBP\UI\AbstractWidget;
use Bitendian\TBP\Utils\SystemMessages;

class ApiRestLayout extends AbstractWidget
{
    private $apiComponent;

    /**
     * ApiRestLayout constructor.
     * @param  AbstractAPIRest $api
     */
    public function __construct($api)
    {
        $this->apiComponent = $api;
    }

    /**
     * @param int $severity
     * @param string $message
     * @param string $filename
     * @param int $lineno
     * @throws \ErrorException
     */
    public function exceptions_error_handler($severity, $message, $filename, $lineno)
    {
        if (error_reporting() == 0) {
            return;
        }
        if (error_reporting() & $severity) {
            throw new \ErrorException($message, 0, $severity, $filename, $lineno);
        }
    }

    public function fetch(&$params)
    {
        foreach ($params as $key => &$value) {
            $this->apiComponent->addParam($key, $value);
        }
        try {
            // convert all notices in exceptions
            set_error_handler([$this, 'exceptions_error_handler']);
            // do stuff
            $this->apiComponent->processAPI();
        } catch (\Exception $e) {
            SystemMessages::addError('Exception: ' . $e->getMessage() . ' at ' . $e->getFile() . ' (' . $e->getLine() . ')');
        } finally {
            // restore error handler
            restore_error_handler();
        }
    }

    public function render()
    {
        return $this->apiComponent->getResponseData();
    }
}