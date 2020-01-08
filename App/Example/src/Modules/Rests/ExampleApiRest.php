<?php

namespace Bitendian\JWT\Example\Modules\Rests;

use Bitendian\JWT\Server\Modules\Auth\Auth;
use Bitendian\TBP\REST\AbstractAPIRest;
use Bitendian\TBP\TBPException;
use Bitendian\TBP\Utils\Config;

class ExampleApiRest extends AbstractAPIRest
{

    /**
     * @inheritDoc
     */
    protected function get(&$params)
    {
        if (!isset($params['token']) || !$this->validateToken($params['token'])) {
            return $this->setInvalidToken();
        }

        return json_encode(['message' => 'This is valid response for get request']);
    }

    /**
     * @inheritDoc
     */
    protected function put(&$params)
    {
        if (!isset($params['token']) || !$this->validateToken($params['token'])) {
            return $this->setInvalidToken();
        }

        return json_encode(['message' => 'This is valid response for put request']);
    }

    /**
     * @inheritDoc
     */
    protected function delete(&$params)
    {
        if (!isset($params['token']) || !$this->validateToken($params['token'])) {
            return $this->setInvalidToken();
        }

        return json_encode(['message' => 'This is valid response for delete request']);
    }

    /**
     * @inheritDoc
     */
    protected function post(&$params)
    {
        if (!isset($params['token']) || !$this->validateToken($params['token'])) {
            return $this->setInvalidToken();
        }

        return json_encode(['message' => 'This is valid response for post request']);
    }

    private function validateToken($token)
    {
        $config = new Config(__CONFIG_DIR__);
        $authConfig = $config->getConfig('auth');

        $auth = new Auth($authConfig->secretKey, $authConfig->encrypt);
        try {
            $auth->checkToken($token);
        } catch (TBPException $e) {
            return false;
        }

        return true;
    }

    private function setInvalidToken()
    {
        $this->setResponseStatus(401);
        return json_encode(['error' => 'Token not valid']);
    }
}