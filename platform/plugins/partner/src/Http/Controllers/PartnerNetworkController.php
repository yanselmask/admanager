<?php

namespace Botble\Partner\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Partner\Forms\PartnerNetworkForm;
use Botble\Partner\Http\Requests\PartnerNetworkRequest;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Tables\PartnerNetworkTable;

class PartnerNetworkController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/partner::partner.name'), route('partner.index'))
            ->add(trans('plugins/partner::partner.networks.name'), route('partner-network.index'));
    }

    public function index(PartnerNetworkTable $table)
    {
        $this->pageTitle(trans('plugins/partner::partner.networks.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/partner::partner.networks.create'));

        return PartnerNetworkForm::create()->renderForm();
    }

    public function store(PartnerNetworkRequest $request)
    {
        $form = PartnerNetworkForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('partner-network.index'))
            ->setNextUrl(route('partner-network.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(PartnerNetwork $partnerNetwork)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $partnerNetwork->network_name]));

        return PartnerNetworkForm::createFromModel($partnerNetwork)->renderForm();
    }

    public function update(PartnerNetwork $partnerNetwork, PartnerNetworkRequest $request)
    {
        PartnerNetworkForm::createFromModel($partnerNetwork)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('partner-network.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * Retirar una asignación no toca los datos del dominio: sus métricas históricas
     * siguen intactas, simplemente dejan de ser visibles para el partner.
     */
    public function destroy(PartnerNetwork $partnerNetwork)
    {
        return DeleteResourceAction::make($partnerNetwork);
    }
}
