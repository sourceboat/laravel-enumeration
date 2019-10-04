<?php

namespace Sourceboat\Enumeration\Tests;

use Illuminate\Database\Eloquent\Model;
use Sourceboat\Enumeration\Models\Traits\HasEnums;

class TestModel2 extends Model
{
    use HasEnums;
}
