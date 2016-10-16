<?php

/**
 * Modulo del modelo del formulario de inicio de sesión.
 * Gestiona el inicio de sesión.
 */

namespace SoftnCMS\models;

use SoftnCMS\models\admin\User;

/**
 * Clase que gestiona el inicio de sesión.
 *
 * @author Nicolás Marulanda P.
 */
class Login {

    /** @var string Nombre de usuario. */
    private $username;

    /** @var string Contraseña. */
    private $password;

    /** @var bool Recordar sesión. */
    private $userRememberMe;

    /**
     * Constructor.
     * @param string $username Nombre de usuario.
     * @param string $password Contraseña.
     * @param bool $userRememberMe Recordar sesión.
     */
    public function __construct($username, $password, $userRememberMe) {
        $this->username = $username;
        $this->password = User::encrypt($password);
        $this->userRememberMe = $userRememberMe;
    }

    /**
     * Metodo que comprueba si ha iniciado sesión.
     * @return bool Si es FALSE, el usuario no tiene un sesión activa 
     * ni tiene la opción de recordar sesión
     */
    public static function isLogin() {
        if (!isset($_SESSION[SESSION_USER]) && !isset($_COOKIE[COOKIE_USER_REMEMBER])) {
            return \FALSE;
        }

        if (!isset($_SESSION[SESSION_USER]) && isset($_COOKIE[COOKIE_USER_REMEMBER])) {
            $_SESSION[SESSION_USER] = $_COOKIE[COOKIE_USER_REMEMBER];
        }

        return self::checkSession();
    }

    /**
     * Metodo que realiza el proceso de inicio de sesión.
     * @global string $urlSite
     * @return bool Retorna FALSE en caso de error.
     */
    public function login() {
        $user = User::selectByLogin($this->username);

        //Se comprueba si el nombre de usuario existe y si su contraseña es correcta.
        if ($user !== \FALSE && $user->getUserPass() == $this->password) {
            $_SESSION[SESSION_USER] = $user->getID();

            if ($this->userRememberMe) {
                setcookie(COOKIE_USER_REMEMBER, $user->getID(), \COOKIE_EXPIRE);
            }

            return \TRUE;
        }

        return \FALSE;
    }

    /**
     * Metodo que comprueba si el valor de la variable de sesión corresponde 
     * a un usuario valido.
     * @return bool
     */
    public static function checkSession() {
        $user = User::selectByID(self::getSession());

        if ($user === \FALSE) {
            unset($_SESSION[SESSION_USER]);

            return \FALSE;
        }

        return \TRUE;
    }

    public static function getSession() {
        return isset($_SESSION[SESSION_USER]) ? $_SESSION[SESSION_USER] : 0;
    }

}
