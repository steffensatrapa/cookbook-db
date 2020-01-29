<?php

class CrUser {

    private $id = -1;
    private $userName;
    private $passwordHash;
    private $email;
    private $canCreate = true;
    private $canEdit = true;
    private $canEditForeign = false;
    private $canDelete = false;
    private $canDeleteForeign = false;
    private $notificateNew = false;
    private $notificateEdited = false;
    private $notificateDeleted = false;

    public function isValidPassword($password) {
        return password_verify($password, $this->passwordHash);
    }

    public function setPassword($password) {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCanCreate() {
        return $this->canCreate;
    }

    public function setCanCreate($canCreate) {
        $this->canCreate = $canCreate;
    }

    public function getCanEdit() {
        return $this->canEdit;
    }

    public function setCanEdit($canEdit) {
        $this->canEdit = $canEdit;
    }

    public function getCanEditForeign() {
        return $this->canEditForeign;
    }

    public function setCanEditForeign($canEditForeign) {
        $this->canEditForeign = $canEditForeign;
    }

    public function getCanDelete() {
        return $this->canDelete;
    }

    public function setCanDelete($canDelete) {
        $this->canDelete = $canDelete;
    }

    public function getCanDeleteForeign() {
        return $this->canDeleteForeign;
    }

    public function setCanDeleteForeign($canDeleteForeign) {
        $this->canDeleteForeign = $canDeleteForeign;
    }

    public function getNotificateNew() {
        return $this->notificateNew;
    }

    public function setNotificateNew($notificateNew) {
        $this->notificateNew = $notificateNew;
    }

    public function getNotificateEdited() {
        return $this->notificateEdited;
    }

    public function setNotificateEdited($notificateEdited) {
        $this->notificateEdited = $notificateEdited;
    }

    public function getNotificateDeleted() {
        return $this->notificateDeleted;
    }

    public function setNotificateDeleted($notificateDeleted) {
        $this->notificateDeleted = $notificateDeleted;
    }

    function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }

    function __construct1($userName) {
        $this->userName = $userName;
    }

    function __construct3($userName, $password, $email) {
        $this->userName = $userName;
        $this->setPassword($password);
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function toHtmlString() {
        return $this->userName;
    }

    function saveToDatabase() {
        $insertId = CrDatabase::query(
                        "INSERT INTO user 
                            (
                                userName,
                                passwordHash,
                                email,
                                canCreate,
                                canEdit,
                                canEditForeign,
                                canDelete,
                                canDeleteForeign,
                                notificateNew,
                                notificateEdited,
                                notificateDeleted
                            ) 
                        VALUES 
                            (
                                :userName,
                                :passwordHash,
                                :email,
                                :canCreate,
                                :canEdit,
                                :canEditForeign,
                                :canDelete,
                                :canDeleteForeign,
                                :notificateNew,
                                :notificateEdited,
                                :notificateDeleted
                            )
                        ON DUPLICATE KEY UPDATE  
                            passwordHash=:passwordHash,
                            email=:email,
                            canCreate=:canCreate,
                            canEdit=:canEdit,
                            canEditForeign=:canEditForeign,
                            canDelete=:canDelete,
                            canDeleteForeign=:canDeleteForeign,
                            notificateNew=:notificateNew,
                            notificateEdited=:notificateEdited,
                            notificateDeleted=:notificateDeleted"
                        , array(
                    ':userName' => $this->userName,
                    ':passwordHash' => $this->passwordHash,
                    ':email' => $this->email,
                    ':canCreate' => (int) $this->canCreate,
                    ':canEdit' => (int) $this->canEdit,
                    ':canEditForeign' => (int) $this->canEditForeign,
                    ':canDelete' => (int) $this->canDelete,
                    ':canDeleteForeign' => (int) $this->canDeleteForeign,
                    ':notificateNew' => (int) $this->notificateNew,
                    ':notificateEdited' => (int) $this->notificateEdited,
                    ':notificateDeleted' => (int) $this->notificateDelete)
        );

        if (is_int($insertId) && $insertId > 0) {
            $this->id = $insertId;
        }
    }

    private static function getObjectFromDatabaseResult($row) {
        if (array_key_exists('userName', $row) && array_key_exists('email', $row)) {

            $user = new CrUser();
            $user->id = $row['id'];
            $user->userName = $row['userName'];
            $user->passwordHash = $row['passwordHash'];
            $user->email = $row['email'];
            $user->canCreate = $row['canCreate'];
            $user->canEdit = $row['canEdit'];
            $user->canEditForeign = $row['canEditForeign'];
            $user->canDelete = $row['canDelete'];
            $user->canDeleteForeign = $row['canDeleteForeign'];
            $user->notificateNew = $row['notificateNew'];
            $user->notificateEdited = $row['notificateEdited'];
            $user->notificateDelete = $row['notificateDelete'];
            $user->createDate = $row['createDate'];
            return $user;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $userName
     * @return \CrUser
     */
    public static function loadOrCreateUser($userName) {
        $user = CrUser::loadFromDatabaseByUserName($userName);
        if (!$user) {
            $user = new CrUser($userName);
        }
        
        return $user;
    }

    /**
     * 
     * @param type $userName
     * @return \CrUser
     */
    public static function loadFromDatabaseByUserName($userName) {

        $rows = CrDatabase::queryFetch(
                        "SELECT * FROM user WHERE userName=:userName"
                        , array(
                    ':userName' => $userName)
        );


        if (count($rows) === 1) {
            return CrUser::getObjectFromDatabaseResult($rows[0]);
        } else {
            return false;
        }
    }

    public static function loadFromDatabaseById($id) {

        $rows = CrDatabase::queryFetch(
                        "SELECT * FROM user WHERE id=:id"
                        , array(
                    ':id' => $id)
        );

        if (count($rows) === 1) {
            return CrUser::getObjectFromDatabaseResult($rows[0]);
        } else {
            return false;
        }
    }

    public static function createDatabaseTable() {
        CrDatabase::query("CREATE TABLE IF NOT EXISTS user (
                                id                 INT NOT NULL AUTO_INCREMENT,
                                userName           VARCHAR(128) NOT NULL,
                                email              VARCHAR(128) NOT NULL,
                                passwordHash       VARCHAR(128) NOT NULL,
                                canCreate          BOOLEAN NOT NULL,
                                canEdit            BOOLEAN NOT NULL,
                                canEditForeign     BOOLEAN NOT NULL,
                                canDelete          BOOLEAN NOT NULL,
                                canDeleteForeign   BOOLEAN NOT NULL,
                                notificateNew      BOOLEAN NOT NULL,
                                notificateEdited   BOOLEAN NOT NULL,
                                notificateDeleted  BOOLEAN NOT NULL,
                                createDate         DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                                UNIQUE (userName),
                                FULLTEXT (userName, email),
                                PRIMARY KEY (id)
                            ) CHARACTER SET utf8 COLLATE utf8_unicode_ci");
    }

}
