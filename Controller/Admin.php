<?php

/**
 * FOSSBilling.
 *
 * @copyright FOSSBilling (https://www.fossbilling.org)
 * @license   Apache-2.0
 *
 * Copyright FOSSBilling 2022
 * This software may contain code previously used in the BoxBilling project.
 * Copyright BoxBilling, Inc 2011-2021
 *
 * This source file is subject to the Apache-2.0 License that is bundled
 * with this source code in the file LICENSE
 */

namespace Box\Mod\Servicesaas\Controller;

class Admin implements \Box\InjectionAwareInterface
{
    protected $di;

    /**
     * @param mixed $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * @return mixed
     */
    public function getDi()
    {
        return $this->di;
    }

    public function fetchNavigation()
    {
        return [
            'subpages' => [
                [
                    'location' => 'system',
                    'index' => 140,
                    'label' => 'Hosting plans and servers',
                    'uri' => $this->di['url']->adminLink('Servicesaas'),
                    'class' => '',
                ],
            ],
        ];
    }

    public function register(\Box_App &$app)
    {
        $app->get('/Servicesaas', 'get_index', null, get_class($this));
        $app->get('/Servicesaas/plan/:id', 'get_plan', ['id' => '[0-9]+'], get_class($this));
        $app->get('/Servicesaas/server/:id', 'get_server', ['id' => '[0-9]+'], get_class($this));
    }

    public function get_index(\Box_App $app)
    {
        $this->di['is_admin_logged'];

        return $app->render('mod_Servicesaas_index');
    }

    public function get_plan(\Box_App $app, $id)
    {
        $api = $this->di['api_admin'];
        $hp = $api->Servicesaas_hp_get(['id' => $id]);

        return $app->render('mod_Servicesaas_hp', ['hp' => $hp]);
    }

    public function get_server(\Box_App $app, $id)
    {
        $api = $this->di['api_admin'];
        $server = $api->Servicesaas_server_get(['id' => $id]);

        return $app->render('mod_Servicesaas_server', ['server' => $server]);
    }
}
