<?php

namespace App\Service\Domain;

use App\Http\Middleware\SessionProvider;
use App\Models\ApiUser;
use App\Models\Domain;
use Illuminate\Support\ServiceProvider;

class DomainService
{
    private ApiUser $user;
    private SessionProvider $sessionProvider;

    public function __construct(SessionProvider $sessionProvider) {
        $this->sessionProvider = $sessionProvider;
        $this->user = $this->sessionProvider->currentUser();
    }


    public function getAll() {

        return $domains = $this->user->domains;
    }


    public function getByName(string $name) {
        $domains = $this->user->domains()->where(['name'=>$name]);
        /*$domains = Domain::where(['name'=>$name, 'user_id'=>$this->user->id]);*/
        if($domains) {
            return $domains->first();
        }
        else {
            return NULL;
        }
    }

    public function getById(int $id){
        $domain = $this->user->domains()->find($id);

        return $domain;
    }



    public function activate(int $id) {
        return Domain::where(['id'=>$id, 'user_id'=>$this->user->id])->first()->activate();
    }


    public function deactivate(int $id) {
        return Domain::where(['id'=>$id, 'user_id'=>$this->user->id])->first()->deactivate();
    }


    public function create($name): bool {
        /*$domain = Domain::create($this->user->id, $name);*/
        /*return $this->user->associateDomain($domain);*/
        $domain = new Domain();
        $domain->name = $name;
        $domain->status_id = 1;

        return $this->user->associateDomain($domain);
    }
}
