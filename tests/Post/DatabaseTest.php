<?php
use PHPUnit\Framework\TestCase;
require_once realpath(dirname(__DIR__, 2) . '/vendor/autoload.php');

class Database extends TestCase {
    public function test_env_data(): void {
        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        $this->assertEquals($_ENV['SERVER'], "sql1.njit.edu");
    }
}
?>