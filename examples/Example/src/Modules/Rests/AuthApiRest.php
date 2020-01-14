<?php

namespace Bitendian\JWT\Example\Modules\Rests;

use Bitendian\JWT\Server\Modules\Auth\Auth;
use Bitendian\TBP\REST\AbstractAPIRest;
use Bitendian\TBP\Utils\Config;

class AuthApiRest extends AbstractAPIRest
{

    /**
     * @inheritDoc
     */
    protected function get(&$params)
    {
        // use your own user validation
        if (!isset($params['username']) || !isset($params['password'])) {
            $this->setResponseStatus(500);
            return json_encode(['error' => 'Fields can not be empty']);
        }

        if ($params['username'] != 'example' || $params['password'] != 'example') {
            $this->setResponseStatus(401);
            return json_encode(['error' => 'User not valid']);
        }

        $config = new Config(__CONFIG_DIR__);
        $authConfig = $config->getConfig('auth');

        $auth = new Auth($authConfig->secretKey, $authConfig->encrypt);
        return json_encode(['token' => $auth->generateToken(['user' => $params['username']])]);
    }

    /**
     * @inheritDoc
     */
    protected function put(&$params)
    {
        // TODO: Implement put() method.
    }

    /**
     * @inheritDoc
     */
    protected function delete(&$params)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    protected function post(&$params)
    {
        // TODO: Implement post() method.
    }
}