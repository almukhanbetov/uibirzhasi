<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing;
use App\Models\BuyRequest;

class UpdatePricesCommand extends Command
{
    protected $signature = 'prices:update';
    protected $description = 'Ежедневное обновление цен объявлений и заявок';

    public function handle()
    {
        // 🔻 Понижаем цены продавцов (Listings)
        Listing::where('moderation', 'approved')->chunk(200, function ($listings) {
            foreach ($listings as $listing) {
                $listing->price_current = $listing->price_current * 0.99;
                $listing->save();
            }
        });

        // 🔺 Увеличиваем бюджеты покупателей (BuyRequests)
        BuyRequest::chunk(200, function ($requests) {
            foreach ($requests as $req) {
                $req->budget_current = $req->budget_current * 1.01;
                $req->save();
            }
        });

        $this->info('Цены обновлены успешно!');
        return Command::SUCCESS;
    }
}
