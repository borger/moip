<?php

namespace Artesaos\Moip;

use Illuminate\Contracts\Foundation\Application;
use Moip\Moip as Api;
use Moip\Auth\BasicAuth;

class Moip
{
    /**
     * The Laravel Application.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     **/
    private $app;

    /**
     * Class Moip sdk.
     *
     * @var \Moip\Moip
     **/
    private $moip;

    /**
     * Class constructor.
     * 
     * @param \Illuminate\Contracts\Foundation\Application $app The Laravel Application.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Start Moip sdk.
     */
    public function start()
    {
        $this->moip = $this->app->make(Api::class, [$this->app->make(BasicAuth::class, [config('services.moip.credentials.token'), config('services.moip.credentials.key')]), $this->getHomologated()]);

        return $this;
    }

    /**
     * Create a new Customer instance.
     *
     * @return \Moip\Resource\Customer
     */
    public function customers()
    {
        return $this->moip->customers();
    }

    /**
     * Create a new Entry instance.
     *
     * @return \Moip\Resource\Entry
     */
    public function entries()
    {
        return $this->moip->entries();
    }

    /**
     * Create a new Order instance.
     *
     * @return \Moip\Resource\Orders
     */
    public function orders()
    {
        return $this->moip->orders();
    }

    /**
     * Create a new Payment instance.
     *
     * @return \Moip\Resource\Payment
     */
    public function payments()
    {
        return $this->moip->payments();
    }

    /**
     * Create a new Multiorders instance.
     *
     * @return \Moip\Resource\Multiorders
     */
    public function multiorders()
    {
        return $this->moip->multiorders();
    }

    /**
     * Get endpoint of request.
     * 
     * @return \Moip\Moip::ENDPOINT_PRODUCTION|\Moip\Moip::ENDPOINT_SANDBOX
     */
    private function getHomologated()
    {
        return config('services.moip.homologated') === true ? Api::ENDPOINT_PRODUCTION : Api::ENDPOINT_SANDBOX;
    }
}
