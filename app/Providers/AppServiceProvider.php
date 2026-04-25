<?php

namespace App\Providers;

use App\Models\BudgetHeader;
use App\Models\VWBudgetEntry;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // Share budget alerts with the header on every authenticated page load.
        // Flags any budget line at 80 %+ utilisation so the bell icon stays current.
        View::composer('layouts.header', function ($view) {
            if (!auth()->check()) {
                $view->with('budgetAlerts', collect());
                return;
            }

            $activeHeader = BudgetHeader::where('status', 1)->first();

            if (!$activeHeader) {
                $view->with('budgetAlerts', collect());
                return;
            }

            $alerts = VWBudgetEntry::where('header_id', $activeHeader->id)
                ->where('amount', '>', 0)
                ->where('status', '>=', 1)
                ->with(['department', 'category'])
                ->get()
                ->filter(fn ($entry) => $entry->amount > 0 && ($entry->amount_used / $entry->amount) >= 0.80)
                ->map(fn ($entry) => [
                    'id'         => $entry->id,
                    'name'       => $entry->name,
                    'department' => $entry->department->name ?? 'N/A',
                    'pct'        => round(($entry->amount_used / $entry->amount) * 100, 1),
                    'level'      => $entry->amount_used >= $entry->amount ? 'danger' : 'warning',
                ])
                ->sortByDesc('pct')
                ->values();

            $view->with('budgetAlerts', $alerts);
        });
    }
}
