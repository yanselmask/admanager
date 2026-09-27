<?php

namespace Botble\Member\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Member\Http\Requests\PaymentMethodRequest;
use Botble\Member\Models\Member;
use Botble\Member\Models\MemberPaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends BaseController
{
    public const MAX_METHODS = 10;

    public function store(PaymentMethodRequest $request): RedirectResponse
    {
        $member = $this->member();

        if ($member->paymentMethods()->count() >= self::MAX_METHODS) {
            return $this->backToInvoices()
                ->with('error_msg', 'Solo puedes guardar hasta '.self::MAX_METHODS.' métodos de pago.');
        }

        DB::transaction(function () use ($member, $request): void {
            $isFirst = ! $member->paymentMethods()->exists();

            $method = $member->paymentMethods()->create([
                'type' => $request->paymentType(),
                'details' => $request->details(),
                'is_default' => false,
            ]);

            if ($isFirst || $request->boolean('is_default')) {
                $this->markAsDefault($member, $method);
            }
        });

        return $this->backToInvoices()->with('success_msg', 'Método de pago agregado.');
    }

    public function makeDefault(int|string $id): RedirectResponse
    {
        $member = $this->member();

        DB::transaction(fn () => $this->markAsDefault($member, $member->paymentMethods()->findOrFail($id)));

        return $this->backToInvoices()->with('success_msg', 'Método de pago predeterminado actualizado.');
    }

    public function destroy(int|string $id): RedirectResponse
    {
        $member = $this->member();

        DB::transaction(function () use ($member, $id): void {
            $method = $member->paymentMethods()->findOrFail($id);
            $method->delete();

            if ($method->is_default && $replacement = $member->paymentMethods()->first()) {
                $this->markAsDefault($member, $replacement);
            }
        });

        return $this->backToInvoices()->with('success_msg', 'Método de pago eliminado.');
    }

    protected function markAsDefault(Member $member, MemberPaymentMethod $method): void
    {
        MemberPaymentMethod::query()
            ->where('member_id', $member->getKey())
            ->whereKeyNot($method->getKey())
            ->update(['is_default' => false]);

        $method->forceFill(['is_default' => true])->save();
    }

    protected function member(): Member
    {
        return auth('member')->user();
    }

    protected function backToInvoices(): RedirectResponse
    {
        return redirect()->to(route('public.member.invoices').'#metodos-de-pago');
    }
}
