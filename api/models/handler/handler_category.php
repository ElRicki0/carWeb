<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla categorías.
 */
class CategoriesHandler
{
    protected $id = null;
    protected $name = null;
    protected $description = null;
    protected $type = null;
    protected $status = null;
    protected $picture = null;

    // Constante para establecer la ruta de las imágenes.
    const PICTURE_PATH = '../../images/category/';

    // todo SCRUD methods (search, create, read, update, delete)

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT
                    `id_category`,
                    `name_category`,
                    `description_category`,
                    `usage_type_category`,
                    `status_category`,
                    `picture_category`
                FROM
                    `tb_categories`
                WHERE
                    `name_category` LIKE ? OR
                    `description_category` LIKE ? OR
                    `usage_type_category` LIKE ?';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO `tb_categories`(
                    `name_category`,
                    `description_category`,
                    `usage_type_category`,
                    `status_category`,
                    `picture_category`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?)';
        $params = array($this->name, $this->description, $this->type, $this->status, $this->picture);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT
                    `id_category`,
                    `name_category`,
                    `description_category`,
                    `usage_type_category`,
                    `status_category`,
                    `picture_category`
                FROM
                    `tb_categories`';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT
                    `id_category`,
                    `name_category`,
                    `description_category`,
                    `usage_type_category`,
                    `status_category`,
                    `picture_category`
                FROM
                    `tb_categories`
                WHERE `id_category` = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE
                    `tb_categories`
                SET
                    `name_category` = ?,
                    `description_category` = ?,
                    `usage_type_category` = ?,
                    `status_category` = ?,
                    `picture_category` = ?
                WHERE
                    `id_category`= ?';
        $params = array($this->name, $this->description, $this->type, $this->status, $this->picture, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE
                FROM
                    `tb_categories`
                WHERE
                    `id_category` =?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT
                    `picture_category`
                FROM
                    `tb_categories`
                WHERE
                    `id_category` = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    // ? Other cases
    public function changeStatus(){
        $sql = 'UPDATE
                `tb_categories`
                SET
                    `status_category` = IF(`status_category` = 1, 0, 1)
                WHERE
                    `id_category` = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
