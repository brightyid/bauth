<?php

namespace Brighty\BAuth;

use Illuminate\Support\Facades\Http;

class Auth
{

    /**
     * The API Token
     *
     * @var string
     */
    public $apiToken;

    /**
     * Create a new BAuth instance.
     *
     * @return void
     */
    public function __construct($apiToken = null)
    {
        $this->apiToken = $apiToken;
    }

    /**
     * Set the API Token
     *
     * @param string $apiToken
     * @return \Brighty\BAuth\Auth $auth
     */
    public static function set($apiToken)
    {
        return new self($apiToken);
    }

    /**
     * Check if the token is valid
     *
     * @return \Illuminate\Http\Client\Response $response
     */
    public function validate()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->get(config('bauth.endpoint') . '/auth/validate');

        return $response;
    }

    /**
     * Get the user data
     *
     * @return \Illuminate\Http\Client\Response $response
     */
    public function user()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->get(config('bauth.endpoint') . '/users/me');

        return $response;
    }
}
