<?php

namespace App\Interfaces;

interface UserInterface
{
    public function getAuthUser($token);
    public function getUser($id);
}