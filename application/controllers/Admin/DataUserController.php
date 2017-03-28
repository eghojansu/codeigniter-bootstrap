<?php

class DataUserController extends MY_Controller
{
    protected $homePath = 'admin/data/user';

    public function __construct()
    {
        parent::__construct();

        $this->access(self::USER_ADMIN)->orRedirect();

        $this->load->model('user');
        $this->data['menu_active'] = $this->homePath;
    }

    public function indexAction()
    {
        $filter = [];
        $keyword = $this->input->get('keyword');
        if ($keyword) {
            $filter['name like'] = "%$keyword%";
        }

        $subset = $this->user->paginate($filter);
        $this->viewBack('admin/user/index', [
            'subset'=>$subset,
            'keyword'=>$keyword,
        ]);
    }

    public function createAction()
    {
        if ($this->isPost() && $this->isValid()) {
            $this->user->save([
                'name'=>$this->input->post('name'),
                'roles'=>$this->input->post('roles'),
                'username'=>$this->input->post('username'),
                'password'=>Bcrypt::create()->hash($this->input->post('password')),
                'active'=>$this->input->post('active', 0),
            ]);

            $this->addFlash('success', 'Data has been saved');
            $this->gotoHome();
        }

        $this->viewBack('admin/user/form');
    }

    public function updateAction($id)
    {
        $record = $this->loadModel($id);

        if ($this->isPost() && $this->isValid($id)) {
            $password = $this->input->post('password');
            $this->user->save([
                'name'=>$this->input->post('name'),
                'roles'=>$this->input->post('roles'),
                'username'=>$this->input->post('username'),
                'password'=>$password?Bcrypt::create()->hash($password):$record['password'],
                'active'=>$this->input->post('active', 0),
            ], [
                'id'=>$id,
            ]);

            $this->addFlash('success', 'Data has been saved');
            $this->gotoHome();
        }

        $this->viewBack('admin/user/form', [
            'old'=>$record,
        ]);
    }

    public function deleteAction($id)
    {
        $record = $this->loadModel($id);
        $this->user->delete(['id'=>$id]);

        $this->json([
            'success'=>true,
            'message'=>'Data has been deleted',
        ]);
    }

    protected function loadModel($id)
    {
        $record = $this->user->find($id);

        if (empty($record)) {
            show_404();
        }

        return $record;
    }

    protected function isValid($id = null)
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('roles', 'Required', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|validateUnique[user,username,'.$id.']');
        if (!$id) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        }

        return $this->form_validation->run();
    }
}
