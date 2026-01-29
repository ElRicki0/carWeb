<?php
require_once('../../helpers/database.php');

class ModelHandler
{
    protected $id = null;
    protected $name = null;
    protected $brand = null;

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
        $sql = 'INSERT INTO `tb_models`(`name_model`, `id_brand`)
                VALUES(?, ?)';
        $params = array($this->name, $this->brand);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT
                    `id_model`,
                    `name_model`,
                    mds.id_brand,
                    brs.name_brand,
                    brs.picture_brand
                FROM
                    `tb_models` mds
                INNER JOIN tb_brands brs ON
                    mds.id_brand = brs.id_brand';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT
                    `id_model`,
                    `name_model`,
                    mds.id_brand,
                    brs.name_brand,
                    brs.picture_brand
                FROM
                    `tb_models` mds
                INNER JOIN tb_brands brs ON
                    mds.id_brand = brs.id_brand
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
                    `id_brand` = ?
                WHERE
                    `id_model` =?';
        $params = array($this->name, $this->brand, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM `tb_models` WHERE `id_model` =?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
