<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Framework;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // $user = auth()->user();
        $user = User::find(1);
        $company = $user->company;
        $frameworks = $company->frameworks() //->with('controls', 'controls.control_statuses')
            ->select('frameworks.id', 'frameworks.short_name')
            ->withCount(['controls as total_controls', 'controls as complete_controls' => function ($query) {
                $query->whereHas('control_statuses', function($q) {
                    $q->where('status', 'complete');
                });
            }])->get();

        return response()->json($frameworks);
    }
}
