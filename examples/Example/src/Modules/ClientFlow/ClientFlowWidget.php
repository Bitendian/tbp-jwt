<?php

namespace Bitendian\JWT\Example\Modules\ClientFlow;

use Bitendian\JWT\Client\Modules\Client;
use Bitendian\TBP\UI\AbstractWidget;
use Bitendian\TBP\UI\Templater;
use Bitendian\TBP\Utils\Router;

class ClientFlowWidget extends AbstractWidget
{
    public $authUrl;
    public $exampleUrl;
    public $username = 'example';
    public $password = 'example';
    public $token;
    public $getResponse;
    public $postResponse;
    public $putResponse;
    public $deleteResponse;

    public function __construct()
    {
        $this->authUrl = 'http://' . $_SERVER['SERVER_NAME'] . Router::getRoute('api-auth', 'en_US.UTF8');
        $this->exampleUrl = 'http://' . $_SERVER['SERVER_NAME'] . Router::getRoute('api-example', 'en_US.UTF8');
    }

    public function fetch(&$params)
    {
        // try Auth
        $client = new Client();
        $responseJson = $client->auth($this->authUrl, $this->username, $this->password);
        $response = json_decode($responseJson);
        if (isset($response->token)) {
            $this->token = $response->token;
            $client->setToken($this->token);
        }

        // try Get
        $this->getResponse = $client->get($this->exampleUrl);
        $this->postResponse = $client->post($this->exampleUrl);
        $this->putResponse = $client->put($this->exampleUrl);
        $this->deleteResponse = $client->delete($this->exampleUrl);
    }

    public function render()
    {
        return new Templater(__DIR__ . DIRECTORY_SEPARATOR . 'ClientFlow.template', $this);
    }
}