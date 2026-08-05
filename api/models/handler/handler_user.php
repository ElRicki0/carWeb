<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class UserHandler
{
    // declaraciones de variables
    protected $id = null;
    protected $username = null;
    protected $email = null;
    protected $picture = null;
    protected $phone = null;
    protected $name = null;
    protected $middlename = null;
    protected $lastname = null;
    protected $password = null;
    protected $status = null;
    
    // Constante para establecer la ruta de las imágenes.
    const PICTURE_PATH = '../../images/public/';

    // método para comprobar la existencia de un administrador 
    public function checkUser($username, $password)
    {
        $sql = 'SELECT
                    `id_user`,
                    `username_user`,
                    `password_user`
                FROM
                    `tb_users`
                WHERE
                    `username_user` = ?';
        $params = array($username);
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } elseif (password_verify($password, $data['password_user'])) {
            $_SESSION['idUser'] = $data['id_user'];
            $_SESSION['usernameUser'] = $data['username_user'];
            return true;
        } else {
            return false;
        }
    }

    // todo métodos para alteraciones de registros SCRUD (SEARCH, CREATE, READ, UPDATE, DELETE)

    // ? métodos para la creación de usuario corriente
    public function createRow()
    {
        $sql = 'INSERT INTO `tb_users`(
                    `username_user`,
                    `email_user`,
                    `picture_user`,
                    `phone_user`,
                    `name_user`,
                    `middlename_user`,
                    `lastname_user`,
                    `password_user`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )';
        $params = array($this->username,  $this->email, $this->picture, $this->phone, $this->name, $this->middlename, $this->lastname, $this->password);
        return Database::executeRow($sql, $params);
    }
}
