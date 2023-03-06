<?php

namespace Modules\Product\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'status',
        'created_by',
        'type',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function log()
    {
        return $this->hasMany(ProductLog::class);
    }

    public static function createAndLoginDefaultUser()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testuser@demo.com',
            'password' => bcrypt('password'),
        ]);

    }

    public static function createDefaultProduct()
    {
        Product::create([
            'name' => 'Default Product',
            'price' => 10.00,
            'status' => 'active',
            'type' => 'item',
            'created_by' => User::first()->id,
        ]);

        return true;
    }

    protected static function booted()
    {
        // Maintain the change log
        static::updated(function ($item) {

            $changes = collect($item->getDirty())->except('updated_at')->toArray();
            ProductLog::create([
                'product_id' => $item->id,
                'changes' => $changes,
                'updated_by' => User::first()->id,
            ]);

        });
    }
}
