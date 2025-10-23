<?php
require_once('../../helpers/validator.php');
require_once('../../models/handler/handler_car.php');

class CarData extends CarHandler
{
    // atributo genérico para manejo de errores
    private $data_error = null;
    private $filename = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'The car ID is incorrect';
            return false;
        }
    }

    // ? se valida el nombre como tipo alfabético
    public function setModel($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'The model name must be an alphabetical value';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->model = $value;
            return true;
        } else {
            $this->data_error = 'The model name length must be between ' . $min . ' and ' . $max;
            return false;
        }
    }

    public function setYear($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->year = $value;
            return true;
        } else {
            $this->data_error = 'The car year is incorrect';
            return false;
        }
    }

    public function setColor($value, $min = 3, $max = 10)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'The color name must be an alphanumeric value';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->color = $value;
            return true;
        } else {
            $this->data_error = 'The color name must be between ' . $min . ' and ' . $max;
            return false;
        }
    }

    public function setStatus($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->status = $value;
            return true;
        } else {
            $this->data_error = 'Car status is invalid';
            return false;
        }
    }

    public function setBrand($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->brand = $value;
            return true;
        } else {
            $this->data_error = 'The id Brand is incorrect';
            return false;
        }
    }

    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['picture_car'];
            return true;
        } else {
            $this->data_error = 'Car picture not found';
            return false;
        }
    }

    // Método para obtener el error de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }
    public function getFilename()
    {
        return $this->filename;
    }
}