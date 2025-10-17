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
                    `picture_brand`,
                    `id_category1`,
                    `id_category2`,
                    `id_category3`
                FROM
                    `tb_brands`
                WHERE
                    `name_brand` LIKE ? OR
                    `description_brand` LIKE ? OR
                    `status_brand` LIKE ?';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow1()
    {
        $sql = 'INSERT INTO `tb_brands`(
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`,
                    `id_category1`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?)';
        $params = array($this->name, $this->description, $this->status, $this->picture, $this->category1);
        return Database::executeRow($sql, $params);
    }

    public function createRow2()
    {
        $sql = 'INSERT INTO `tb_brands`(
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`,
                    `id_category1`,
                    `id_category2`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?)';
        $params = array($this->name, $this->description, $this->status, $this->picture, $this->category1, $this->category2);
        return Database::executeRow($sql, $params);
    }

    public function createRow3()
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

    public function readAll()
    {
        $sql = 'SELECT
                    `id_brand`,
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`,
                    ct1.name_category as category1,
                    ct2.name_category as category2,
                    ct3.name_category as category3
                FROM
                    `tb_brands` bds
                    LEFT JOIN tb_categories ct1 on ct1.id_category = bds.id_category1
                    LEFT JOIN tb_categories ct2 on ct2.id_category = bds.id_category2    
                    LEFT JOIN tb_categories ct3 on ct3.id_category = bds.id_category3';
        return DATABASE::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT
                    `id_brand`,
                    `name_brand`,
                    `description_brand`,
                    `status_brand`,
                    `picture_brand`,
                    ct1.name_category as category1,
                    ct2.name_category as category2,
                    ct3.name_category as category3,
                    bds.id_category1,
                    bds.id_category2,
                    bds.id_category3
                FROM
                    `tb_brands` bds
                    LEFT JOIN tb_categories ct1 on ct1.id_category = bds.id_category1
                    LEFT JOIN tb_categories ct2 on ct2.id_category = bds.id_category2    
                    LEFT JOIN tb_categories ct3 on ct3.id_category = bds.id_category3
                WHERE id_brand = ?';
        $params = array($this->id);
        return DATABASE::getRow($sql, $params);
    }

    public function updateRow3()
    {
        $sql = 'UPDATE
                    `tb_brands`
                SET
                    `name_brand` = ?,
                    `description_brand` = ?,
                    `status_brand` = ?,
                    `picture_brand` = ?,
                    `id_category1` = ?,
                    `id_category2` = ?,
                    `id_category3` = ?
                WHERE
                    `id_brand` = ?';
        $params = array($this->name, $this->description, $this->status, $this->picture, $this->category1, $this->category2, $this->category3, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM `tb_brands` WHERE `id_brand` = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}