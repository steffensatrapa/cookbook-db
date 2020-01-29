<?php

class CrLoginService {

    public static function login($userName, $password) {
        $user = CrUser::loadFromDatabaseByUserName($userName);

        if ($user) {
            if ($user->isValidPassword($password)) {
                $_SESSION['loggedInUser'] = $user;
                return true;
            }
        } else {
            return false;
        }
    }

    public static function logout() {
        $_SESSION['loggedInUser'] = "";
    }

    /**
     * 
     * @return CrUser
     */
    public static function getLoggedInUser() {
        if ($_SESSION['loggedInUser']) {
            $user = $_SESSION['loggedInUser'];

            if ($user) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 
     * @param CrUser $createdBy
     */
    public static function isAllowedToEdit($createdBy) {
        $user = CrLoginService::getLoggedInUser();
        if ($user) {
            // logged in
            if ($user->getUserName() != $createdBy->getUserName()) {
                // foreign user
                return $user->getCanEditForeign();
            } else {
                return $user->getCanEdit();
            }
        } else {
            return false;
        }
    }

    /**
     * 
     * @param CrUser $createdBy
     */
    public static function isAllowedToDelete($createdBy) {
        $user = CrLoginService::getLoggedInUser();
        if ($user) {
            // logged in
            if ($user->getUserName() != $createdBy->getUserName()) {
                // foreign user
                return $user->getCanDeleteForeign();
            } else {
                return $user->getCanDelete();
            }
        } else {
            return false;
        }
    }

    public static function isAllowedToCreate() {
        $user = CrLoginService::getLoggedInUser();
        if ($user) {
            // logged in
            return $user->getCanCreate();
        } else {
            return false;
        }
    }

}
