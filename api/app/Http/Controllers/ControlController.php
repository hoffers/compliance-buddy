<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Control;
use App\Models\ControlStatus;
use App\Models\Evidence;

class ControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controls = Control::get();
        return response()->json($controls);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $control = Control::with('domain', 'questions', 'assessment_objectives', 'evidence_requests', 'control_statuses', 'evidence')->find($id)->toArray();
        $control['status'] = $control['control_statuses'][0]['status'] ?? 'Not Started';
        return response()->json($control);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        if (!isset($request->newStatus)) {
            return response()->json([
                'error' => 'missing data',
            ], 400);
        }

        $newStatus = new ControlStatus;
        $newStatus->status = $request->newStatus;
        $newStatus->control_id = $id;
        $newStatus->updated_by = 1; //hardcoded until we get some real users
        $newStatus->save();
        $newStatus->refresh();

        return response()->json($newStatus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addEvidence(Request $request, $id)
    {
        if (!isset($request->title) || !isset($request->description)) {
            return response()->json([
                'error' => 'missing data',
            ], 400);
        }

        $newEvidence = new Evidence;
        $newEvidence->title = $request->title;
        $newEvidence->description = $request->description;
        $newEvidence->control_id = $id;
        $newEvidence->added_by = 1; //hardcoded until we get some real users
        $newEvidence->save();
        $newEvidence->refresh();

        return response()->json($newEvidence);
    }
}
