<?php

namespace App\Libraries\Exceptions;

use \CodeIgniter\Exceptions\DebugTraceableTrait;
use OutOfBoundsException;

class WrongHttpMethodException extends OutOfBoundsException
{
    use DebugTraceableTrait;
}
