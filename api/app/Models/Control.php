<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Control
 * 
 * @property int $id
 * @property int $domain_id
 * @property string $identifier
 * @property string $name
 * @property string|null $description
 * @property int|null $weight
 * @property string|null $methods
 * @property string|null $pptdf_applicability
 * @property string|null $nist_csf_function_grouping
 * 
 * @property Domain $domain
 * @property Collection|AssessmentObjective[] $assessment_objectives
 * @property Collection|EvidenceRequest[] $evidence_requests
 * @property Collection|Framework[] $frameworks
 * @property Collection|ControlStatus[] $control_statuses
 * @property Collection|Evidence[] $evidence
 * @property Collection|Question[] $questions
 *
 * @package App\Models
 */
class Control extends Model
{
	protected $table = 'controls';
	public $timestamps = false;

	protected $casts = [
		'domain_id' => 'int',
		'weight' => 'int'
	];

	protected $fillable = [
		'domain_id',
		'identifier',
		'name',
		'description',
		'weight',
		'methods',
		'pptdf_applicability',
		'nist_csf_function_grouping'
	];

	public function domain()
	{
		return $this->belongsTo(Domain::class);
	}

	public function assessment_objectives()
	{
		return $this->hasMany(AssessmentObjective::class);
	}

	public function evidence_requests()
	{
		return $this->belongsToMany(EvidenceRequest::class)
					->withPivot('id');
	}

	public function frameworks()
	{
		return $this->belongsToMany(Framework::class)
					->withPivot('id', 'framework_references');
	}

	public function control_statuses()
	{
		return $this->hasMany(ControlStatus::class);
	}

	public function evidence()
	{
		return $this->hasMany(Evidence::class);
	}

	public function questions()
	{
		return $this->hasMany(Question::class);
	}
}
