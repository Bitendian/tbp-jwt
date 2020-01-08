<?php

namespace Bitendian\JWT\Example\Modules\GenerateToken;

use Bitendian\JWT\Server\Modules\Auth\Auth;
use Bitendian\TBP\UI\AbstractWidget;
use Bitendian\TBP\UI\Templater;
use Bitendian\TBP\Utils\Config;

class GenerateTokenWidget extends AbstractWidget
{
    public $token;

    public function fetch(&$params)
    {
        $config = new Config(__CONFIG_DIR__);
        $authConfig = $config->getConfig('auth');

        $auth = new Auth($authConfig->secretKey, $authConfig->encrypt);
        $this->token = $auth->generateToken([]);
    }

    public function render()
    {
        return new Templater(__DIR__ . DIRECTORY_SEPARATOR . 'GenerateToken.template', $this);
    }
}
