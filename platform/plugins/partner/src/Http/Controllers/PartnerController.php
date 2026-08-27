<?php

namespace Botble\Partner\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Forms\PartnerForm;
use Botble\Partner\Http\Requests\PartnerRequest;
use Botble\Partner\Tables\PartnerTable;

class PartnerController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/partner::partner.name'), route('partner.index'));
    }

    public function index(PartnerTable $table)
    {
        $this->pageTitle(trans('plugins/partner::partner.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/partner::partner.create'));

        return PartnerForm::create()->renderForm();
    }

    public function store(PartnerRequest $request)
    {
        $member = Member::query()->findOrFail($request->input('member_id'));

        $this->applyRole($member, $request);

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('partner.index'))
            ->setNextUrl(route('partner.edit', $member->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Member $partner)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $partner->name]));

        return PartnerForm::createFromModel($partner)->renderForm();
    }

    public function update(Member $partner, PartnerRequest $request)
    {
        $this->applyRole($partner, $request);

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('partner.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * Quitar un partner NO borra al miembro: lo degrada a creador. Sus asignaciones de
     * network se conservan pero dejan de producir efecto, tal y como exige la spec.
     */
    public function destroy(Member $partner)
    {
        $partner->setAttribute('role', PartnerRoleEnum::CREATOR);
        $partner->save();

        return $this
            ->httpResponse()
            ->setMessage(trans('plugins/partner::partner.demoted'));
    }

    /**
     * `role` y `commission` no están en el `$fillable` de Member — el plugin `member`
     * no se modifica — así que se asignan por propiedad.
     */
    protected function applyRole(Member $member, PartnerRequest $request): void
    {
        $member->setAttribute('role', $request->input('role'));
        $member->setAttribute('commission', $request->input('commission') === null || $request->input('commission') === ''
            ? null
            : (float) $request->input('commission'));
        $member->save();
    }
}
