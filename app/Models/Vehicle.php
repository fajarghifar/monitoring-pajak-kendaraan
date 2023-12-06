<?php

namespace App\Models;

use App\Enums\VehicleCategory;
use App\Enums\VehicleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'brand_id',
        'category',
        'model',
        'license_plate',
        'year',
        'stnk_number',
        'bpkb_number',
        'chassis_number',
        'engine_number',
        'stnk_period',
        'tax_period',
        'photo',
        'office_id',
        'user_id',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'category' => VehicleCategory::class,
        'status' => VehicleStatus::class
    ];


    protected $with = [
        'brand',
        'office',
        'user'
    ];

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query
                ->whereHas('brand', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('model', 'like', '%' . $search . '%');
        });
    }
}
