<?php
use PHPUnit\Framework\TestCase;
require_once realpath(__DIR__ . '/vendor/autoload.php');

class Database extends TestCase {
    public function test_env_data(): void {
        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->assertEquals($_ENV['SERVER'], "sql1.njit.edu");
    }
}
?>