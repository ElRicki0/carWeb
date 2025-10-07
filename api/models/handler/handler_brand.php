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
    protected $category1 = null;
    protected $category2 = null;
    protected $category3 = null;
    protected $status = null;
    protected $picture = null;

    const PICTURE_PATH = '../../images/brand';

    // todo SCRUD method (search, create, read, update, delete)

    public function createRow()
    {
        $sql = 'INSERT INTO `tb_brands`(
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`,
                    `id_category1`,
                    `id_category2`,
                    `id_category3`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?)';
        $params = array($this->name, $this->description, $this->status, $this->picture, $this->category1, $this->category2, $this->category3);
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
}