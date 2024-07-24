<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeasurementRecordResource;
use App\Models\MeasurementRecord;
use Illuminate\Http\Request;

class MeasurementRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = MeasurementRecord::all()->toArray();

        return new MeasurementRecordResource(true, 'success', $records);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $records = MeasurementRecord::all()->where('measurement_id', $id)->toArray();

        return new MeasurementRecordResource(true, 'success', $records);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeasurementRecord $measurementRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MeasurementRecord $measurementRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeasurementRecord $measurementRecord)
    {
        //
    }
}
