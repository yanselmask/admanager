<?php

namespace Tests\Feature\Member;

use Botble\ACL\Models\User;
use Botble\Member\Enums\PaymentMethodType;
use Botble\Member\Models\Invoice;
use Botble\Member\Models\Member;
use Botble\Member\Models\MemberPaymentMethod;
use Botble\Theme\Facades\Theme;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class InvoicePaymentMethodTest extends TestCase
{
    use DatabaseTransactions;

    public function test_the_admin_can_record_which_method_paid_an_invoice(): void
    {
        $member = $this->member();
        $method = $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test']);
        $invoice = $this->invoice($member);

        $this->actingAs($this->admin())
            ->post(route('invoice.edit.update', $invoice->getKey()), $this->payload($member, ['payment_method_id' => $method->getKey()]))
            ->assertSessionHasNoErrors();

        $invoice->refresh();

        $this->assertSame($method->getKey(), (int) $invoice->payment_method_id);
        $this->assertSame('PayPal · cobros@example.test', $invoice->payment_method_label);
    }

    public function test_a_method_from_another_member_is_rejected(): void
    {
        $member = $this->member();
        $foreignMethod = $this->paymentMethod($this->member(), PaymentMethodType::PAYPAL, ['email' => 'otro@example.test']);
        $invoice = $this->invoice($member);

        $this->actingAs($this->admin())
            ->post(route('invoice.edit.update', $invoice->getKey()), $this->payload($member, ['payment_method_id' => $foreignMethod->getKey()]))
            ->assertSessionHasErrors('payment_method_id');

        $this->assertNull($invoice->fresh()->payment_method_id);
    }

    public function test_choosing_no_method_clears_it(): void
    {
        $member = $this->member();
        $method = $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test']);
        $invoice = $this->invoice($member);
        $invoice->update(['payment_method_id' => $method->getKey()]);

        $this->actingAs($this->admin())
            ->post(route('invoice.edit.update', $invoice->getKey()), $this->payload($member, ['payment_method_id' => '']))
            ->assertSessionHasNoErrors();

        $invoice->refresh();

        $this->assertNull($invoice->payment_method_id);
        $this->assertNull($invoice->payment_method_label);
    }

    public function test_the_invoice_keeps_the_method_label_after_the_creator_deletes_it(): void
    {
        $member = $this->member();
        $method = $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test']);
        $invoice = $this->invoice($member);
        $invoice->update(['payment_method_id' => $method->getKey()]);

        $method->delete();

        $this->assertSame('PayPal · cobros@example.test', $invoice->fresh()->payment_method_label);
    }

    public function test_the_edit_form_only_offers_the_invoice_members_methods(): void
    {
        $member = $this->member();
        $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test']);
        $this->paymentMethod($this->member(), PaymentMethodType::PAYPAL, ['email' => 'otro@example.test']);

        $this->actingAs($this->admin())
            ->get(route('invoice.edit', $this->invoice($member)->getKey()))
            ->assertOk()
            ->assertSee('todo de pago usado')
            ->assertSee('cobros@example.test')
            ->assertDontSee('otro@example.test');
    }

    public function test_the_creator_sees_how_each_invoice_was_paid(): void
    {
        Theme::setThemeName('moreno');
        View::addNamespace('theme.moreno', platform_path('themes/moreno'));

        $member = $this->member();
        $method = $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test']);
        $this->invoice($member)->update(['payment_method_id' => $method->getKey()]);

        $this->actingAs($member, 'member')
            ->get(route('public.member.invoices'))
            ->assertOk()
            ->assertSee('vía PayPal · cobros@example.test');
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    protected function payload(Member $member, array $overrides = []): array
    {
        return [
            'invoice_date' => '2026-09-01',
            'currency' => 'USD',
            'amount' => '150.00',
            'member_id' => $member->getKey(),
            'status' => 'paid',
            ...$overrides,
        ];
    }

    protected function invoice(Member $member): Invoice
    {
        return Invoice::query()->create([
            'invoice_date' => '2026-09-01',
            'currency' => 'USD',
            'amount' => 150,
            'member_id' => $member->getKey(),
            'status' => 'pending',
        ]);
    }

    protected function member(): Member
    {
        return Member::query()->forceCreate([
            'first_name' => 'Test',
            'last_name' => 'Creator',
            'username' => 'member_'.uniqid(),
            'email' => uniqid().'@example.test',
            'password' => 'secret-password',
        ]);
    }

    protected function admin(): User
    {
        $admin = User::query()->forceCreate([
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'username' => 'admin_'.uniqid(),
            'email' => uniqid().'@example.test',
            'password' => 'secret-password',
        ]);
        $admin->forceFill(['super_user' => true])->save();

        return $admin;
    }

    /**
     * @param  array<string, string>  $details
     */
    protected function paymentMethod(Member $member, PaymentMethodType $type, array $details): MemberPaymentMethod
    {
        return $member->paymentMethods()->create([
            'type' => $type,
            'details' => $details,
            'is_default' => true,
        ]);
    }
}
