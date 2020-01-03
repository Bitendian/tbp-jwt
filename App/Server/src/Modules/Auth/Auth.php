<?php

namespace Bitendian\JWT\Server\Modules\Auth;

use Bitendian\TBP\TBPException;
use Firebase\JWT\JWT;

class Auth
{
    private $secretKey;
    private $encrypt;

    /**
     * Auth constructor.
     * @param string $secretKey
     * @param string $encrypt
     */
    public function __construct($secretKey, $encrypt = 'HS256')
    {
        $this->secretKey = $secretKey;
        $this->encrypt = $encrypt;
    }

    /**
     * @param array $data
     * @return string
     */
    public function generateToken($data)
    {
        $time = time();

        $token = array(
            'exp' => $time + (60 * 60),
            'aud' => $this->aud(),
            'data' => $data
        );

        return JWT::encode($token, $this->secretKey, $this->encrypt);
    }

    /**
     * @param string $token
     * @throws TBPException
     */
    public function checkToken($token)
    {
        if (empty($token)) {
            throw new TBPException(_('Token can not be empty'));
        }

        $decode = JWT::decode($token, $this->secretKey, [$this->encrypt]);

        if ($decode->aud !== $this->aud()) {
            throw new TBPException(_('Invalid user'));
        }
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getData($token)
    {
        return JWT::decode($token, $this->secretKey, [$this->encrypt])->data;
    }

    /**
     * @return string
     */
    private function aud()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }

}