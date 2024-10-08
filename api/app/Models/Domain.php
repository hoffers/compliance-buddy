<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Domain
 * 
 * @property int $id
 * @property string $identifier
 * @property string $name
 * @property string|null $principles
 * @property string|null $intent
 * 
 * @property Collection|Control[] $controls
 *
 * @package App\Models
 */
class Domain extends Model
{
	protected $table = 'domains';
	public $timestamps = false;

	protected $fillable = [
		'identifier',
		'name',
		'principles',
		'intent'
	];

	public function controls()
	{
		return $this->hasMany(Control::class);
	}
}
