<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ControlStatus
 * 
 * @property int $id
 * @property int|null $control_id
 * @property string|null $status
 * @property int|null $updated_by
 * @property Carbon $updated_at
 * 
 * @property Control|null $control
 * @property User|null $user
 *
 * @package App\Models
 */
class ControlStatus extends Model
{
	protected $table = 'control_status';
	public $timestamps = false;

	protected $casts = [
		'control_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'control_id',
		'status',
		'updated_by'
	];

	public function control()
	{
		return $this->belongsTo(Control::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}
}
