<?php
require_once('../../helpers/database.php');

class ModelHandler
{
    protected $id = null;
    protected $name = null;
    protected $brand = null;

    // TODO SCRUD methods

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
}
