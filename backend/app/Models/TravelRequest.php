<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "requester_name",
        "destination",
        "departure_date",
        "return_date",
        "status",
        "user_id"
    ];

    protected $casts = [
        'departure_date' => "date",
        "return_date" => "date",
        "status" => \App\Enums\TravelRequestStatus::class
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
