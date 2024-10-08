<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $email
 * @property string|null $password_hash
 * @property int|null $company_id
 * 
 * @property Company|null $company
 * @property Collection|ControlStatus[] $control_statuses
 * @property Collection|Evidence[] $evidence
 * @property Collection|UserAssignment[] $user_assignments
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	public $timestamps = false;

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'email',
		'password_hash',
		'company_id'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function control_statuses()
	{
		return $this->hasMany(ControlStatus::class, 'updated_by');
	}

	public function evidence()
	{
		return $this->hasMany(Evidence::class, 'added_by');
	}

	public function user_assignments()
	{
		return $this->hasMany(UserAssignment::class, 'assigned_by');
	}
}
