<?php

namespace Botble\Admanager\Tables;

use Botble\Admanager\Models\Admanager;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class AdmanagerTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Admanager::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('admanager.create'))
            ->addActions([
                EditAction::make()->route('admanager.edit'),
                DeleteAction::make()->route('admanager.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('admanager.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('admanager.destroy'),
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
                    'created_at',
                    'status',
                ]);
            });
    }
}
