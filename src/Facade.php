<?php

namespace Grimthorr\LaravelUserSettings;


class Facade extends \Illuminate\Support\Facades\Facade {

    protected static function getFacadeAccessor()
    {
        return 'setting';
    }
    
}
