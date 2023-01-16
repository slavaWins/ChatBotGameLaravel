<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class RouterPermissionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_RouterWorkAndPermission()
    {

        //$this->assertTrue(true);

        $response = $this->get('/');
        $this->assertEquals(200, $response ->status());


        $response = $this->get('/login');
        $this->assertEquals(200, $response ->status());

        $response = $this->get('/');
        $this->assertEquals(302, $response ->status());

        $response = $this->get('/tax');
        $this->assertEquals(403, $response ->status());

        $response = $this->get('/profile');
        $this->assertEquals(403, $response ->status());
    }
}
