<?php

namespace App\Observers;

trait ChatObserver
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($chat) {

        });

        static::updated(function ($chat) {

        });

        static::deleted(function ($chat) {

        });

    }
}