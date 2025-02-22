<?php

namespace Botble\Member\Tables;

use Botble\Member\Enums\InvoiceStatus;
use Botble\Member\Models\Invoice;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\DateColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class InvoiceTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Invoice::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('invoice.create'))
            ->addActions([
                EditAction::make()->route('invoice.edit'),
                DeleteAction::make()->route('invoice.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                Column::make('name')->label(__('Invoice Number'))->route('invoice.edit'),
                DateColumn::make('invoice_date')->label(__('Invoice Date'))->route('invoice.edit'),
                FormattedColumn::make('currency')
                    ->label(__('Invoice Currency'))
                    ->getValueUsing(function(FormattedColumn $column){
                        return get_currency_code($column->getItem()->currency)['symbol'];
                    }),
                FormattedColumn::make('amount')
                    ->label(__('Invoice Amount'))
                    ->getValueUsing(function(FormattedColumn $column){
                        return str(get_currency_code($column->getItem()->currency)['symbol'])->append(number_format($column->getItem()->amount, 2));
                    })
                ,
                FormattedColumn::make('member_id')
                    ->label(__('Member'))
                    ->getValueUsing(function(FormattedColumn $column){
                        return $column->getItem()->member?->first_name . ' ' . $column->getItem()->member?->last_name;
                    }),
                CreatedAtColumn::make(),
                FormattedColumn::make('status')
                    ->label(__('Status'))
                    ->getValueUsing(function(FormattedColumn $column){
                        return InvoiceStatus::badge($column->getItem()->status);
                    }),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('invoice.destroy'),
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
                    'currency',
                    'invoice_date',
                    'amount',
                    'member_id',
                    'created_at',
                    'status',
                ]);
            });
    }
}
