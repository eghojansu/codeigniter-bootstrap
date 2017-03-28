<?php

class LaporanController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->access(self::USER_ADMIN)->orRedirect();
    }

    public function userAction()
    {
        $this->load->model('user');
        $subset = $this->user->findAll();

        $this->viewBack('admin/laporan/user', [
            'subset'=>[
                'items'=>$subset,
                'firstNumber'=>0,
            ],
        ]);
    }
}
