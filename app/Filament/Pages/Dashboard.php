<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\{
    StatInvoiceWidget,
    RevenueChartWidget,
};

class Dashboard extends BaseDashboard
{
    /**
     * Konfigurasi kolom untuk responsif layout.
     */
    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 3,
            'lg' => 6,
        ];
    }

    /**
     * Widget di bagian header, seperti info akun.
     */
    public function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }

    /**
     * Widget utama di dashboard.
     */
    public function getWidgets(): array
    {
        return [
            StatInvoiceWidget::class,
            RevenueChartWidget::class,
        ];
    }
}
