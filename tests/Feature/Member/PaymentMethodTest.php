<?php

namespace Tests\Feature\Member;

use Botble\Member\Enums\PaymentMethodType;
use Botble\Member\Http\Controllers\PaymentMethodController;
use Botble\Member\Models\Member;
use Botble\Member\Models\MemberPaymentMethod;
use Botble\Theme\Facades\Theme;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use DatabaseTransactions;

    private const TRC20_WALLET = 'TXYZopYRdj2D9XRtbG411XZZ3kM5VkAeBf';

    private const BEP20_WALLET = '0x1234567890abcdef1234567890ABCDEF12345678';

    public function test_the_moreno_invoices_page_shows_the_payment_methods_section(): void
    {
        Theme::setThemeName('moreno');
        View::addNamespace('theme.moreno', platform_path('themes/moreno'));

        $member = $this->member();
        $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test'], true);

        $this->actingAs($member, 'member')
            ->get(route('public.member.invoices'))
            ->assertOk()
            ->assertSee('Métodos de pago')
            ->assertSee('cobros@example.test')
            ->assertSee('Predeterminado');
    }

    public function test_the_first_method_added_becomes_the_default(): void
    {
        $member = $this->member();

        $this->actingAs($member, 'member')
            ->post(route('public.member.payment-methods.store'), [
                'type' => 'paypal',
                'email' => 'cobros@example.test',
            ])
            ->assertRedirect(route('public.member.invoices').'#metodos-de-pago')
            ->assertSessionHas('success_msg');

        $method = $member->paymentMethods()->sole();

        $this->assertSame(PaymentMethodType::PAYPAL, $method->type);
        $this->assertSame(['email' => 'cobros@example.test'], $method->details);
        $this->assertTrue($method->is_default);
    }

    public function test_details_are_stored_encrypted(): void
    {
        $member = $this->member();
        $method = $this->paymentMethod($member, PaymentMethodType::USDT_TRC20, ['wallet' => self::TRC20_WALLET], true);

        $raw = MemberPaymentMethod::query()->toBase()->where('id', $method->getKey())->value('details');

        $this->assertStringNotContainsString(self::TRC20_WALLET, $raw);
    }

    public function test_a_later_method_only_becomes_default_when_asked(): void
    {
        $member = $this->member();
        $paypal = $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test'], true);

        $this->actingAs($member, 'member')->post(route('public.member.payment-methods.store'), [
            'type' => 'usdt_bep20',
            'wallet' => self::BEP20_WALLET,
        ]);

        $this->assertTrue($paypal->fresh()->is_default);

        $this->actingAs($member, 'member')->post(route('public.member.payment-methods.store'), [
            'type' => 'usdt_trc20',
            'wallet' => self::TRC20_WALLET,
            'is_default' => '1',
        ]);

        $this->assertFalse($paypal->fresh()->is_default);
        $this->assertSame(PaymentMethodType::USDT_TRC20, $member->defaultPaymentMethod()->sole()->type);
    }

    public function test_bank_transfer_keeps_only_its_own_fields(): void
    {
        $member = $this->member();

        $this->actingAs($member, 'member')->post(route('public.member.payment-methods.store'), [
            'type' => 'bank',
            'bank_name' => 'Banco Popular',
            'account_holder' => 'Test Creator',
            'account_number' => '000123456789',
            'email' => 'ignorado@example.test',
        ])->assertSessionHasNoErrors();

        $this->assertSame([
            'bank_name' => 'Banco Popular',
            'account_holder' => 'Test Creator',
            'account_number' => '000123456789',
        ], $member->paymentMethods()->sole()->details);
    }

    public function test_invalid_data_is_rejected(): void
    {
        $member = $this->member();

        $cases = [
            [['type' => 'bitcoin'], 'type'],
            [['type' => 'paypal', 'email' => 'no-es-un-correo'], 'email'],
            [['type' => 'usdt_trc20', 'wallet' => self::BEP20_WALLET], 'wallet'],
            [['type' => 'usdt_bep20', 'wallet' => self::TRC20_WALLET], 'wallet'],
            [['type' => 'bank', 'bank_name' => 'Banco Popular'], 'account_number'],
        ];

        foreach ($cases as [$payload, $field]) {
            $this->actingAs($member, 'member')
                ->post(route('public.member.payment-methods.store'), $payload)
                ->assertSessionHasErrors($field);
        }

        $this->assertSame(0, $member->paymentMethods()->count());
    }

    public function test_a_member_can_switch_the_default_method(): void
    {
        $member = $this->member();
        $paypal = $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test'], true);
        $wallet = $this->paymentMethod($member, PaymentMethodType::USDT_TRC20, ['wallet' => self::TRC20_WALLET]);

        $this->actingAs($member, 'member')
            ->post(route('public.member.payment-methods.default', $wallet->getKey()))
            ->assertSessionHas('success_msg');

        $this->assertFalse($paypal->fresh()->is_default);
        $this->assertTrue($wallet->fresh()->is_default);
    }

    public function test_deleting_the_default_promotes_another_method(): void
    {
        $member = $this->member();
        $paypal = $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test'], true);
        $wallet = $this->paymentMethod($member, PaymentMethodType::USDT_TRC20, ['wallet' => self::TRC20_WALLET]);

        $this->actingAs($member, 'member')
            ->delete(route('public.member.payment-methods.destroy', $paypal->getKey()))
            ->assertSessionHas('success_msg');

        $this->assertModelMissing($paypal);
        $this->assertTrue($wallet->fresh()->is_default);
    }

    public function test_a_member_cannot_touch_someone_elses_methods(): void
    {
        $owner = $this->member();
        $method = $this->paymentMethod($owner, PaymentMethodType::PAYPAL, ['email' => 'cobros@example.test'], true);
        $intruder = $this->member();

        $this->actingAs($intruder, 'member')
            ->post(route('public.member.payment-methods.default', $method->getKey()))
            ->assertNotFound();

        $this->actingAs($intruder, 'member')
            ->delete(route('public.member.payment-methods.destroy', $method->getKey()))
            ->assertNotFound();

        $this->assertModelExists($method);
    }

    public function test_the_number_of_methods_is_capped(): void
    {
        $member = $this->member();

        foreach (range(1, PaymentMethodController::MAX_METHODS) as $index) {
            $this->paymentMethod($member, PaymentMethodType::PAYPAL, ['email' => "cobros{$index}@example.test"], $index === 1);
        }

        $this->actingAs($member, 'member')
            ->post(route('public.member.payment-methods.store'), [
                'type' => 'paypal',
                'email' => 'otro@example.test',
            ])
            ->assertSessionHas('error_msg');

        $this->assertSame(PaymentMethodController::MAX_METHODS, $member->paymentMethods()->count());
    }

    public function test_a_guest_is_sent_to_the_login(): void
    {
        $this->post(route('public.member.payment-methods.store'), ['type' => 'paypal', 'email' => 'cobros@example.test'])
            ->assertRedirect(route('public.member.login'));
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

    /**
     * @param  array<string, string>  $details
     */
    protected function paymentMethod(Member $member, PaymentMethodType $type, array $details, bool $isDefault = false): MemberPaymentMethod
    {
        return $member->paymentMethods()->create([
            'type' => $type,
            'details' => $details,
            'is_default' => $isDefault,
        ]);
    }
}
