<?php
use PHPUnit\Framework\TestCase;
require_once realpath(dirname(__DIR__, 1) . '/vendor/autoload.php');

class Database extends TestCase {
    public function test_env_server(): void {
        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
        $dotenv->load();
        $this->assertEquals($_ENV['HOST'], "db");
    }

    public function test_env_username(): void {
        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
        $dotenv->load();
        $this->assertEquals($_ENV['USER'], "user");
    }

    public function test_env_database(): void {
        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
        $dotenv->load();
        $this->assertEquals($_ENV['DATABASE'], "sma237");
    }

    public function test_database_connection(): void {
        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
        $dotenv->load();

        $connection = new mysqli($_ENV['HOST'], $_ENV['USER'], $_ENV['PASS'], $_ENV['DATABASE']);

        $this->assertEquals($connection->connect_error, null);
    }
}
?>