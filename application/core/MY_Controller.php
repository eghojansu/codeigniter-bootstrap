<?php

/**
 * Extends core controller common functions
 */
class MY_Controller extends CI_Controller
{
    const USER_ADMIN = 'ROLE_ADMIN';
    const USER_MEMBER = 'ROLE_MEMBER';
    const USER_GUEST = 'ROLE_GUEST';

    const KEY_FLASH = 'FLASH';

    protected $homePath = '/';
    protected $data = [
        'redirect'=>null,
        'redirectFlag'=>null,
    ];
    protected $userData;
    protected $userDataTemplate = [
        'id'=>null,
        'username'=>null,
        'name'=>'Anonymous',
        'roles'=>[self::USER_GUEST],
        'login'=>false,
    ];

    /**
     * Construct controller
     */
    public function __construct()
    {
        parent::__construct();

        $this->loadUserData();
    }

    /**
     * Check Access
     *
     * @param  string $role
     * @return Object This instance
     */
    protected function access($role)
    {
        if (!$this->hasRoles($role)) {
            $paths = [
                self::USER_ADMIN=>[
                    'login'=>'login',
                    'home'=>'admin',
                ],
                self::USER_MEMBER=>[
                    'login'=>'login',
                    'home'=>'member',
                ],
            ];

            if ($this->hasRoles(self::USER_GUEST)) {
                $this->data['redirect'] = '/';
                foreach ($paths as $role => $path) {
                    if ($this->hasRoles($role)) {
                        $this->data['redirect'] = $path['home'];
                        break;
                    }
                }
            } elseif (array_key_exists($role, $paths)) {
                $this->data['redirect'] = $paths[$role]['login'];
            }
        }

        return $this;
    }

    /**
     * Check user role
     *
     * @param  array|string  $checkedRole
     * @param  boolean $checkAll
     * @return boolean
     */
    protected function hasRoles($checkedRole, $checkAll = false)
    {
        $checkedRoles = is_array($checkedRole)?$checkedRole:explode(',', $checkedRole);
        $validCount = 0;

        foreach ($checkedRoles as $role) {
            $validCount += (int) in_array($role, $this->userData['roles']);
        }

        return ($validCount > 0?($checkAll ? $validCount === count($checkedRoles) : true):false);
    }

    /**
     * Is post request?
     *
     * @return boolean
     */
    protected function isPost()
    {
        return 'POST' === $this->input->method(true);
    }

    /**
     * Redirect to home path
     *
     * @return void
     */
    protected function gotoHome()
    {
        redirect($this->homePath);
    }

    /**
     * Perform redirection
     *
     * @param  string $uri
     * @return void
     */
    protected function orRedirectTo($uri)
    {
        if (!empty($this->data['redirectFlag'])) {
            redirect($uri);
        }
    }

    /**
     * Perform redirection to login page
     *
     * @return void
     */
    protected function orRedirect()
    {
        if (!empty($this->data['redirect'])) {
            redirect($this->data['redirect']);
        }
    }

    /**
     * Send json response
     *
     * @param  mixed $data
     * @return void
     */
    protected function json($data)
    {
        header('Content-type: application/json');

        echo is_string($data) ? $data : json_encode($data);
    }

    /**
     * Render view for back
     *
     * @param  string     $view
     * @param  array|null $data
     * @return void
     */
    protected function viewBack($view, array $data = null)
    {
        $data = ((array) $data) + $this->getLayoutData() + [
            'menu'=>$this->getDashboardMenu(),
            'menu_active'=>$this->uri->uri_string(),
        ];

        $this->load->view('layout/back_header.php', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/back_footer.php', $data);
    }

    /**
     * Render view for front
     *
     * @param  string     $view
     * @param  array|null $data
     * @return void
     */
    protected function viewFront($view, array $data = null)
    {
        $data = ((array) $data) + $this->getLayoutData();

        $this->load->view('layout/front_header.php', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/front_footer.php', $data);
    }

    /**
     * Load user data from session
     *
     * @return void
     */
    protected function loadUserData()
    {
        $this->userData = ($this->session->userData?:[]) + $this->userDataTemplate;
    }

    /**
     * Set current user
     *
     * @param mixed $id
     * @param array|string $roles self::USER_*
     * @param array  $data
     */
    protected function setUserData($id, $roles, array $data)
    {
        $this->userData = ['id'=>$id,'roles'=>is_array($roles)?$roles:explode(',', $roles),'login'=>true] + $data + $this->userDataTemplate;
        $this->session->userData = $this->userData;

        return $this;
    }

    /**
     * Clear user data
     *
     * @return void
     */
    protected function clearUserData()
    {
        $this->userData = $this->userDataTemplate;
        $this->session->sess_destroy();
    }

    /**
     * Get layout data
     *
     * @return array
     */
    protected function getLayoutData()
    {
        $data = $this->data + [
            'user'=>$this->userData,
            'homePath'=>$this->homePath,
            'flash'=>array_key_exists(self::KEY_FLASH, $_SESSION)?$_SESSION[self::KEY_FLASH]:[],
            'userRoles'=>[
                self::USER_ADMIN,
                self::USER_MEMBER,
            ],
        ];

        return $data;
    }

    /**
     * Add flash message
     *
     * @param string $key
     * @param string $message
     */
    protected function addFlash($key, $message)
    {
        $parentKey = self::KEY_FLASH;
        if (!array_key_exists($parentKey, $_SESSION)) {
            $_SESSION[$parentKey] = [];
            $this->session->mark_as_flash($parentKey);
        }

        if (!array_key_exists($key, $_SESSION[$parentKey])) {
            $_SESSION[$parentKey][$key] = [];
        }

        array_push($_SESSION[$parentKey][$key], $message);

        return $this;
    }

    /**
     * Dashboard menu collection
     *
     * @return array
     */
    protected function getDashboardMenu()
    {
        $menu = [
            self::USER_ADMIN=>[
                'admin'=>[
                    'label'=>'Dashboard',
                    'icon'=>'dashboard',
                ],
                'admin/data/user'=>[
                    'label'=>'User',
                    'icon'=>'user-circle',
                ],
                '#laporan'=>[
                    'label'=>'Laporan',
                    'icon'=>'files-o',
                    'items'=>[
                        'admin/laporan/user'=>[
                            'label'=>'User',
                        ],
                    ],
                ],
                'admin/pengaturan'=>[
                    'label'=>'Pengaturan',
                    'icon'=>'cogs',
                ],
            ],
        ];

        foreach ($menu as $role => $menuItems) {
            if ($this->hasRoles($role)) {
                return $menuItems;
            }
        }

        return [];
    }
}
