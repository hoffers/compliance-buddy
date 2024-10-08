<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EvidenceRequest
 * 
 * @property int $id
 * @property string $identifier
 * @property string|null $area
 * @property string|null $artifact
 * @property string|null $description
 * 
 * @property Collection|Control[] $controls
 *
 * @package App\Models
 */
class EvidenceRequest extends Model
{
	protected $table = 'evidence_requests';
	public $timestamps = false;

	protected $fillable = [
		'identifier',
		'area',
		'artifact',
		'description'
	];

	public function controls()
	{
		return $this->belongsToMany(Control::class)
					->withPivot('id');
	}
}
