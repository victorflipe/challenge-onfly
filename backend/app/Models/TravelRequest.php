<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeSearch(Builder $query, $request){

        return $query
        ->when($request->filled('id'), fn($q) => $q->where('id', $request->id))
        ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
        ->when($request->filled('departure_date'), fn($q) => $q->whereDate('departure_date', '>=', $request->departure_date))
        ->when($request->filled('return_date'), fn($q) => $q->whereDate('return_date', '<=', $request->return_date))
        ->when($request->filled('destination'), fn($q) => $q->where('destination', 'like', '%' . $request->destination . '%'));
    
    }
}
