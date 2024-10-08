<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Evidence
 * 
 * @property int $id
 * @property int|null $control_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $added_by
 * @property Carbon $created_at
 * 
 * @property Control|null $control
 * @property User|null $user
 *
 * @package App\Models
 */
class Evidence extends Model
{
	protected $table = 'evidence';
	public $timestamps = false;

	protected $casts = [
		'control_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'control_id',
		'title',
		'description',
		'added_by'
	];

	public function control()
	{
		return $this->belongsTo(Control::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'added_by');
	}
}
