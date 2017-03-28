<?php

class MemberController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->access(self::USER_MEMBER)->orRedirect();
    }

    public function indexAction()
    {
        $this->viewFront('member/index');
    }

    public function profileAction()
    {
        $this->form_validation->set_rules('password', 'Password', 'required|validatePassword['.$this->userData['password'].']');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[20]|validateUnique[user,username,'.$this->userData['id'].']');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[30]');

        if ($this->isPost() && $this->form_validation->run()) {
            $this->load->model('user');

            $newPassword = $this->input->post('newPassword');
            $this->user->save([
                'username'=>$this->input->post('username'),
                'name'=>$this->input->post('name'),
                'password'=>$newPassword?Bcrypt::create()->hash($newPassword):$this->userData['password'],
            ], ['id'=>$this->userData['id']]);

            $record = $this->user->find($this->userData['id']);
            $this->setUserData($record['id'], $record['roles'], $record);

            $this->addFlash('success', 'Profile has been updated');
            redirect(current_url());
        }

        $this->viewFront('dashboard/profile');
    }
}
