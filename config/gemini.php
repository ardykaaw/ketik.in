<?php

return [
    /**
     * The Google Gemini API Key.
     * You can get one from: https://aistudio.google.com/app/apikey
     */
    'api_keys' => array_filter(array_map('trim', explode(',', env('GEMINI_API_KEYS', env('GEMINI_API_KEY'))))),
    
    /**
     * Dedicated VIP API Key for Admin to bypass rate limits.
     */
    'api_key_admin' => env('GEMINI_API_KEY_ADMIN', ''),

    /**
     * Default model to use for generations.
     */
    'model' => env('GEMINI_MODEL', 'gemini-flash-latest'),
];
