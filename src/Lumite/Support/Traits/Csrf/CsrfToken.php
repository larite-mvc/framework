<?php

namespace Lumite\Support\Traits\Csrf;

use Lumite\Exception\Handlers\CsrfException;
use Lumite\Support\Session;

trait CsrfToken
{
    /**
     * @return void
     * @throws CsrfException
     */
    public static function checkCsrf()
    {
        $sessionToken = Session::get('csrf_token');

        // 1. Token from POST
        $postToken = $_POST['csrf_token'] ?? null;

        // 2. Token from headers (support common aliases)
        $headerToken = null;
        $candidates = [
            'HTTP_X_CSRF_TOKEN',
            'HTTP_X_XSRF_TOKEN',
            'X_CSRF_TOKEN',
            'X_XSRF_TOKEN',
        ];
        foreach ($candidates as $header) {
            if (isset($_SERVER[$header]) && $_SERVER[$header]) {
                $headerToken = $_SERVER[$header];
                break;
            }
        }

        // Prefer POST token if available
        $token = $postToken ?? $headerToken;

        if ($token && $sessionToken) {
            if (!static::verify($sessionToken, $token)) {
                throw new CsrfException("CSRF token mismatch");
            }
        } else {
            throw new CsrfException("CSRF token missing or invalid");
        }
    }

    /**
     * @param $token
     * @param $requestedToken
     * @return bool
     */
    public static function verify($token, $requestedToken): bool
    {
        if (!is_string($token) || !is_string($requestedToken)) {
            return false;
        }
        return hash_equals($token, $requestedToken);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function token(): mixed
    {
        if (Session::has('csrf_token')) {
            $token = Session::get('csrf_token');
        } else{
            $token = bin2hex(random_bytes(32));
            Session::put('csrf_token', $token);
        }
        return $token;
    }

    /**
     * @return void
     * @throws \Exception
     */
    private static function rotateToken()
    {
        $expireAfter = 10;
        if(Session::has('last_action')){
            $secondsInactive = time() - Session::get('last_action');
            $expireAfterSeconds = $expireAfter * 60;
            if($secondsInactive >= $expireAfterSeconds){
                Session::forget('csrf_token');
            }
        }
        Session::put('last_action',time());
        Session::put('csrf_token', bin2hex(random_bytes(32)));
    }

}
