<?php

namespace Botble\Partner\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static PartnerRoleEnum CREATOR()
 * @method static PartnerRoleEnum PARTNER()
 */
class PartnerRoleEnum extends Enum
{
    public const CREATOR = 'creator';

    public const PARTNER = 'partner';

    public static $langPath = 'plugins/partner::partner.roles';

    public function toHtml(): string|HtmlString
    {
        return match ($this->value) {
            self::PARTNER => Html::tag('span', self::PARTNER()->label(), ['class' => 'badge bg-info text-info-fg']),
            self::CREATOR => Html::tag('span', self::CREATOR()->label(), ['class' => 'badge bg-secondary text-secondary-fg']),
            default => parent::toHtml(),
        };
    }
}
