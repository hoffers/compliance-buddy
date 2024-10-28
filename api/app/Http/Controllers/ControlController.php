<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Control;
use App\Models\ControlStatus;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $control = Control::with('domain', 'questions', 'assessment_objectives', 'evidence_requests', 'control_statuses')->find($id)->toArray();
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
    public function update(Request $request, $id)
    {
        if (isset($request->newStatus)) {
            $newStatus = new ControlStatus;
            $newStatus->status = $request->newStatus;
            $newStatus->control_id = $id;
            $newStatus->updated_by = 1; //hardcoded until we get some real users
            $newStatus->save();
            $newStatus->refresh();

            return response()->json($newStatus);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
