<?php

namespace Botble\Partner\Tables;

use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\EmailColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class PartnerTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Member::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('partner.create'))
            ->addActions([
                EditAction::make()->route('partner.edit'),
                DeleteAction::make()->route('partner.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('first_name')
                    ->label(trans('plugins/partner::partner.member'))
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->name),
                EmailColumn::make(),
                FormattedColumn::make('commission')
                    ->label(trans('plugins/partner::partner.networks.commission'))
                    ->getValueUsing(function (FormattedColumn $column) {
                        $commission = $column->getItem()->commission;

                        return $commission === null
                            ? trans('plugins/partner::partner.commission_inherited', ['value' => (float) setting('partner_percentage_default', 0)])
                            : $commission.'%';
                    }),
                Column::make('partner_networks_count')
                    ->label(trans('plugins/partner::partner.networks.name'))
                    ->orderable(false)
                    ->searchable(false),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query
                    ->where('role', PartnerRoleEnum::PARTNER)
                    ->withCount('partnerNetworks')
                    ->select([
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'commission',
                        'created_at',
                    ]);
            });
    }
}
