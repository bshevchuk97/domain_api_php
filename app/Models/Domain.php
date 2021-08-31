<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Domain
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $status_id
 * @property-read \App\Models\Status $status
 * @method static \Database\Factories\DomainFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUserId($value)
 * @mixin \Eloquent
 */
class Domain extends Model
{
    protected $table = 'domains';
    public $timestamps = false;
    use HasFactory;

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
