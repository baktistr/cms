<?php

namespace Tests;

use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;

class JsonTestResponse extends TestResponse
{
    public function assertJsonValidationErrorsMessage($key, $message = null)
    {
        $errors = $this->json()['errors'];

        if (!is_null($message)) {
            Assert::assertTrue(
                $errors[$key][0] === $message,
                "Failed to assert the validation message error for [{$key}]: '{$message}'\nFound: \"{$errors[$key][0]}\""
            );
        }
    }
}
