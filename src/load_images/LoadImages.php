<?php

namespace load_images;

require_once __DIR__.'/../../vendor/autoload.php';

use Cloudinary\Api\Exception\ApiError;
use Dotenv\Dotenv;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class LoadImages
{
    public function __construct()
    {
        if (file_exists(__DIR__ . '/../../.env')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
            $dotenv->load();
        }

        /*echo 'CLOUDINARY_CLOUD_NAME: ' . $_ENV['CLOUDINARY_CLOUD_NAME'] . '<br>';
        echo 'CLOUDINARY_API_KEY: ' . $_ENV['CLOUDINARY_API_KEY'] . '<br>';
        echo 'CLOUDINARY_API_SECRET: ' . $_ENV['CLOUDINARY_API_SECRET'] . '<br>';*/

        Configuration::instance([
            'cloud' => [
                'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
                'api_key' => $_ENV['CLOUDINARY_API_KEY'],
                'api_secret' => $_ENV['CLOUDINARY_API_SECRET']
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    /**
     * @throws ApiError
     */
    public function upload_image($imageBase64, $imageMimeType, $name)
    {
        $base64Prefix = 'data:' . $imageMimeType . ';base64,';

        $uploadApi = new UploadApi();
        $result = $uploadApi->upload($base64Prefix . $imageBase64, [
            'public_id' => $name
        ]);

        return $result['secure_url'];
    }

}