<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ControlEvidenceRequest
 * 
 * @property int $id
 * @property int $control_id
 * @property int $evidence_request_id
 * 
 * @property Control $control
 * @property EvidenceRequest $evidence_request
 *
 * @package App\Models
 */
class ControlEvidenceRequest extends Model
{
	protected $table = 'control_evidence_request';
	public $timestamps = false;

	protected $casts = [
		'control_id' => 'int',
		'evidence_request_id' => 'int'
	];

	protected $fillable = [
		'control_id',
		'evidence_request_id'
	];

	public function control()
	{
		return $this->belongsTo(Control::class);
	}

	public function evidence_request()
	{
		return $this->belongsTo(EvidenceRequest::class);
	}
}
