<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Domain[] $domains
 * @property-read int|null $domains_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    use HasFactory;
    protected $visible = ['id', 'username'];

    public function domains(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Domain::class, 'user_id');
    }

    public static function create($username, $password_hash): User {
        $new_user = new User();
        $new_user->username = $username;
        $new_user->password_hash = $password_hash;

        $new_user->save();
        $new_user->refresh();

        return $new_user;
    }

    public static function getId(User $user){
        return User::whereUsername($user->username)->first()->id;
    }

    public static function login($username, $password_hash){
        return User::where(['username'=>$username, 'password_hash'=>$password_hash])->first();
    }

    public function associateDomain(Domain $domain): bool {
        $this->domains()->save($domain);
        $this->save();
        $this->refresh();

        return true;
    }
}
