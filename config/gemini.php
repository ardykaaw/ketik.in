<?php

return [
    /**
     * The Google Gemini API Key.
     * You can get one from: https://aistudio.google.com/app/apikey
     */
    'api_key' => env('GEMINI_API_KEY'),

    /**
     * Default model to use for generations.
     */
    'model' => env('GEMINI_MODEL', 'gemini-flash-latest'),
];
