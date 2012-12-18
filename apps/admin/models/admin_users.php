<?php
class AdminUser extends Object {
    /**
     * keep track of whether this user is authed (logged in)
     * or not
     */
    protected $isAuthed = false;

    protected $sessionId = "admin_user_id";

    /**
     * bung this user's ID in the session
     */
    public function addToSession() {
        $s = Session::getInstance();
        $key = $this->sessionId;
        $s->$key = $this->getId();
        if ($s->$key === null) {
            Log::warn("Adding null user ID to session");
        }
        $this->setAuthed(true);
    }

    /**
     * remove this user from the session
     * it's valid for a guest to have a logout method
     * as we explicitly log them out when we upgrade them
     * to a full user account
     */
    public function logout() {
        $s = Session::getInstance();
        $key = $this->sessionId;
        unset($s->$key);
        $this->setAuthed(false);
    }

    public function isAuthed() {
        return $this->isAuthed;
    }

    /**
     * update this user's authed state
     */
    public function setAuthed($authed) {
        $this->isAuthed = $authed;
    }
}

class AdminUsers extends Table {
    protected $meta = array(
        'columns' => array(
            'email' => array(
                'type' => 'email',
            ),
            'password' => array(
                'type' => 'password',
            ),
        ),
    );

    public function loadFromSession() {
        $s = Session::getInstance();
        $id = $s->admin_user_id;
        if ($id === NULL) {
            return new AdminUser();
        }
        $user = $this->read($id);
        if (!$user) {
            // oh dear
            Log::debug("Could not find admin id [".$id."]");
            return new AdminUser();
        }
        $user->setAuthed(true);
        return $user;
    }
}
