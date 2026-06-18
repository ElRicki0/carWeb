<?php
require_once('../../helpers/database.php');

class ModelHandler
{
    protected $id = null;
    protected $name = null;
    protected $brand = null;
    protected $category = null;

    // TODO SCRUD methods

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT
                    id_model,
                    name_model,
                    mds.id_brand,
                    brs.name_brand,
                    brs.picture_brand
                FROM
                    tb_models mds
                INNER JOIN tb_brands brs ON
                    mds.id_brand = brs.id_brand
                WHERE
                    brs.name_brand  LIKE ? OR
                    name_model  LIKE ?';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO `tb_models`(
                    `name_model`,
                    `id_brand`,
                    `id_category`
                )
                VALUES(
                    ?,
                    ?,
                    ?
                )';
        $params = array($this->name, $this->brand, $this->category);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT
                    `id_model`,
                    `name_model`,
                    mds.id_brand,
                    brs.name_brand,
                    brs.picture_brand,
                    ctg.id_category,
                    ctg.name_category
                FROM
                    `tb_models` mds
                INNER JOIN tb_brands brs ON
                    mds.id_brand = brs.id_brand
                INNER JOIN tb_categories ctg ON
                    mds.id_category = ctg.id_category';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT
                    `id_model`,
                    `name_model`,
                    mds.id_brand,
                    brs.name_brand,
                    brs.picture_brand,
                    ctg.id_category,
                    ctg.name_category
                FROM
                    `tb_models` mds
                INNER JOIN tb_brands brs ON
                    mds.id_brand = brs.id_brand
                INNER JOIN tb_categories ctg ON
                    mds.id_category = ctg.id_category
                WHERE id_model = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE
                    `tb_models`
                SET
                    `name_model` = ?,
                    `id_brand` = ?,
                    `id_category` = ?
                WHERE
                    `id_model` =?';
        $params = array($this->name, $this->brand, $this->category, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM `tb_models` WHERE `id_model` =?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
