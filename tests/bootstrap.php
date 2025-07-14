<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

new Dotenv()->bootEnv(dirname(__DIR__).'/.env.test');
copy(__DIR__ . '/../db.dist', __DIR__ . '/../db.test.sqlite');
