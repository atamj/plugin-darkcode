<?php 

class Api
{
    /**
     * RouteManager constructor.
     */
    public function __construct()
    {
        add_action("rest_api_init",[$this,"initRoute"]);
    }

    public function initRoute()
    {
        new Routes();
    }

}