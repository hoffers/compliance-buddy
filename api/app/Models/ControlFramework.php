<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ControlFramework
 * 
 * @property int $id
 * @property int $control_id
 * @property int $framework_id
 * @property array|null $framework_references
 * 
 * @property Control $control
 * @property Framework $framework
 *
 * @package App\Models
 */
class ControlFramework extends Model
{
	protected $table = 'control_framework';
	public $timestamps = false;

	protected $casts = [
		'control_id' => 'int',
		'framework_id' => 'int',
		'framework_references' => 'json'
	];

	protected $fillable = [
		'control_id',
		'framework_id',
		'framework_references'
	];

	public function control()
	{
		return $this->belongsTo(Control::class);
	}

	public function framework()
	{
		return $this->belongsTo(Framework::class);
	}
}
