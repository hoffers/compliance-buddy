<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Framework
 * 
 * @property int $id
 * @property string $short_name
 * @property string $full_name
 * @property string|null $source
 * @property string|null $geography
 * @property string|null $version
 * @property string|null $url
 * @property string $identifier
 * 
 * @property Collection|Company[] $companies
 * @property Collection|Control[] $controls
 *
 * @package App\Models
 */
class Framework extends Model
{
	protected $table = 'frameworks';
	public $timestamps = false;

	protected $fillable = [
		'short_name',
		'full_name',
		'source',
		'geography',
		'version',
		'url',
		'identifier'
	];

	protected $hidden = ['pivot'];

	public function companies()
	{
		return $this->belongsToMany(Company::class)
					->withPivot('id');
	}

	public function controls()
	{
		return $this->belongsToMany(Control::class)
					->withPivot('id', 'framework_references');
	}
}
