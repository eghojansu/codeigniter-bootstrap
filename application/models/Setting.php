<?php

class Setting extends MY_Model
{
    public $values;

    /**
     * Init setting values
     */
    public function __construct()
    {
        parent::__construct();

        $this->loadSetting();
    }

    /**
     * Reload setting values
     *
     * @return Object this instance
     */
    public function loadSetting()
    {
        $this->values = $this->fetchAssoc('name', ['content']) + [
            'app_title' => 'App Title',
            'app_alias' => 'AT',
            'app_name' => 'App Name',
            'app_owner' => 'App Owner',
        ];

        return $this;
    }
}
