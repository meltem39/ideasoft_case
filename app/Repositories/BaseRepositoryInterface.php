<?php

namespace App\Repositories;

interface BaseRepositoryInterface {

    public function authUser();

    public function create(array $data);
}
