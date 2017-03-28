<?php

class FrontController extends MY_Controller
{
	public function indexAction()
	{
		$this->viewFront('front/welcome');
	}

    public function loginAction()
    {
        $this->access(self::USER_GUEST)->orRedirect();

        $data = [
            'username'=>$this->input->post('username'),
            'password'=>$this->input->post('password'),
            'error'=>null,
        ];

        if ($this->isPost()) {
            $this->load->model('user');
            $record = $this->user->findOne(['username'=>$data['username']]);

            if (empty($record)) {
                // user not found
                $data['error'] = 'Invalid credential.';
            } elseif (false === Bcrypt::create()->verify($data['password'], $record['password'])) {
                // invalid password
                $data['error'] = 'Invalid credential.';
            } elseif (!$record['active']) {
                // user not active
                $data['error'] = 'Your account was expired.';
            } else {
                // all green
                $this->setUserData($record['id'], $record['roles'], $record);
                if ($this->hasRoles(self::USER_ADMIN)) {
                    redirect('admin');
                }

                redirect('/');
            }
        }

        $this->load->view('layout/login', $data);
    }

    public function logoutAction()
    {
        $this->clearUserData();
        redirect('/');
    }
}
