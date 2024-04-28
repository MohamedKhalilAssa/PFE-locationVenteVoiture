<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class AnalyticsController extends ParentController
{
    public function __construct()
    {
        $this->model = Analytics::class;
        $this->model_name = 'Analytic';
        $this->middleware('auth:sanctum');
        $this->middleware('admin');
        parent::__construct();
    }
    public function getTotalVisitors(Request $request)
    {
        return response()->json(['fetched' => $this->model::distinct('ip_address')->count(), 'title' => 'Total Visiteurs']);
    }
    // overwriting parent function since logs should not be deleted
    public function destroy($id)
    {
        return;
    }
    public function update($id)
    {
        return;
    }
    public function store()
    {
        return;
    }
}
