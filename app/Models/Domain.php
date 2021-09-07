<?php

namespace App\Models;

use App\Exceptions\StatusAlreadySetException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Phalcon\Storage\Serializer\Json;

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

    protected $visible = ['id', 'name', 'status'];

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Status::class);
        //return $this->belongsTo(Status::class);
    }


    public function activate(): bool {
        if($this->status_id == Status::active()) {
            throw new StatusAlreadySetException("Domain is already activated");
        }

        $this->status_id = Status::active();

        $this->save();
        $this->refresh();

        return true;
    }


    public function deactivate(): bool {
        if($this->status_id == Status::inactive()) {
            throw new StatusAlreadySetException("Domain is already deactivated");
        }

        $this->status_id = Status::inactive();

        $this->save();
        $this->refresh();

        return true;
    }


    public static function getAll($userId): array {
        return Domain::all()->where('user_id', '=', $userId)->toArray();
    }


    public static function create($userId, $name): Domain {
        $domain = new Domain();
        $domain->user_id = $userId;
        $domain->name = $name;
        $domain->status_id = 1;

        $domain->save();
        $domain->refresh();

        return $domain;
    }


    public function toJson($options = 0): string {
        $jsonString =   '{"id": ' . $this->id . ' ,'
                      . '"name": "' . $this->name . '" ,'
                      . '"status": "' . $this->status->name() . '"}';
        $decoded = json_decode($jsonString);

        return json_encode($decoded);
    }


}
