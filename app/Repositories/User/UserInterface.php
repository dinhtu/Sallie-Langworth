<?php

namespace App\Repositories\User;

interface UserInterface
{
    public function getUsers($request);
    public function destroy($id);
    public function checkEmail($request);
    public function store($request);
    public function getById($id);
    public function update($request, $id);
}
