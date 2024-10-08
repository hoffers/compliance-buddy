<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AssessmentObjective
 * 
 * @property int $id
 * @property int $control_id
 * @property string|null $identifier
 * @property string|null $description
 * 
 * @property Control $control
 *
 * @package App\Models
 */
class AssessmentObjective extends Model
{
	protected $table = 'assessment_objectives';
	public $timestamps = false;

	protected $casts = [
		'control_id' => 'int'
	];

	protected $fillable = [
		'control_id',
		'identifier',
		'description'
	];

	public function control()
	{
		return $this->belongsTo(Control::class);
	}
}
