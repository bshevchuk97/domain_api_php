<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Session
 *
 * @property int $id
 * @property int $user_id
 * @property string $created
 * @property-read \App\Models\ApiUser $user
 * @method static \Database\Factories\SessionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Session newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Session newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Session query()
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereUserId($value)
 * @mixin \Eloquent
 * @property string $token
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereToken($value)
 */
class Session extends Model
{
    protected $table = 'sessions';
    public $timestamps = false;
    use HasFactory;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ApiUser::class);
    }

    public static function findToken($value): ?Session{
        $session = Session::all()->where('token','=',$value);
        return $session ? $session->first() : NULL;
    }

    public static function create(ApiUser $user): Session {
        srand(time());
        $session = new Session();
        $session->token = md5(mt_rand() . $user->username);
        $session->created_time = new dateTime();
        $session->user()->associate($user);

        $session->save();
        return $session;
    }
}
