<?php

return [
    // Admin login identity
    'email' => env('ADMIN_EMAIL', 'admin@example.com'),

    // Magic-link token (set a strong random value in production to enable)
    // If null/empty, the route stays disabled.
    'magic_token' => env('ADMIN_MAGIC_TOKEN'),

    // Token TTL (minutes) for single-use cache marker
    'magic_token_ttl' => (int) env('ADMIN_MAGIC_TOKEN_TTL', 10),
];
