<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ParentController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // to be overriden by the model
    protected $model;
    // to be overriden by the model for validation
    protected $rules;
    // for displaying message
    protected $model_name;
    // to be overriden by the model for relations select
    public function selectRelations(): array
    {
        return [];
    }

    /**
     * CRUD OPERATIONS
     *
     * 1. Reading (indexBack, Show...)
     * 2. Creating (Store)
     * 3. Updating  (Update)
     * 4. Deleting   (Destroy)
     */

    //  ! 1. Reading
    public function indexBack(Request $request)
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
        $sort = request('sort') ?? 'none';
        $search = request('search');
        $sortColumn = request('sortColumn') ?? 'id';

        // Test if there is a search
        if ($search && trim($search) != '') {
            $searchColumn = request('searchColumn') ?? 'nom';
            $this->searchData($search, $searchColumn, $sort, $sortColumn, $this->model);
            $count = $this->model->count();
            $this->beforeGetting($this->model);
            $data = $this->model->paginate(10)->toArray();
            foreach ($data['data'] as $key => $value) {
                $data['data'][$key] = nestedToNormal($value);
            }
            $additionalData = $this->beforeIndexBackReturn($this->model);
            return response()->json(['PaginateQuery' => $data, 'total' => $count, $additionalData]);
        } else {
            // else if there is no search
            $this->sortData($sort, $sortColumn, $this->model);
            $count = $this->model->count();
            $this->beforeGetting($this->model);
            $data = $this->model->paginate(10)->toArray();
            foreach ($data['data'] as $key => $value) {
                $data['data'][$key] = nestedToNormal($value);
            }
            $additionalData = $this->beforeIndexBackReturn($this->model);
            return response()->json(['PaginateQuery' => $data, 'total' => $count, ...$additionalData]);
        }
    }
    public function show($id)
    {
        $data =  $this->model::find($id);
        $this->beforeReturnForShow($data);
        return response($data)->header('Content-Type', 'application/json');
    }
    public function index()
    {
        if (count($this->indexReturnedColumns()) > 0) {
            return response($this->model::all($this->indexReturnedColumns()))->header('Content-Type', 'application/json');
        } else {
            return response($this->model::all())->header('Content-Type', 'application/json');
        }
    }
    // ! 2. Creating
    public function store(Request $request)
    {
        // treatment to do before validate
        $this->beforeValidateForStore();
        $validator = Validator::make($request->all(), $this->rules);
        // treatment to do after validate
        $this->afterValidateForStore($validator);
        // verifying for errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // treatment to do before create like modifier data
        $data_to_save = $this->beforeSaveForStore($validator);
        // forme d'erreur subControllers:  ['error'=>['err1' =>[ '...'], 'err2' => [ .. ]]]
        // pour verifier si il y a une erreur custom
        if (isset($data_to_save["error"])) {
            return response()->json(['errors' => $data_to_save['error']], 422);
        }
        // create model
        $new_model = $this->model::create($data_to_save);
        // treatment to do after create like uploading a file
        $this->afterSaveForStore($new_model);
        return response()->json(['message' => "$this->model_name Crée avec succès"]);
    }
    // ! 3. Updating
    public function update(Request $request, $id)
    {
        $this->beforeValidateForUpdate();
        $validator = Validator::make($request->all(), $this->rules);
        $this->afterValidateForUpdate($validator);
        // verifying for errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $current_model = $this->model::find($id);
        if (!$current_model) {
            return abort(404, 'Not found');
        }
        $data = $this->beforeSaveForUpdate($validator, $current_model);
        // forme d'erreur subControllers:  ['error'=>['err1' =>[ '...'], 'err2' => [ .. ]]]
        // pour verifier si il y a une erreur custom
        if (isset($data["error"])) {
            return response()->json(['errors' => $data['error']], 422);
        }

        if ($current_model->update($data)) {
            $this->afterSaveForUpdate($current_model);
            return response()->json(['message' => "$this->model_name modifié avec succès", 'iconColor' => 'blue']);
        } else {
            return abort(400, 'la modification a echoué');
        }
    }
    // ! 4. Deleting
    public function destroy($id)
    {
        $current_model = $this->model::find($id);
        if (!$current_model) {
            return abort(404, 'Not found');
        }
        $current_model = $this->beforeDestroy($current_model);
        if ($current_model->delete()) {
            $this->afterDestroy();
            return response()->json(['message' => "$this->model_name Supprimé avec succès", 'iconColor' => 'red']);
        } else {
            return abort(400, 'La suppresion a echoué');
        }
    }
    public function getTotal()
    {
        return response()->json(['fetched' => $this->model::count(), 'title' => 'Total ' . $this->model_name]);
    }
    // functions that can be overriden to customize the CRUD operations
    // Specifying the columns to be returned from all (optional)
    public function indexReturnedColumns()
    {
        return [];
    }
    public function beforeIndexBackReturn($model)
    {
        // return : ['key' => value ...]
        return [];
    }
    public function beforeGetting($model)
    {
        return $model;
    }
    public function beforeReturnForShow($data)
    {
        return $data;
    }
    // Storing and updating
    public function beforeValidateForStore()
    {
    }
    public function afterValidateForStore(&$validator)
    {
    }
    public function beforeSaveForStore($validator)
    {
        return $validator->validated();
    }
    public function afterSaveForStore($model)
    {
    }

    public function beforeValidateForUpdate()
    {
    }
    public function afterValidateForUpdate($validator)
    {
    }
    public function beforeSaveForUpdate($validator, $current_model)
    {
        return $validator->validated();
    }
    public function afterSaveForUpdate($model)
    {
    }
    public function beforeDestroy($current_model)
    {
        return $current_model;
    }
    public function afterDestroy()
    {
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
    function searchData($search, $searchColumn, $sort, $sortColumn, $model)
    {
        /*
         * Test if the selected column is from a relation
         * the column will be in this format relation.column
         */
        if ($search != null) {
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
}
