<?php

return [
    /**
     * The Google Gemini API Key.
     * You can get one from: https://aistudio.google.com/app/apikey
     */
    'api_keys' => array_filter(array_map('trim', explode(',', env('GEMINI_API_KEYS', env('GEMINI_API_KEY'))))),

    /**
     * Default model to use for generations.
     */
    'model' => env('GEMINI_MODEL', 'gemini-flash-latest'),
];
