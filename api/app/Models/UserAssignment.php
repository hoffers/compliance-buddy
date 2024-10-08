<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAssignment
 * 
 * @property int $id
 * @property int|null $user_id
 * @property int|null $assigned_by
 * @property string|null $assignment_type
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class UserAssignment extends Model
{
	protected $table = 'user_assignments';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'assigned_by' => 'int'
	];

	protected $fillable = [
		'user_id',
		'assigned_by',
		'assignment_type'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'assigned_by');
	}
}
