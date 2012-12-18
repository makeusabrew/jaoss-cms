<?php
class AbstractAdminController extends Controller {
    protected $adminUser = null;

    public function init() {
        $this->adminUser = Table::factory('AdminUsers')->loadFromSession();
        $this->assign('adminUser', $this->adminUser);
        switch ($this->path->getAction()) {
            case "login":
                if ($this->adminUser->isAuthed()) {
                    throw new InitException($this->redirect(array(
                        "controller" => "Admin",
                        "action"     => "index",
                    )), "Already Authed");
                }
                break;
            default:
                if ($this->adminUser->isAuthed() == false) {
                    throw new InitException($this->redirect(array(
                        "controller" => "Admin",
                        "action"     => "login",
                    )), "Not Authed");
                }
                break;
        }
    }

    protected function filterNamespace($namespace, $keys = array()) {
        $data = $this->request->getVar($namespace);
        $final = array();
        foreach ($keys as $key) {
            $final[$key] = isset($data[$key]) ? $data[$key] : null;
        }
        return $final;
    }
}
