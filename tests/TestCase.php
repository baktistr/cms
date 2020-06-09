<?php

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MakesHttpRequests {
        postJson as basePostJson;
    }

    public function postJson($uri, array $data = [], array $headers = []): JsonTestResponse
    {
        return JsonTestResponse::fromBaseResponse($this->basePostJson($uri, $data, $headers));
    }
}
