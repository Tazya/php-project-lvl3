<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Make ajax POST request
     */
    protected function ajaxPost($uri, array $data = [])
    {
        return $this->post($uri, $data, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }

    /**
     * Make ajax GET request
     */
    protected function ajaxGet($uri)
    {
        return $this->get($uri, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }
}
