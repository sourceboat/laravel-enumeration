<?php

namespace Sourceboat\Enumeration\Tests;

use Illuminate\Database\Eloquent\Model;
use Sourceboat\Enumeration\Traits\HasEnums;

class TestModel2 extends Model
{
    use HasEnums;
}
