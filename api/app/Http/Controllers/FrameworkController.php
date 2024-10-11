<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Framework;

class FrameworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frameworks = Framework::get();
        return response()->json($frameworks);
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
        $framework = Framework::with('controls', 'controls.domain', 'controls.control_statuses')->find($id)->toArray();

        $framework['controls'] = array_map(function($control) {
            $control['status'] = $control['control_statuses'][0]['status'] ?? 'Not Started';
            return $control;
        }, $framework['controls']);

        return response()->json($framework);
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
        //
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
