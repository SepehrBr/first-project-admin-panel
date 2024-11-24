<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Recapthca implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                'response' => $value,
                'remoteip' => request()->ip()
            ]);
            $response->throw();
            $response = $response->json();
            return $response['success'];


            /*            laravel older version codeblock
            try {
            $client = new Client();
            $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
               'form_params' => [
                    'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                    'response' => $value,
                    'remoteip' => request()->ip()
               ]
            ]);

            get returned JSON data
            $response = json_decode($response->getBody());
            return $response->success;

        } catch (\Exception $exception) {
            return false;
        }
        */
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'خطا در دریافت اطلاعات کاربر';
    }
}
