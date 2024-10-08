<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Framework[] $frameworks
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Company extends Model
{
	protected $table = 'companies';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function frameworks()
	{
		return $this->belongsToMany(Framework::class)
					->withPivot('id');
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
