<?php

namespace Tests\Feature\Partner;

use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Supports\PartnerHelper;
use Botble\Setting\Facades\Setting;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PartnerCommissionTest extends TestCase
{
    use DatabaseTransactions;

    protected function tearDown(): void
    {
        Setting::forget('partner_percentage_default');

        parent::tearDown();
    }

    public function test_a_member_defaults_to_the_creator_role(): void
    {
        $member = $this->createMember();

        $this->assertSame(PartnerRoleEnum::CREATOR, $member->role);
        $this->assertFalse(PartnerHelper::isPartner($member));
        $this->assertTrue(PartnerHelper::isCreator($member));
    }

    public function test_a_promoted_member_is_recognised_as_a_partner(): void
    {
        $partner = $this->createPartner();

        $this->assertTrue(PartnerHelper::isPartner($partner));
        $this->assertFalse(PartnerHelper::isCreator($partner));
    }

    public function test_the_network_commission_wins_over_the_partner_commission(): void
    {
        $partner = $this->createPartner(commission: 10);
        $network = $this->assignNetwork($partner, '111111', commission: 15);

        $this->setGlobalPercentage(5);

        $this->assertSame(15.0, PartnerHelper::resolveCommission($partner, $network));
    }

    public function test_the_partner_commission_is_used_when_the_network_has_none(): void
    {
        $partner = $this->createPartner(commission: 12);
        $network = $this->assignNetwork($partner, '222222', commission: null);

        $this->setGlobalPercentage(5);

        $this->assertSame(12.0, PartnerHelper::resolveCommission($partner, $network));
    }

    public function test_the_global_setting_is_used_when_neither_defines_a_commission(): void
    {
        $partner = $this->createPartner(commission: null);
        $network = $this->assignNetwork($partner, '333333', commission: null);

        $this->setGlobalPercentage(10);

        $this->assertSame(10.0, PartnerHelper::resolveCommission($partner, $network));
    }

    public function test_the_commission_falls_back_to_zero_when_nothing_defines_it(): void
    {
        $partner = $this->createPartner(commission: null);
        $network = $this->assignNetwork($partner, '444444', commission: null);

        Setting::forget('partner_percentage_default');

        $this->assertSame(0.0, PartnerHelper::resolveCommission($partner, $network));
    }

    public function test_the_commission_resolves_without_a_network(): void
    {
        $partner = $this->createPartner(commission: 20);

        $this->assertSame(20.0, PartnerHelper::resolveCommission($partner));
    }

    public function test_an_out_of_range_stored_commission_is_clamped(): void
    {
        $partner = $this->createPartner(commission: 10);

        $tooHigh = $this->assignNetwork($partner, '555555', commission: 150);
        $this->assertSame(100.0, PartnerHelper::resolveCommission($partner, $tooHigh));

        $negative = $this->assignNetwork($partner, '666666', commission: -20);
        $this->assertSame(0.0, PartnerHelper::resolveCommission($partner, $negative));
    }

    public function test_a_partner_reaches_the_domains_of_its_assigned_networks(): void
    {
        $partner = $this->createPartner();
        $this->assignNetwork($partner, '777777');

        $mine = $this->createDomain('mine.test', '777777');
        $other = $this->createDomain('other.test', '888888');

        $urls = $partner->partnerDomains()->pluck('url')->all();

        $this->assertContains($mine->url, $urls);
        $this->assertNotContains($other->url, $urls);
    }

    protected function createMember(array $attributes = []): Member
    {
        return Member::query()->forceCreate(array_merge([
            'first_name' => 'Test',
            'last_name' => 'Member',
            'username' => 'member_'.uniqid(),
            'email' => uniqid().'@example.test',
            'password' => 'secret-password',
        ], $attributes));
    }

    protected function createPartner(?float $commission = null): Member
    {
        return $this->createMember([
            'role' => PartnerRoleEnum::PARTNER,
            'commission' => $commission,
        ]);
    }

    protected function assignNetwork(Member $partner, string $networkCode, ?float $commission = null): PartnerNetwork
    {
        return PartnerNetwork::query()->create([
            'member_id' => $partner->getKey(),
            'network_code' => $networkCode,
            'commission' => $commission,
        ]);
    }

    protected function createDomain(string $url, string $networkCode)
    {
        return \Botble\Domain\Models\Domain::query()->forceCreate([
            'name' => $url,
            'url' => $url,
            'network_code' => $networkCode,
        ]);
    }

    protected function setGlobalPercentage(float $value): void
    {
        Setting::set('partner_percentage_default', $value)->save();
    }
}
