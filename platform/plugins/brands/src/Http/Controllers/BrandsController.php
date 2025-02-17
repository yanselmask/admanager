<?php

namespace Botble\Brands\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Brands\Http\Requests\BrandsRequest;
use Botble\Brands\Models\Brands;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Brands\Tables\BrandsTable;
use Botble\Brands\Forms\BrandsForm;

class BrandsController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/brands::brands.name')), route('brands.index'));
    }

    public function index(BrandsTable $table)
    {
        $this->pageTitle(trans('plugins/brands::brands.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/brands::brands.create'));

        return BrandsForm::create()->renderForm();
    }

    public function store(BrandsRequest $request)
    {
        $form = BrandsForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('brands.index'))
            ->setNextUrl(route('brands.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Brands $brands)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $brands->name]));

        return BrandsForm::createFromModel($brands)->renderForm();
    }

    public function update(Brands $brands, BrandsRequest $request)
    {
        BrandsForm::createFromModel($brands)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('brands.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Brands $brands)
    {
        return DeleteResourceAction::make($brands);
    }
}
