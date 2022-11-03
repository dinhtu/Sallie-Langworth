<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $match_id
 * @property integer $user_id
 * @property boolean $predict
 * @property boolean $predict_result
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class PredictResult extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sortable;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['match_id', 'user_id', 'predict', 'predict_result', 'created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        $this->hasOne(User::class, 'id', 'user_id');
    }
}
