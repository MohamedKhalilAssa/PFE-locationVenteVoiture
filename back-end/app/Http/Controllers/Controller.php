<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // to be overriden by the model
    protected $model;
    // to be overriden by the model for validation
    protected $rules;
    // to be overriden by the model for relations select
    public function selectRelations(): array
    {
        return [];
    }
    public function indexBack()
    {
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
        //Get selected column and the search from the request
        $sort       = request('sort') ?? 'none';
        $search     = request('search');
        $sortColumn = request('sortColumn') ?? 'id';

        // Test if there is a search
        if ($search && trim($search) != '') {
            $searchColumn = request('searchColumn') ?? 'nom';
            $this->searchData($search, $searchColumn, $sort, $sortColumn, $this->model);
            $count = $this->model->count();
            $data = $this->model->paginate(10)->toArray();
            foreach ($data['data'] as $key => $value) {
                $data['data'][$key] = nestedToNormal($value);
            }
            return response()->json(['PaginateQuery' => $data, 'total' => $count]);
        } else {
            // else if there is no search
            $this->sortData($sort, $sortColumn, $this->model);
            $count = $this->model->count();
            $data = $this->model->paginate(10)->toArray();
            foreach ($data['data'] as $key => $value) {
                $data['data'][$key] = nestedToNormal($value);
            }
            return response()->json(['PaginateQuery' => $data, 'total' =>  $count]);
        }
    }
    /**
     * local helper functions
     *
     */

    // function for the sorting
    function sortData($sort, $sortColumn, $model)
    {
        if ($sort == 'asc' || $sort == 'desc') {
            /*
             * Test if the selected column is from a relation
             * the column will be in this format relation.column
             */
            if (strpos($sortColumn, '.')) {
                [$sort_relation, $sort_column] = explode('.', $sortColumn);
                if (count($this->selectRelations()) == 0 || !isset($this->selectRelations()[$sort_relation]) || !in_array($sort_column, $this->selectRelations()[$sort_relation]))
                    abort(404, 'Invalid sort column');
                $model = $model->whereHas($sort_relation, function () use ($sort_column, $sort, $model) {
                    $model->orderBy($sort_column, $sort);
                });
            } else {
                // if the selected sort column is a simple column
                $model = $model->orderBy($sortColumn, $sort);
            }
        }
    }
    function searchData($search, $searchColumn, $sort = 'none', $sortColumn, $model)
    {
        /*
             * Test if the selected column is from a relation
             * the column will be in this format relation.column
             */
        if (strpos($searchColumn, '.') && count($this->selectRelations()) > 0) {
            [$search_relation, $search_column] = explode('.', $searchColumn);

            if (count($this->selectRelations()) == 0 || !isset($this->selectRelations()[$search_relation]) || !in_array($search_column, $this->selectRelations()[$search_relation]))
                abort(400, 'Invalid search column');
            $model = $model->whereHas($search_relation, function ($query) use ($search_column, $search) {
                $query->where($search_column, 'like', '%' . $search . '%');
            });
            $this->sortData($sort, $sortColumn, $model);
        } else {
            // if the selected column is a simple column
            $model = $model->where($searchColumn, 'like', '%' . $search . '%');
            $this->sortData($sort, $sortColumn, $model);
        }
    }
}
