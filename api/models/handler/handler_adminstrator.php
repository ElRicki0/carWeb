<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class AdministratorHandler
{
    // declaraciones de variables
    protected $id = null;
    protected $name = null;
    protected $username = null;
    protected $password = null;
    protected $email = null;
    protected $picture = null;
    // protected $phone = null;

    // Constante para establecer la ruta de las imágenes.
    const PICTURE_PATH = '../../images/admin/';

    // método para comprobar la existencia de un administrador 
    public function checkUser($username, $password)
    {
        $sql = 'SELECT `id_administrator`, `username_administrator`, `password_administrator` 
                FROM `tb_administrator` WHERE `user_name` = ?';
        $params = array($username);
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } elseif (password_verify($password, $data['password_administrator'])) {
            $_SESSION['idAdministrator'] = $data['id_administrator'];
            $_SESSION['aliasAdministrador'] = $data['alias_administrador'];
            return true;
        } else {
            return false;
        }
    }

    // todo métodos para alteraciones de registros SCRUD (SEARCH, CREATE, READ, UPDATE, DELETE)

    // ? métodos para la creación del primer administrador
    public function createRow()
    {
        $sql = 'INSERT INTO `tb_administrator`(
                    `name_administrator`,
                    `username_administrator`,
                    `password_administrator`,
                    `picture_administrator`,
                    `email_administrator`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )';
        $params = array($this->name, $this->username, $this->password, $this->picture, $this->email);
        return Database::executeRow($sql, $params);
    }

    // Cambia la contraseña del administrador actual y actualiza la fecha y el código.
    public function readFilename()
    {
        $sql = 'SELECT `picture_administrator` FROM `tb_administrator`
                WHERE  id_administrator = ?';
        $params = array($_SESSION['idAdministrator']);
        return Database::getRow($sql, $params);
    }
}
