<?php

namespace Botble\Member\Tables;

use Botble\Base\Facades\Html;
use Botble\Member\Models\Kyc;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class KycTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Kyc::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('kyc.create'))
            ->addActions([
                EditAction::make()->route('kyc.edit'),
                DeleteAction::make()->route('kyc.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('kyc.edit'),
                Column::make('last_name')-> label(__('Last name')),
                Column::make('nationality')->label(__('Nationality')),
                Column::make('document_type')->label(__('Document Type')),
                FormattedColumn::make('member_id')
                    ->title(__('Member'))
                    ->width(150)
                    ->orderable(false)
                    ->searchable(false)
                    ->getValueUsing(function (FormattedColumn $column) {
                        return $column->getItem()?->member?->first_name . ' ' . $column->getItem()?->last_name;
                    })
                    ->withEmptyState(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('kyc.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'name',
                    'last_name',
                    'nationality',
                    'document_type',
                    'created_at',
                    'member_id',
                    'status',
                ]);
            });
    }
}
