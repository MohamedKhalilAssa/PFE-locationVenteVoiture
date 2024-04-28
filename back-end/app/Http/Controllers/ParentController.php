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
    protected $model_table;
    // to be overriden by the model for validation
    protected $rules;
    protected $conditions = [];
    // for displaying message
    protected $model_name;
    // to be overriden by the model for relations select
    public function selectRelations(): array
    {
        return [];
    }
    protected $request;
    public function __construct()
    {
        $this->request = request();
        $this->model = new $this->model;
        $this->model_table = $this->model->getTable();
    }

    /**
     * CRUD OPERATIONS
     *
     * 1. Reading (indexPaginate, Show...)
     * 2. Creating (Store)
     * 3. Updating  (Update)
     * 4. Deleting   (Destroy)
     */

    //  ! 1. Reading
    public function indexPaginate()
    {
        $this->assignRelation();
        $this->assignConditions();
        //Get selected column and the search from the request
        $sort = $this->request->get('sort') ?? 'none';
        $search = $this->request->get('search');
        $sortColumn = $this->request->get('sortColumn') ?? 'id';

        // Test if there is a search
        if ($search && trim($search) != '') {
            $searchColumn = $this->request->get('searchColumn') ?? 'nom';
            $this->searchData($search, $searchColumn, $sort, $sortColumn);
        }
        // else if there is no search
        $this->sortData($sort, $sortColumn);
        $this->beforeGetting();
        $data = $this->model->paginate(10)->toArray();

        $additionalData = $this->beforeIndexBackReturn($this->model);
        return response()->json(['PaginateQuery' => $data, ...$additionalData]);
    }
    public function show($id)
    {
        $this->assignRelation();
        $data = $this->model->find($id);
        $data = $this->beforeReturnForShow($data);
        return response($data)->header('Content-Type', 'application/json');
    }
    public function index()
    {
        $this->assignRelation();
        $this->beforeGetting();
        $this->assignConditions();
        if (count($this->indexReturnedColumns()) > 0) {
            return response($this->model->get($this->indexReturnedColumns()))->header('Content-Type', 'application/json');
        } else {
            return response($this->model->get())->header('Content-Type', 'application/json');
        }
    }
    // ! 2. Creating
    public function store()
    {
        // treatment to do before validate
        $this->beforeValidateForStore();
        $validator = Validator::make($this->request->all(), $this->rules);
        // treatment to do after validate
        $this->afterValidateForStore($validator);
        // verifying for errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // treatment to do before create like modifier data
        $data_to_save = $this->beforeSaveForStore();
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
    public function update($id)
    {
        $this->beforeValidateForUpdate();
        $validator = Validator::make($this->request->all(), $this->rules);
        $this->afterValidateForUpdate($validator);
        // verifying for errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $current_model = $this->model::find($id);
        if (!$current_model) {
            return abort(404, 'Not found');
        }
        $data = $this->beforeSaveForUpdate($current_model);
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
        // forme d'erreur subControllers:  ['error'=>['err1' =>[ '...'], 'err2' => [ .. ]]]
        // pour verifier si il y a une erreur custom
        if (isset($current_model["error"])) {
            return response()->json(['errors' => $current_model['error']], 422);
        }
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
    public function beforeGetting()
    {
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
    public function beforeSaveForStore()
    {
        return $this->request->all();
    }
    public function afterSaveForStore($new_model)
    {
    }

    public function beforeValidateForUpdate()
    {
    }
    public function afterValidateForUpdate($validator)
    {
    }
    public function beforeSaveForUpdate($current_model)
    {
        return $this->request->all();
    }
    public function afterSaveForUpdate($current_model)
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
    function sortData($sort, $sortColumn)
    {
        if ($sort == 'asc' || $sort == 'desc') {
            /*
             * Test if the selected column is from a relation
             * the column will be in this format relation.column
             */
            if (strpos($sortColumn, '.')) {
                [$sort_relation, $sort_column] = explode('.', $sortColumn);
                if (count($this->selectRelations()) == 0 || !isset($this->selectRelations()[$sort_relation]) || !in_array($sort_column, $this->selectRelations()[$sort_relation]['relation_column']))
                    abort(404, 'Invalid sort column');
                $relations = $this->selectRelations();
                $relation_table = $relations[$sort_relation]['table'];
                $this->model->orderBy($relation_table . '.' . $sort_column, $sort);
            } else {
                // if the selected sort column is a simple column
                $this->model = $this->model->orderBy($sortColumn, $sort);
            }
        }
    }
    function searchData($search, $searchColumn, $sort, $sortColumn)
    {
        /*
         * Test if the selected column is from a relation
         * the column will be in this format relation.column
         */
        $relations = $this->selectRelations();;
        if ($search != null) {
            if (strpos($searchColumn, '.') && count($this->selectRelations()) > 0) {
                [$search_relation, $search_column] = explode('.', $searchColumn);

                if (count($this->selectRelations()) == 0 || !isset($this->selectRelations()[$search_relation]) || !in_array($search_column, $this->selectRelations()[$search_relation]['relation_column']))
                    abort(400, 'Invalid search column');
                $relation_table = $relations[$search_relation]['table'];
                $this->model = $this->model->where($relation_table . '.' . $search_column, 'like', '%' . $search . '%');
            } else {
                // if the selected column is a simple column
                $this->model = $this->model->where($this->model_table . '.' . $searchColumn, 'like', '%' . $search . '%');
            }
        }
    }
    function assignRelation()
    {
        /*
         * Get relations of the model that will be returned
         * and add the relations columns to select
         */
        $relations = $this->selectRelations();
        $select = [];
        foreach ($relations as $relation => $config) {
            $relation_table = $config['table'];
            $relation_table_field = $config['field'];
            $primary_key = $config['primary_key'];
            $this->model = $this->model->leftjoin(
                $relation_table,
                $this->model_table . '.' . $relation_table_field,
                '=',
                $relation_table . '.' . $primary_key
            );
            foreach ($config['relation_column'] as $column) {
                $select[] = $relation_table . '.' . $column . ' as ' . $relation . '.' . $column;
            }

            // marque.nom
        }
        $this->model = $this->model->select([$this->model_table . '.*', ...$select]);
    }
    public function assignConditions()
    {
        // customizing depending on the function
        foreach ($this->conditions as $condition) {
            $this->model->where($this->model_table . '.' . $condition['column'], $condition['operator'], $condition['value']);
        }
    }
}
