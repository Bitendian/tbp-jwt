<?php

namespace Bitendian\JWT\Client\Modules\Client;

class Client
{
    private $token;

    public function auth($url, $username, $password)
    {
        $url = $this->addCredentialsToUrl($url, $username, $password);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        return $response;
    }

    public function get($url, $data = [])
    {
        $url = $this->addTokenToUrl($url, $data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);

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
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
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
}
