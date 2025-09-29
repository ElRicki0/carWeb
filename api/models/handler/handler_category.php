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
}
