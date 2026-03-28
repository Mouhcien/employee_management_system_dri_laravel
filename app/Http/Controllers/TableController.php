<?php

namespace App\Http\Controllers;

use App\services\ColumnService;
use App\services\RelationService;
use App\services\TableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    private TableService $tableService;
    private ColumnService $columnService;
    private RelationService $relationService;
    private $pages = 3;

    /**
     * @param TableService $tableService
     */
    public function __construct(TableService $tableService, ColumnService $columnService, RelationService $relationService)
    {
        $this->tableService = $tableService;
        $this->columnService = $columnService;
        $this->relationService = $relationService;
    }

    public function index() {
        try {

            $tables = $this->tableService->getAll($this->pages);

            return view('app.audit.tables.index', [
                'tables' => $tables
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function create() {
        try {

            return view('app.audit.tables.insert', [
                'table' => null
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $tableData = [
                'title'       => $request->title,
                'description' => $request->description,
            ];

            $table = $this->tableService->create($tableData);

            if (!$table) {
                throw new \Exception("Impossible de créer le tableau.");
            }

            foreach ($request->input('columns', []) as $col) {

                $columnData = [
                    'title'       => $col['title'],
                    'description' => $col['description'] ?? null,
                ];

                $column = $this->columnService->create($columnData);

                $this->relationService->create([
                    'table_id'  => $this->tableService->getLatestInserted(),
                    'column_id' => $this->columnService->getLatestInserted()
                ]);
            }

            DB::commit();
            return redirect()->route('audit.tables.index')->with('success', 'Tableau créé avec succès');

        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->withInput()->with('error', "Erreur: " . $exception->getMessage());
        }
    }

    public function edit($id) {
        try {

            $table = $this->tableService->getOneById($id);
            if (is_null($table))
                return back()->with('erro', 'tableau Introuvable !!');

            return view('app.audit.tables.insert', [
                'table' => $table
            ]);

        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $table = $this->tableService->getOneById($id);
            if (is_null($table))
                return back()->with('erro', 'tableau Introuvable !!');

            $table = $this->tableService->update($id, [
                'title'       => $request->title,
                'description' => $request->description,
            ]);

            // 2. Identify currently submitted Column IDs to know what to keep
            $submittedColumnIds = collect($request->input('columns', []))
                ->pluck('id')
                ->filter()
                ->toArray();

            // 3. Delete relations and columns that were removed by the user
            // We find relations linked to this table whose column_id is NOT in the new list
            $relationsToDelete = $this->relationService->getRelationWhichColumnNotInNewList($id, $submittedColumnIds);

            foreach ($relationsToDelete as $rel) {
                $columnId = $rel->column_id;
                $this->relationService->delete($rel->id);
                $this->columnService->delete($columnId); // Remove Column itself
            }

            // 4. Process the columns sent in the request
            foreach ($request->input('columns', []) as $colData) {

                if (isset($colData['id']) && !empty($colData['id'])) {
                    // SCENARIO: UPDATE EXISTING COLUMN
                    $column = $this->columnService->getOneById($colData['id']);
                    if ($column) {
                        $this->columnService->update($colData['id'], [
                            'title'       => $colData['title'],
                            'description' => $colData['description'] ?? null,
                        ]);
                    }
                } else {
                    // SCENARIO: CREATE NEW COLUMN & RELATION
                    $newColumn = $this->columnService->create([
                        'title'       => $colData['title'],
                        'description' => $colData['description'] ?? null,
                    ]);

                    $lastColumnInserted = $this->columnService->getLatestInserted();

                    $this->relationService->create([
                        'table_id'  => $id,
                        'column_id' =>$lastColumnInserted,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('audit.tables.index')->with('success', 'Tableau mis à jour avec succès');

        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error("Update Failed: " . $exception->getMessage());
            return back()->withInput()->with('error', "Erreur: " . $exception->getMessage());
        }
    }

}
