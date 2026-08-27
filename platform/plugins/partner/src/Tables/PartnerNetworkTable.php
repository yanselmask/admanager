<?php

namespace Botble\Partner\Tables;

use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Supports\PartnerHelper;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class PartnerNetworkTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(PartnerNetwork::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('partner-network.create'))
            ->addActions([
                EditAction::make()->route('partner-network.edit'),
                DeleteAction::make()->route('partner-network.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('member_id')
                    ->label(trans('plugins/partner::partner.member'))
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->member?->name ?: '—'),
                FormattedColumn::make('network_code')
                    ->label(trans('plugins/partner::partner.networks.network_name'))
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->network_name),
                FormattedColumn::make('network_code_raw')
                    ->label(trans('plugins/partner::partner.networks.network_code'))
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->network_code),
                FormattedColumn::make('commission')
                    ->label(trans('plugins/partner::partner.networks.commission'))
                    ->getValueUsing(function (FormattedColumn $column) {
                        $network = $column->getItem();

                        return PartnerHelper::resolveCommission($network->member, $network).'%';
                    }),
                FormattedColumn::make('domains_count')
                    ->label(trans('plugins/partner::partner.networks.domains_count'))
                    ->getValueUsing(fn (FormattedColumn $column) => (int) $column->getItem()->domains_count),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('partner.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                $query
                    ->select([
                        'id',
                        'member_id',
                        'network_code',
                        'commission',
                        'status',
                        'created_at',
                    ])
                    ->withCount('domains')
                    ->with('member');
            });
    }
}
