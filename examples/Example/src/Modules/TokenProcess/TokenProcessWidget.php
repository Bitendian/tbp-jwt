<?php

namespace Bitendian\JWT\Example\Modules\TokenProcess;

use Bitendian\JWT\Server\Modules\Auth\Auth;
use Bitendian\TBP\TBPException;
use Bitendian\TBP\UI\AbstractWidget;
use Bitendian\TBP\UI\Templater;
use Bitendian\TBP\Utils\Config;

class TokenProcessWidget extends AbstractWidget
{
    public $token;
    public $check;
    public $checkMessage;
    public $checkColor;
    public $data;
    public $dataJson;

    public $user = 'example';
    public $password = 'example';

    public function fetch(&$params)
    {
        $config = new Config(__CONFIG_DIR__);
        $authConfig = $config->getConfig('auth');

        $auth = new Auth($authConfig->secretKey, $authConfig->encrypt);

        if ($this->user == 'example' && $this->password == 'example') {
            $this->token = $auth->generateToken(['user' => $this->user]);

            try {
                $this->check = $auth->checkToken($this->token);
                $this->data = $auth->getData($this->token);
            } catch (TBPException $e) {
                $this->check = false;
                $this->checkMessage = 'ERROR -> ' . $e->getMessage();
            }
        }
    }

    public function render()
    {
        if ($this->check) {
            $this->checkMessage = 'CORRECT';
            $this->checkColor = 'green';
            $this->dataJson = json_encode($this->data);
        } else {
            $this->checkColor = 'red';
        }
        return new Templater(__DIR__ . DIRECTORY_SEPARATOR . 'TokenProcess.template', $this);
    }
}
