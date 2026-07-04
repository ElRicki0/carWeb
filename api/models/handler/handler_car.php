<?php
require_once('../../helpers/database.php');

class CarHandler
{

    protected $id = null;
    protected $model = null;
    protected $year = null;
    protected $color = null;
    protected $status = null;
    protected $picture = null;

    const PICTURE_PATH = '../../images/car/';

    // todo SCRUD method (search, create, read, update, delete)

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT
                    `id_car`,
                    mds.name_model,
                    `year_car`,
                    `color_car`,
                    `status_car`,
                    `picture_car`,
                    brs.name_brand,
                    brs.picture_brand
                FROM
                    `tb_cars` cr
                INNER JOIN tb_models mds ON
                    cr.id_model = mds.id_model
                INNER JOIN tb_brands brs ON
                    mds.id_brand = brs.id_brand
                WHERE
                    mds.name_model LIKE ? OR
                    `year_car` LIKE ? OR
                    `name_brand` LIKE ?';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO `tb_cars`(
                    `id_model`,
                    `year_car`,
                    `color_car`,
                    `status_car`,
                    `picture_car`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )';
        $params = array($this->model, $this->year, $this->color, $this->status, $this->picture);
        return DATABASE::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT
                    `id_car`,
                    mds.name_model,
                    `year_car`,
                    `color_car`,
                    `status_car`,
                    `picture_car`,
                    brs.name_brand,
                    brs.picture_brand
                FROM
                    `tb_cars` cr
                INNER JOIN tb_models mds ON
                    cr.id_model = mds.id_model
                INNER JOIN tb_brands brs ON
                    mds.id_brand = brs.id_brand';
        return DATABASE::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT
                    cr.`id_car`,
                    cr.`id_model`,
                    mds.`id_brand`,
                    brs.`name_brand`,
                    mds.`name_model`,
                    cr.`year_car`,
                    cr.`color_car`,
                    cr.`status_car`,
                    cr.`picture_car`
                FROM
                    `tb_cars` cr
                INNER JOIN `tb_models` mds ON
                    cr.`id_model` = mds.`id_model`
                INNER JOIN `tb_brands` brs ON
                    mds.`id_brand` = brs.`id_brand`
                WHERE
                    cr.`id_car` = ?';
        $params = array($this->id);
        return DATABASE::getRow($sql, $params);
    }

    public function readFileName()
    {
        $sql = 'SELECT
                    `picture_car`
                FROM
                    `tb_cars`
                WHERE
                    `id_car`=?';
        $params = array($this->id);
        return DATABASE::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE
                    `tb_cars`
                SET
                        `id_model` = ?,
                        `year_car` = ?,
                        `color_car` = ?,
                        `status_car` = ?,
                        `picture_car` = ?
                WHERE
                    `id_car`=?';
        $params = array($this->model, $this->year, $this->color, $this->status, $this->picture, $this->id);
        return DATABASE::executeRow($sql, $params);
    }

    public function changeStatus()
    {
        $sql = 'UPDATE
                `tb_cars`
                SET
                    `status_car` = IF(`status_car` = 1, 0, 1)
                WHERE
                    `id_car` = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE
                FROM
                    `tb_cars`
                WHERE
                    `id_car` = ?';
        $param = array($this->id);
        return Database::executeRow($sql, $param);
    }
}
