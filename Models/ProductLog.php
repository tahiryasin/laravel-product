<?php

namespace Modules\Product\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductLog extends Model
{
    use HasFactory;

    protected $table = 'product_log';

    protected $casts = [
        'changes' => 'array'
    ];

    protected $fillable = [
        "product_id",
        "changes",
        "updated_by",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
