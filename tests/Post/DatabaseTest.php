<?php
use PHPUnit\Framework\TestCase;

class Database extends TestCase {
    public function test_env_data(): void {
        $server = getenv('SERVER', false);
        $this->assertEquals($server, "sql1.njit.edu");
    }
}
?>