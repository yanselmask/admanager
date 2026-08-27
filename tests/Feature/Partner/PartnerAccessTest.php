<?php

namespace Tests\Feature\Partner;

use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Models\PartnerNetwork;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PartnerAccessTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_partner_asking_for_the_creator_dashboard_is_sent_to_its_own_panel(): void
    {
        $this->actingAs($this->partner(), 'member')
            ->get(route('public.member.dashboard'))
            ->assertRedirect(route('partner.dashboard'));
    }

    public function test_a_creator_asking_for_the_partner_dashboard_is_sent_to_its_own_panel(): void
    {
        $this->actingAs($this->creator(), 'member')
            ->get(route('partner.dashboard'))
            ->assertRedirect(route('public.member.dashboard'));
    }

    public function test_a_guest_is_sent_to_the_member_login(): void
    {
        $this->get(route('partner.dashboard'))
            ->assertRedirect(route('public.member.login'));

        $this->get(route('partner.accounts'))
            ->assertRedirect(route('public.member.login'));

        $this->get(route('partner.domains'))
            ->assertRedirect(route('public.member.login'));
    }

    public function test_a_partner_reaches_every_route_of_its_own_panel(): void
    {
        $partner = $this->partner();

        foreach (['partner.dashboard', 'partner.accounts', 'partner.domains'] as $route) {
            $this->actingAs($partner, 'member')
                ->get(route($route))
                ->assertOk();
        }
    }

    public function test_the_redirection_after_login_lands_a_partner_on_its_panel(): void
    {
        // El login de miembros termina en redirect()->intended('/account/dashboard');
        // el middleware global rebota esa llegada al panel del partner.
        $this->actingAs($this->partner(), 'member')
            ->followingRedirects()
            ->get(route('public.member.dashboard'))
            ->assertOk();
    }

    public function test_other_member_routes_keep_working_for_a_partner(): void
    {
        // Solo se rescata al partner del panel de creadores: ajustes, KYC y logout
        // le siguen sirviendo con normalidad.
        $this->actingAs($this->partner(), 'member')
            ->get(route('public.member.settings'))
            ->assertOk();
    }

    public function test_a_creator_keeps_reaching_its_own_dashboard(): void
    {
        $this->actingAs($this->creator(), 'member')
            ->get(route('public.member.dashboard'))
            ->assertOk();
    }

    public function test_a_partner_only_sees_the_domains_of_its_networks(): void
    {
        $partner = $this->partner();
        PartnerNetwork::query()->create([
            'member_id' => $partner->getKey(),
            'network_code' => '123456',
        ]);

        $mine = $this->domain('123456', 'mine.test');
        $foreign = $this->domain('999999', 'foreign.test');

        $this->actingAs($partner, 'member')
            ->get(route('partner.domains'))
            ->assertOk()
            ->assertSee($mine->url)
            ->assertDontSee($foreign->url);
    }

    public function test_a_network_that_does_not_belong_to_the_partner_returns_nothing(): void
    {
        $partner = $this->partner();
        PartnerNetwork::query()->create([
            'member_id' => $partner->getKey(),
            'network_code' => '123456',
        ]);

        $this->domain('999999', 'foreign.test');

        $this->actingAs($partner, 'member')
            ->get(route('partner.domains', ['network' => '999999']))
            ->assertOk()
            ->assertDontSee('foreign.test');
    }

    protected function member(string $role): Member
    {
        return Member::query()->forceCreate([
            'first_name' => 'Test',
            'last_name' => ucfirst($role),
            'username' => 'member_'.uniqid(),
            'email' => uniqid().'@example.test',
            'password' => 'secret-password',
            'role' => $role,
        ]);
    }

    protected function partner(): Member
    {
        return $this->member(PartnerRoleEnum::PARTNER);
    }

    protected function creator(): Member
    {
        return $this->member(PartnerRoleEnum::CREATOR);
    }

    protected function domain(string $networkCode, string $url)
    {
        return \Botble\Domain\Models\Domain::query()->forceCreate([
            'name' => $url,
            'url' => uniqid().'-'.$url,
            'network_code' => $networkCode,
        ]);
    }
}
