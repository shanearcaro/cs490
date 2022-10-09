<?php
namespace Tests\Post;
use PHPUnit\Framework\TestCase;

class Database extends TestCase {
    public function test_env_data(): void {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    
        $this->assertEquals($_ENV['SERVER'], "sql1.njit.edu");
    }
}
?>