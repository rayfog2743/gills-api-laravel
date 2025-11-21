<?php

if (! function_exists('send_360messenger_curl')) {
    function send_360messenger_curl(string $phone, string $text, ?string $mediaUrl = null): array
    {
        $apiKey = env('MESSENGER_API_KEY');
        $base = rtrim(env('MESSENGER_BASE_URL', 'https://api.360messenger.net'), '/');
        $prefix = env('MESSENGER_SENDER_PREFIX', '0');

        $digits = preg_replace('/\D+/', '', $phone);
        if (empty($digits)) {
            return ['success' => false, 'status' => 422, 'body' => 'Invalid phone number'];
        }

        if ($prefix && ! str_starts_with($digits, $prefix)) {
            $to = $prefix . $digits;
        } else {
            $to = $digits;
        }

        $curl = curl_init();

        $postFields = ['phonenumber' => $to, 'text' => $text];
        if ($mediaUrl) {
            $postFields['url'] = $mediaUrl;
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => "{$base}/sendMessage/{$apiKey}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postFields,
        ]);

        $response = curl_exec($curl);
        $errno = curl_errno($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($errno) {
            \Log::error('Messenger360 cURL error', ['errno' => $errno, 'error' => $err]);
            return ['success' => false, 'status' => 500, 'body' => $err];
        }

        $ok = ($httpcode >= 200 && $httpcode < 300);

        if (! $ok) {
            \Log::error('Messenger360 cURL non-200', ['http_code' => $httpcode, 'body' => $response]);
        }

        return ['success' => $ok, 'status' => $httpcode, 'body' => $response];
    }
}
