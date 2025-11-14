<?php
require_once('../../helpers/database.php');

class ModelHandler
{
    protected $id = null;
    protected $name = null;
    protected $brand = null;

    // TODO SCRUD methods

    public function readAll()
    {
        $sql = 'SELECT
                    `id_model`,
                    `name_model`,
                    `id_brand`
                FROM
                    `tb_models`';
        return Database::getRows($sql);
    }

}