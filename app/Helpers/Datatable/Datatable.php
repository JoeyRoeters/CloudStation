<?php

namespace App\Helpers\Datatable;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Builder;

class Datatable
{
    /**
     * @param array $columns
     * @param Builder $query
     */
    public function __construct(
        private readonly array $columns,
        private readonly Builder $query
    )
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        /** @var Builder $query */
        $query = $this->query;

        if(!is_null($request->search['value'])) {
            foreach ($this->columns as $column) {
                $query->orWhereRaw([
                    '$where' => '/.*'.$request->search['value' ].'.*/.test(this["'. $column .'"])',
                ]);
            }
        }

        foreach ($request->order as $order) {
            $query->orderBy($this->columns[$order['column']], $order['dir']);
        }

        $data = $query->paginate($request->length, $this->columns, 'page', ($request->start / $request->length) + 1);

        return response()->json(array(
            'draw' => intval($request->draw),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->count(),
            'iTotalDisplayRecords' => $data->total(),
            'iTotalRecords' => $this->query->get()->count(),
            'data' => $data->map(fn($row) => array_values(array_merge(array_flip($this->columns), $row->toArray()))),
        ));
    }
}
