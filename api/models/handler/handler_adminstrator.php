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
    protected $email = null;
    protected $picture = null;
    protected $phone = null;
    protected $username = null;
    protected $password = null;
    protected $status = null;
    protected $created = null;
    protected $edited = null;
    // protected $phone = null;

    // Constante para establecer la ruta de las imágenes.
    const PICTURE_PATH = '../../images/admin/';

    // método para comprobar la existencia de un administrador 
    public function checkUser($username, $password)
    {
        $sql = 'SELECT
                    `id_administrator`,
                    `username_administrator`,
                    `password_administrator`
                FROM
                    `tb_administrator`
                WHERE
                    `username_administrator` = ?';
        $params = array($username);
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } elseif (password_verify($password, $data['password_administrator'])) {
            $_SESSION['idAdministrator'] = $data['id_administrator'];
            $_SESSION['usernameAdministrator'] = $data['username_administrator'];
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
                    `email_administrator`,
                    `phone_administrator`,
                    `username_administrator`,
                    `password_administrator`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )';
        $params = array($this->name,  $this->email, $this->phone, $this->username, $this->password);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT
                    `id_administrator` as `idk`
                FROM
                    `tb_administrator`';
        return Database::getRows($sql);
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
