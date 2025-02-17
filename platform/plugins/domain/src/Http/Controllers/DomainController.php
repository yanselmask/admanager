<?php

namespace Botble\Domain\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Domain\Http\Requests\DomainRequest;
use Botble\Domain\Models\Domain;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Domain\Tables\DomainTable;
use Botble\Domain\Forms\DomainForm;

class DomainController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/domain::domain.name')), route('domain.index'));
    }

    public function index(DomainTable $table)
    {
        $this->pageTitle(trans('plugins/domain::domain.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/domain::domain.create'));

        return DomainForm::create()->renderForm();
    }

    public function store(DomainRequest $request)
    {
        $form = DomainForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('domain.index'))
            ->setNextUrl(route('domain.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Domain $domain)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $domain->name]));

        return DomainForm::createFromModel($domain)->renderForm();
    }

    public function update(Domain $domain, DomainRequest $request)
    {
        DomainForm::createFromModel($domain)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('domain.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Domain $domain)
    {
        return DeleteResourceAction::make($domain);
    }
}
