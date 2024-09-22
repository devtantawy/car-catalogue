<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $make
 * @property string $model
 * @property int $year
 * @property string $price
 * @property string $description
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereMake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereYear($value)
 * @property int $user_id
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereUserId($value)
 * @mixin \Eloquent
 */
class CarModel extends Model
{
    // @phpstan-ignore-next-line
    use HasFactory;

    protected $fillable = [
        'make', 'model', 'year', 'price', 'description', 'image', 'user_id',
    ];

    /**
     * Get the user that owns the car.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
