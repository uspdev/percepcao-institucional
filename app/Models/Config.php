<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Glorand\Model\Settings\Traits\HasSettingsField;

class Config extends Model
{
    use HasFactory;
    use HasSettingsField;

}
