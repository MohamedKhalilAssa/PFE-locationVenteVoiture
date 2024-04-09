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
    }
    public function getTotalVisitors()
    {
        return Analytics::distinct('ip_address')->count();
    }
    // overwriting parent function since logs should not be deleted
    public function destroy($id)
    {
        return;
    }
    public function update(Request $request, $id)
    {
        return;
    }
    public function store(Request $request)
    {
        return;
    }
}
