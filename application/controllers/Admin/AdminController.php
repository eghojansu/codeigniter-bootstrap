<?php

class AdminController extends MY_Controller
{
    public function indexAction()
    {
        $this->access(self::USER_ADMIN)->orRedirect();

        $this->viewBack('dashboard/index', [
            'menu_active'=>'admin',
        ]);
    }

    public function profileAction()
    {
        $this->access(self::USER_ADMIN)->orRedirect();

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

        $this->viewBack('dashboard/profile');
    }

    public function pengaturanAction()
    {
        $this->access(self::USER_ADMIN)->orRedirect();

        $setting = [
            'app_title' => 'App Title',
            'app_alias' => 'AT',
            'app_name' => 'App Name',
            'app_owner' => 'App Owner',
        ];
        foreach ($setting as $key => $label) {
            $this->form_validation->set_rules($key, $label, 'required|max_length[100]');
        }

        if ($this->isPost() && $this->form_validation->run()) {
            foreach ($setting as $key => $label) {
                $record = $this->setting->findOne(['name'=>$key]);
                $filter = $record?['id'=>$record['id']]:null;

                $this->setting->save([
                    'content'=>$this->input->post($key),
                    'name'=>$key,
                ], $filter);
            }

            $this->addFlash('success', 'Setting has been updated');
            redirect(current_url());
        }

        $this->viewBack('admin/pengaturan');
    }
}
