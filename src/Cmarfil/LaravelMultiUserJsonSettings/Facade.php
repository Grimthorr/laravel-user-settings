<?php

namespace Cmarfil\LaravelMultiUserJsonSettings;


class Facade extends \Illuminate\Support\Facades\Facade {

    protected static function getFacadeAccessor()
    {
        return 'Cmarfil\LaravelMultiUserJsonSettings\Setting';
    }

}
