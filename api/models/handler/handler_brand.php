<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class BrandHandler
{
    protected $id = null;
    protected $name = null;
    protected $description = null;
    protected $status = null;
    protected $picture = null;

    const PICTURE_PATH = '../../images/brand/';

    // todo SCRUD method (search, create, read, update, delete)

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT
                    `id_brand`,
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`
                FROM
                    `tb_brands`
                WHERE
                    `name_brand` LIKE ? OR
                    `description_brand` LIKE ? OR
                    `status_brand` LIKE ?';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO `tb_brands`(
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?)';
        $params = array($this->name, $this->description, $this->status, $this->picture);
        return Database::executeRow($sql, $params);
    }

    public function readFileName()
    {
        $sql = 'SELECT
                    `picture_brand`
                FROM
                    `tb_brands`
                WHERE
                    `id_description`= ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT
                    `id_brand`,
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`
                FROM
                    `tb_brands` bds';
        return DATABASE::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT
                    `id_brand`,
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`
                FROM
                    `tb_brands`
                WHERE id_brand = ?';
        $params = array($this->id);
        return DATABASE::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE
                    `tb_brands`
                SET
                    `name_brand` = ?,
                    `description_brand` = ?,
                    `status_brand` = ?,
                    `picture_brand` = ?
                WHERE
                    `id_brand` = ?';
        $params = array($this->name, $this->description, $this->status, $this->picture, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM `tb_brands` WHERE `id_brand` = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function changeStatus()
    {
        $sql = 'UPDATE
                `tb_brands`
                SET
                    `status_brand` = IF(`status_brand` = 1, 0, 1)
                WHERE
                    `id_brand` = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}