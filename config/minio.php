<?php

return [
    'region' => env('MINIO_REGION', 'us-east-1'),
    'endpoint' => env('MINIO_ENDPOINT', 'http://127.0.0.1:9000'),
    'access_key' => env('MINIO_ACCESS_KEY', ''),
    'secret_key' => env('MINIO_SECRET_KEY', ''),
    'bucket' => env('MINIO_BUCKET', 'your-bucket-name'),
];
