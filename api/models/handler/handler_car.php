<?php
require_once('../../helpers/database.php');

class CarHandler
{

    protected $id = null;
    protected $model = null;
    protected $year = null;
    protected $color = null;
    protected $status = null;
    protected $brand = null;
    protected $created_at = null;
    protected $edited_at = null;
    protected $picture = null;

    const PICTURE_PATH = '../../images/car/';

    // todo SCRUD method (search, create, read, update, delete)

    public function createRow()
    {
        $sql = 'INSERT INTO `tb_cars`(
                    `model_car`,
                    `year_car`,
                    `color_car`,
                    `status_car`,
                    `id_brand`,
                    `picture_car`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?)';
        $params = array($this->model, $this->year, $this->color, $this->status, $this->brand, $this->picture);
        return DATABASE::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT
            `id_car`,
            `model_car`,
            `year_car`,
            `color_car`,
            `status_car`,
            br.id_brand,
            br.name_brand,
            br.picture_brand,
            `picture_car`,
            `created_at_car`,
            `modified_at_car`
        FROM
            `tb_cars` cs
        LEFT JOIN tb_brands br ON
            cs.id_brand = br.id_brand';
        return DATABASE::getRows($sql);
    }

    public function readFileName()
    {
        $sql = 'SELECT
                    `picture_car`
                FROM
                    `tb_cars`
                WHERE
                    `id_car`=?';
        $param = array($this->id);
        return DATABASE::getRow($sql, $param);
    }

}