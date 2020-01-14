<?php

namespace Bitendian\JWT\Client\Modules;

class Client
{
    private $token;
    private $lastError;

    public function auth($url, $username, $password)
    {
        $url = $this->addCredentialsToUrl($url, $username, $password);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($response === false) {
            $this->lastError =  curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }

    public function get($url, $data = [])
    {
        $url = $this->addTokenToUrl($url, $data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($response === false) {
            $this->lastError =  curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }

    public function post($url, $data = [])
    {
        $url = $this->addTokenToUrl($url);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($response === false) {
            $this->lastError =  curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }

    public function put($url, $data = [])
    {
        $url = $this->addTokenToUrl($url);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        if ($response === false) {
            $this->lastError =  curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }

    public function delete($url, $data = [])
    {
        $url = $this->addTokenToUrl($url);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($response === false) {
            $this->lastError =  curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * @param string $url
     * @param array $data
     * @return string
     */
    private function addTokenToUrl($url, &$data = [])
    {
        $url .= strpos($url, '?') !== false ? '' : '?';
        $url .= http_build_query(array_merge(['token' => $this->token], $data));
        return $url;
    }

    /**
     * @param string $url
     * @param string $username
     * @param string $password
     * @return string
     */
    private function addCredentialsToUrl($url, $username, $password)
    {
        $url .= strpos($url, '?') !== false ? '' : '?';
        $url .= http_build_query(['username' => $username, 'password' => $password]);
        return $url;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
}
