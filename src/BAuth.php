<?php

namespace Brighty\BAuth;

use Illuminate\Support\Facades\Http;

class BAuth
{

    /**
     * The API Token
     *
     * @var string
     */
    protected $apiToken;

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
     * @return void
     */
    public static function set($apiToken)
    {
        return new self($apiToken);
    }

    /**
     * Check if the token is valid
     *
     * @return string
     */
    public function validate()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->get(config('bauth.endpoint') . '/auth/validate');

        return $response->json();
    }

    /**
     * Get the user data
     *
     * @return string
     */
    public function user()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->get(config('bauth.endpoint') . '/users/me');

        return $response->json();
    }
}
