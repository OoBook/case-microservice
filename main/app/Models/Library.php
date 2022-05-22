<?php

namespace App\Models;

use App\Enum\AddressCityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Library extends Model
{
    use HasFactory;


    protected $connection = "mysql_library";

    protected $fillable = [
        'id',
        'name',
        'city'
    ];

    protected $maximum_user = 10;

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'city' => AddressCityEnum::class
    ];

    public function canAttach()
    {
        $count = DB::connection($this->connection)->table('user_library')
            ->where('library_id', $this->id)
            ->count();

        return !($count >= $this->maximum_user);

    }

}
