<?php
use PHPUnit\Framework\TestCase;
require_once realpath(dirname(__DIR__, 2) . '/vendor/autoload.php');

class Database extends TestCase {
    // public function test_env_server(): void {
        // Looing for .env at the root directory
        // $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        // $dotenv->load();
        // $this->assertEquals($_ENV['SERVER'], "sql1.njit.edu");
    // }

    // public function test_env_username(): void {
        // Looing for .env at the root directory
        // $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        // $dotenv->load();
        // $this->assertEquals($_ENV['USERNAME'], "sma237");
    // }

    // public function test_env_database(): void {
        // Looing for .env at the root directory
        // $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        // $dotenv->load();
        // $this->assertEquals($_ENV['DATABASE'], "sma237");
    // }

    public function test_database_connection(): void {
        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $connection = mysqli_connect("localhost", "shane", "password");

        $this->assertEquals(mysqli_connect_error, null);
    }
}
?>