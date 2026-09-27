<?php

namespace Botble\Member\Enums;

enum PaymentMethodType: string
{
    case PAYPAL = 'paypal';
    case USDT_TRC20 = 'usdt_trc20';
    case USDT_BEP20 = 'usdt_bep20';
    case BANK = 'bank';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::PAYPAL => 'PayPal',
            self::USDT_TRC20 => 'USDT (TRC20)',
            self::USDT_BEP20 => 'USDT (BEP20)',
            self::BANK => 'Transferencia bancaria',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PAYPAL => 'fab fa-paypal',
            self::USDT_TRC20, self::USDT_BEP20 => 'fas fa-coins',
            self::BANK => 'fas fa-university',
        };
    }

    /**
     * Datos que el creador debe dar para cobrar por este método, en el orden en que se muestran.
     *
     * @return array<string, array{label: string, placeholder: string, rules: array<int, string>}>
     */
    public function fields(): array
    {
        return match ($this) {
            self::PAYPAL => [
                'email' => ['label' => 'Correo de PayPal', 'placeholder' => 'tu@correo.com', 'rules' => ['required', 'email', 'max:191']],
            ],
            self::USDT_TRC20 => [
                'wallet' => ['label' => 'Dirección de la wallet (TRC20)', 'placeholder' => 'T…', 'rules' => ['required', 'string', 'regex:/^T[1-9A-HJ-NP-Za-km-z]{33}$/']],
            ],
            self::USDT_BEP20 => [
                'wallet' => ['label' => 'Dirección de la wallet (BEP20)', 'placeholder' => '0x…', 'rules' => ['required', 'string', 'regex:/^0x[a-fA-F0-9]{40}$/']],
            ],
            self::BANK => [
                'bank_name' => ['label' => 'Banco', 'placeholder' => 'Nombre del banco', 'rules' => ['required', 'string', 'max:120']],
                'account_holder' => ['label' => 'Titular', 'placeholder' => 'Nombre completo del titular', 'rules' => ['required', 'string', 'max:120']],
                'account_number' => ['label' => 'Número de cuenta / IBAN', 'placeholder' => 'Número de cuenta', 'rules' => ['required', 'string', 'max:60']],
                'swift' => ['label' => 'SWIFT / BIC (opcional)', 'placeholder' => 'Código SWIFT', 'rules' => ['nullable', 'string', 'max:20']],
            ],
        };
    }
}
