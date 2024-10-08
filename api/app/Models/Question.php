<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * 
 * @property int $id
 * @property int $control_id
 * @property string|null $question
 * @property string|null $level_0
 * @property string|null $level_1
 * @property string|null $level_2
 * @property string|null $level_3
 * @property string|null $level_4
 * @property string|null $level_5
 * 
 * @property Control $control
 *
 * @package App\Models
 */
class Question extends Model
{
	protected $table = 'questions';
	public $timestamps = false;

	protected $casts = [
		'control_id' => 'int'
	];

	protected $fillable = [
		'control_id',
		'question',
		'level_0',
		'level_1',
		'level_2',
		'level_3',
		'level_4',
		'level_5'
	];

	public function control()
	{
		return $this->belongsTo(Control::class);
	}
}
