<?php

namespace Tests\Feature\Partner;

use Botble\Domain\Models\Domain;
use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Http\Requests\PartnerNetworkRequest;
use Botble\Partner\Http\Requests\PartnerRequest;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Setting\Facades\Setting;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PartnerNetworkAssignmentTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::set('admanager_networks', json_encode([
            [['key' => 'name', 'value' => 'Cuenta A'], ['key' => 'code', 'value' => '123456']],
            [['key' => 'name', 'value' => 'Cuenta B'], ['key' => 'code', 'value' => '789012']],
        ]))->save();
    }

    protected function tearDown(): void
    {
        Setting::forget('admanager_networks');

        parent::tearDown();
    }

    // --- Asignación ---------------------------------------------------------------------

    public function test_a_network_can_be_assigned_to_a_partner(): void
    {
        $partner = $this->partner();

        $this->assertTrue($this->networkValidator($partner, '123456')->passes());

        $this->network($partner, '123456');
        $domain = $this->domain('123456');

        $this->assertSame(1, $partner->partnerNetworks()->count());
        $this->assertContains($domain->url, $partner->partnerDomains()->pluck('url')->all());
    }

    public function test_several_networks_can_be_assigned_to_the_same_partner(): void
    {
        $partner = $this->partner();
        $this->network($partner, '123456');
        $this->network($partner, '789012');

        $this->domain('123456');
        $this->domain('789012', url: 'second.test');

        $this->assertSame(2, $partner->partnerNetworks()->count());
        $this->assertSame(2, $partner->partnerDomains()->count());
    }

    public function test_a_network_code_not_configured_in_ad_manager_is_rejected(): void
    {
        $partner = $this->partner();

        $validator = $this->networkValidator($partner, '555555');

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('network_code', $validator->errors()->toArray());
    }

    public function test_a_member_that_is_not_a_partner_cannot_be_assigned_a_network(): void
    {
        $creator = $this->creator();

        $validator = $this->networkValidator($creator, '123456');

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('member_id', $validator->errors()->toArray());
    }

    // --- Exclusividad -------------------------------------------------------------------

    public function test_a_network_already_owned_by_another_partner_is_rejected_naming_it(): void
    {
        $owner = $this->partner(firstName: 'Ana');
        $this->network($owner, '123456');

        $other = $this->partner(firstName: 'Beto');
        $validator = $this->networkValidator($other, '123456');

        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('Ana', $validator->errors()->first('network_code'));
    }

    public function test_a_network_can_be_reassigned_after_being_released(): void
    {
        $first = $this->partner();
        $assignment = $this->network($first, '123456');
        $domain = $this->domain('123456');

        $assignment->delete();

        $second = $this->partner();
        $this->assertTrue($this->networkValidator($second, '123456')->passes());

        $this->network($second, '123456');

        $this->assertSame(0, $first->partnerDomains()->count());
        $this->assertContains($domain->url, $second->partnerDomains()->pluck('url')->all());
    }

    public function test_the_database_rejects_a_duplicated_network_code(): void
    {
        $this->network($this->partner(), '123456');

        $this->expectException(QueryException::class);

        PartnerNetwork::query()->create([
            'member_id' => $this->partner()->getKey(),
            'network_code' => '123456',
        ]);
    }

    public function test_editing_an_assignment_does_not_collide_with_itself(): void
    {
        $partner = $this->partner();
        $assignment = $this->network($partner, '123456');

        $validator = $this->networkValidator($partner, '123456', currentId: $assignment->getKey());

        $this->assertTrue($validator->passes());
    }

    // --- Retirada -----------------------------------------------------------------------

    public function test_removing_an_assignment_keeps_the_domain_metrics_untouched(): void
    {
        $partner = $this->partner();
        $assignment = $this->network($partner, '123456');
        $domain = $this->domain('123456', earnings: ['today' => 100_000_000], impressions: ['today' => 5000]);

        $assignment->delete();

        $domain->refresh();

        $this->assertSame(['today' => 100_000_000], $domain->earnings);
        $this->assertSame(['today' => 5000], $domain->impressions);
        $this->assertSame(0, $partner->partnerDomains()->count());
    }

    // --- Rol ------------------------------------------------------------------------------

    public function test_the_partner_request_rejects_a_commission_out_of_range(): void
    {
        foreach ([-1, 101, 150] as $commission) {
            $validator = $this->partnerValidator($this->creator(), $commission);

            $this->assertTrue($validator->fails(), "La comisión {$commission} debería rechazarse");
            $this->assertArrayHasKey('commission', $validator->errors()->toArray());
        }
    }

    public function test_the_partner_request_accepts_a_commission_inside_the_range(): void
    {
        foreach ([0, 10, 100, null] as $commission) {
            $this->assertTrue(
                $this->partnerValidator($this->creator(), $commission)->passes(),
                'La comisión '.var_export($commission, true).' debería aceptarse'
            );
        }
    }

    public function test_the_partner_request_rejects_an_unknown_role(): void
    {
        $validator = $this->partnerValidator($this->creator(), 10, role: 'administrator');

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('role', $validator->errors()->toArray());
    }

    public function test_demoting_a_partner_keeps_its_assignments(): void
    {
        $partner = $this->partner();
        $this->network($partner, '123456');

        $partner->setAttribute('role', PartnerRoleEnum::CREATOR);
        $partner->save();

        $this->assertSame(1, $partner->partnerNetworks()->count());
        $this->assertSame(PartnerRoleEnum::CREATOR, $partner->fresh()->role);
    }

    // --- Utilidades -------------------------------------------------------------------------

    protected function networkValidator(Member $member, string $networkCode, ?int $currentId = null): \Illuminate\Validation\Validator
    {
        $request = new PartnerNetworkRequest;

        if ($currentId !== null) {
            $request->setRouteResolver(fn () => new class($currentId)
            {
                public function __construct(protected int $id) {}

                public function parameter(string $name)
                {
                    return $name === 'partner_network' ? $this->id : null;
                }
            });
        }

        return Validator::make([
            'member_id' => $member->getKey(),
            'network_code' => $networkCode,
        ], $request->rules());
    }

    protected function partnerValidator(Member $member, mixed $commission, string $role = PartnerRoleEnum::PARTNER): \Illuminate\Validation\Validator
    {
        return Validator::make([
            'member_id' => $member->getKey(),
            'role' => $role,
            'commission' => $commission,
        ], (new PartnerRequest)->rules());
    }

    protected function member(string $role, ?float $commission = null, string $firstName = 'Test'): Member
    {
        return Member::query()->forceCreate([
            'first_name' => $firstName,
            'last_name' => 'Member',
            'username' => 'member_'.uniqid(),
            'email' => uniqid().'@example.test',
            'password' => 'secret-password',
            'role' => $role,
            'commission' => $commission,
        ]);
    }

    protected function partner(?float $commission = null, string $firstName = 'Test'): Member
    {
        return $this->member(PartnerRoleEnum::PARTNER, $commission, $firstName);
    }

    protected function creator(): Member
    {
        return $this->member(PartnerRoleEnum::CREATOR);
    }

    protected function network(Member $partner, string $networkCode, ?float $commission = null): PartnerNetwork
    {
        return PartnerNetwork::query()->create([
            'member_id' => $partner->getKey(),
            'network_code' => $networkCode,
            'commission' => $commission,
        ]);
    }

    protected function domain(string $networkCode, string $url = 'domain.test', array $earnings = [], array $impressions = []): Domain
    {
        return Domain::query()->forceCreate([
            'name' => $url,
            'url' => uniqid().'-'.$url,
            'network_code' => $networkCode,
            'earnings' => $earnings,
            'impressions' => $impressions,
        ]);
    }
}
