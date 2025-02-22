<?php

namespace Botble\Member\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Member\Http\Requests\KycRequest;
use Botble\Member\Models\Kyc;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Member\Tables\KycTable;
use Botble\Member\Forms\KycForm;

class KycController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/member::kyc.name')), route('kyc.index'));
    }

    public function index(KycTable $table)
    {
        $this->pageTitle(trans('plugins/member::kyc.name'));


        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/member::kyc.create'));

        return KycForm::create()->renderForm();
    }

    public function store(KycRequest $request)
    {
        $form = KycForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('kyc.index'))
            ->setNextUrl(route('kyc.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Kyc $kyc)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $kyc->name]));

        return KycForm::createFromModel($kyc)->renderForm();
    }

    public function update(Kyc $kyc, KycRequest $request)
    {
        KycForm::createFromModel($kyc)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('kyc.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Kyc $kyc)
    {
        return DeleteResourceAction::make($kyc);
    }
}
