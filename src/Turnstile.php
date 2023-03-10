<?php

namespace Fsorge\Cloudflare;

/**
 * Simplifies Cloudflare Turnstile captcha validations
 * @author Francesco Sorge <php@francescosorge.com>
 */
class Turnstile
{

    private const URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    /**
     * @param string $secretKey the secret key you obtained from the Cloudflare Turnstile dashboard for your website
     */
    public function __construct(
        private readonly string $secretKey,
    ) {
    }

    /**
     * @param string $token it's the value of the hidden field in your form with name cf-turnstile-response
     */
    public function isValid(
        string $token
    ): bool {
        $response = $this->validate($token);

        return $response['success'];
    }

    /**
     * @param string $token it's the value of the hidden field in your form with name cf-turnstile-response
     */
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
                'response' => $token,
            ],
        ));

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $response;
    }
}
