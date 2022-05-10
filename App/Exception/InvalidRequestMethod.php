<?php

declare(strict_types=1);

namespace App\Exception;

class InvalidRequestMethod extends \Exception
{
    protected $message = 'Invalid Request Method';
}