<?php

namespace App\DataTables;

use App\Models\Motor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MotorDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
  public function dataTable(QueryBuilder $query): EloquentDataTable
    {


         $motors = Motor::with(['customer']); 

        return datatables()
        ->eloquent($query)
        ->addColumn('action', function($row){
            return "<a href=". route('motors.edit', $row->id). " class=\"btn btn-warning\">Edit</a> 
                    <form action=". route('motors.destroy', $row->id). " method= \"POST\" >". csrf_field() .
                     '<input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                      </form>';
        })

          ->addColumn('customer', function(Motor $motors){
            return $motors->customer->fname;
        })

        ->addColumn('images', function($motors){
            $url = asset("$motors->motor_img");
            return '<img src='.$url.' alt="Image" height="80" width="80">';
            
           })
    
           ->rawColumns(['action', 'images']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Motor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Motor $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
   return $this->builder()
                    ->setTableId('motors-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        // Button::make('create'),
                        // Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            
            Column::make('id'),
            Column::make('brand'),
            Column::make('model'),
            Column::make('images'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Motor_' . date('YmdHis');
    }
}
