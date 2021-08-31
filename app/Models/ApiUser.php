<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApiUser
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Domain[] $domains
 * @property-read int|null $domains_count
 * @method static \Database\Factories\ApiUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiUser wherePasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiUser whereUsername($value)
 * @mixin \Eloquent
 */
class ApiUser extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    use HasFactory;

    public function domains(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Domain::class);
    }
}
