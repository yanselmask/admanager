<?php

namespace Botble\Domain\Tables;

use Botble\Base\Facades\Html;
use Botble\Domain\Models\Domain;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CheckboxColumn;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\Columns\YesNoColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class DomainTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Domain::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('domain.create'))
            ->addActions([
                EditAction::make()->route('domain.edit'),
                DeleteAction::make()->route('domain.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
//                Column::make('member.first_name')
//                    ->label(__('First Name'))
//                    ->hidden(),
//                Column::make('member.last_name')
//                    ->label(__('Last Name'))
//                    ->hidden(),
                NameColumn::make()->route('domain.edit'),
                NameColumn::make('url')->label(__('Url'))->route('domain.edit'),
                NameColumn::make('network_code')->label(__('Network Code'))->route('domain.edit'),
                FormattedColumn::make('member_id')
                    ->label(__('Member'))
                    ->getValueUsing(function(FormattedColumn $column) {
                        return optional($column->getItem()->member)->first_name . ' ' . optional($column->getItem()->member)->last_name;
                    }),
                YesNoColumn::make('is_subdomain')
                    ->label(__('Subdomain'))
                    ->route('domain.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('domain.destroy'),
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
                    'url',
                    'is_subdomain',
                    'member_id',
                    'created_at',
                    'status',
                ]);
            });
    }
}
