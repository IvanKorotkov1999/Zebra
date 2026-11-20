<?php

// Writes backend/config/local.php from environment variables.
// Used by the deploy workflow so that secrets never live in the repo.

$key = getenv('COOKIE_VALIDATION_KEY') ?: '';
if ($key === '') {
    fwrite(STDERR, "COOKIE_VALIDATION_KEY is not set\n");
    exit(1);
}

$config = ['cookieValidationKey' => $key];

$dbName = getenv('DB_NAME') ?: '';
if ($dbName !== '') {
    $host = getenv('DB_HOST') ?: 'localhost';
    $config['db'] = [
        'dsn' => "mysql:host={$host};dbname={$dbName}",
        'username' => getenv('DB_USER') ?: '',
        'password' => getenv('DB_PASSWORD') ?: '',
    ];
}

$target = __DIR__ . '/../backend/config/local.php';
file_put_contents($target, "<?php\n\nreturn " . var_export($config, true) . ";\n");
echo "Wrote config/local.php (db: " . ($dbName !== '' ? 'configured' : 'not configured') . ")\n";
