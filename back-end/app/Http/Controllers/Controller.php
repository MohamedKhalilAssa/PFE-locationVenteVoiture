<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $model;
    protected $rules;
    public function indexBack()
    {
        //Get selected column and the search from the request
        $selectedColumn = request('selectedColumn');
        $search = request('search');
        $relations = [];
        /*
         * Get relations of the model that will be returned
         * and add the relations columns to select
         */
        $selectRelations = $this->selectRelations();
        foreach ($selectRelations as $rel => $columns) {
            $relations[$rel] = function ($query) use ($columns) {
                $query->select($columns);
            };
        }
        $this->model = $this->model::with($relations);
        // Test if there is a search
        if ($search) {
            /*
             * Test if the selected column is from a relation
             * the column will be in this format relation.column
             */
            if (strpos($selectedColumn, '.')) {
                [$search_relation, $search_column] = explode('.', $selectedColumn);
                $this->model = $this->model->whereHas($search_relation, function ($query) use ($search_column, $search) {
                    $query->where($search_column, 'like', '%' . $search . '%');
                });
            } else {
                // if the selected column is a simple column
                $this->model = $this->model->where($selectedColumn, 'like', '%' . $search . '%');
            }

            $count = $this->model->count();
            $data = $this->model->paginate(10)->toArray();
            foreach ($data['data'] as $key => $value) {
                $data['data'][$key] = nestedToNormal($value);
            }
            return response()->json(['PaginateQuery' => $data, 'total' => $count]);
        } else {
            $count = $this->model->count();
            $data = $this->model->paginate(10)->toArray();
        
            return response()->json(['PaginateQuery' => $data, 'total' =>  $count]);
        }
    }
    // to be overridden by desired relations of the model
    public function selectRelations()
    {
        return [];
    }
}
