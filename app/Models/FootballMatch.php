<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $match_day
 * @property integer $country_1
 * @property integer $country_2
 * @property boolean $result
 * @property string $created_at
 * @property string $updated_at
 */
class FootballMatch extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sortable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'football_matchs';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['match_day', 'country_1', 'country_2', 'result', 'created_at', 'updated_at'];

    public function predictResults()
    {
        return $this->hasMany(PredictResult::class, 'match_id', 'id');
    }
    public function predictUser()
    {
        return $this->hasOne(PredictResult::class, 'match_id', 'id');
    }
}
