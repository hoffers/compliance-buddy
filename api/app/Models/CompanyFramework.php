<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyFramework
 * 
 * @property int $id
 * @property int $company_id
 * @property int $framework_id
 * 
 * @property Company $company
 * @property Framework $framework
 *
 * @package App\Models
 */
class CompanyFramework extends Model
{
	protected $table = 'company_framework';
	public $timestamps = false;

	protected $casts = [
		'company_id' => 'int',
		'framework_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'framework_id'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function framework()
	{
		return $this->belongsTo(Framework::class);
	}
}
