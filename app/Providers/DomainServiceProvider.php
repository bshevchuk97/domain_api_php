<?php

namespace App\Providers;

use App\Http\Controllers\DomainController;
use App\Http\Middleware\SessionProvider;
use App\Service\Domain\DomainService;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register() {
        /*$this->app->bind(DomainService::class, function (){
            $session = SessionProvider::currentSession();
            return $session->user;
        });
        $this->app->bind(DomainController::class, function (){
            $domainService = $this->app->make(DomainService::class);

            return $domainService;

        });*/
    }
}
