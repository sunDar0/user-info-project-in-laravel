<?php

namespace Tests\Unit;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        DB::connection('test_db');
        Order::factory()->count(3)->make();

        $this->assertTrue(true);
    }
}
