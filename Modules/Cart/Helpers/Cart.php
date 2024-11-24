<?php  namespace Modules\Cart\Helpers;
       use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
