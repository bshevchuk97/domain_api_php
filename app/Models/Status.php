<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Status
 *
 * @property int $id
 * @property string $name
 * @method static \Database\Factories\StatusFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereName($value)
 * @mixin \Eloquent
 */
class Status extends Model
{
    protected $table = 'statuses';
    public $timestamps = false;
    use HasFactory;

    protected $hidden = ['id'];
    protected $visible = ['name'];

    private static array $statuses = [1 => 'inactive', 2 => 'active'];

    public static function getStatus(int $statusId){
        $status = self::$statuses[$statusId];

        if(empty($status))
            return 'unknown';

        return $status;
    }

    public static function inactive(){return 1;}
    public static function active(){return 2;}

    public function name(){
        return self::getStatus($this->id);
    }

    public function toJson($options = 0): string {
        return "" . $this->name;
    }
}

