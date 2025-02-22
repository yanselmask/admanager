<?php

namespace Botble\Member\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Member\Http\Requests\InvoiceRequest;
use Botble\Member\Models\Invoice;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Member\Tables\InvoiceTable;
use Botble\Member\Forms\InvoiceForm;

class InvoiceController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/member::invoice.name')), route('invoice.index'));
    }

    public function index(InvoiceTable $table)
    {
        $this->pageTitle(trans('plugins/member::invoice.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/member::invoice.create'));

        return InvoiceForm::create()->renderForm();
    }

    public function store(InvoiceRequest $request)
    {
        $form = InvoiceForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('invoice.index'))
            ->setNextUrl(route('invoice.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Invoice $invoice)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $invoice->name]));

        return InvoiceForm::createFromModel($invoice)->renderForm();
    }

    public function update(Invoice $invoice, InvoiceRequest $request)
    {
        InvoiceForm::createFromModel($invoice)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('invoice.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Invoice $invoice)
    {
        return DeleteResourceAction::make($invoice);
    }
}
