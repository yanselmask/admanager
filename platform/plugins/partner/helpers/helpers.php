<?php

use Botble\Member\Models\Member;

if (! function_exists('is_partner')) {
    function is_partner(?Member $member = null): bool
    {
        $member ??= auth('member')->user();

        return $member instanceof Member && $member->getAttribute('role') === 'partner';
    }
}

if (! function_exists('current_partner')) {
    function current_partner(): ?Member
    {
        $member = auth('member')->user();

        return $member instanceof Member && is_partner($member) ? $member : null;
    }
}
