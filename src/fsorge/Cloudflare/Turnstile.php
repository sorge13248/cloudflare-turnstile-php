<?php

namespace Fsorge\Cloudflare;

class Turnstile
{

    private const URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    public function __construct(
        private readonly string $secretKey,
    ) {
    }

    public function isValid(
        string $token
    ): bool {
        $response = $this->validate($token);

        return $response['success'];
    }

    public function validate(
        string $token
    ): array {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'secret' => $this->secretKey,
                'token' => $token,
            ],
        ));

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $response;
    }
}
