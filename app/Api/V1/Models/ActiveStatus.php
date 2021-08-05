<?php

namespace App\Api\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveStatus extends Model
{
    use HasFactory;

    protected $table = 'active_status';
    protected $fillable = ['name'];

    const ACTIVE = 1;
    const DEACTIVATED = 2;
    const DELETED = 3;

    public static function getStatusName($status): string
    {
        switch ($status) {
            case static::ACTIVE:
                return 'Active';
            case static::DEACTIVATED:
                return 'Deactivated';
            case static::DELETED:
                return 'Deleted';
            default:
                return '';
        }
    }
}
