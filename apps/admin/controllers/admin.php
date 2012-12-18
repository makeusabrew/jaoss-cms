<?php
require_once("apps/admin/controllers/abstract.php");
class AdminController extends AbstractAdminController {
    public function login() {
        $this->assign('columns', Table::factory('AdminUsers')->getColumns());
        if ($this->request->isPost()) {
            $user = Table::factory('AdminUsers')->login(
                $this->request->getVar('email'),
                $this->request->getVar('password')
            );
            if ($user) {
                $user->addToSession();
                //StatsD::increment("login.success");
                return $this->redirectAction("index", "Welcome ".$user->email);
            }
            // tut tut
            //StatsD::increment("login.failure");
            Log::warn("Invalid admin login attempt from IP [".$this->request->getIp()."] for email [".$this->request->getVar('email')."]");
            $this->addError('Invalid login details');
        }
    }

    public function logout() {
        $this->adminUser->logout();
        return $this->redirectAction("login");
    }

    public function index() {
    }
}
