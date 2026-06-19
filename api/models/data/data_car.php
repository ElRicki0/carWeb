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
    public function setModel($value)
    {
        if (!Validator::validateNaturalNumber($value)) {
            $this->data_error = 'The model ID is incorrect';
            return false;
        } else {
            $this->model = $value;
            return true;
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

    // ? se valida el archivo de imagen que pese menos de 2 megas y que sea formato .jpg o .png
    public function setPicture($file, $filename = null)
    {
        if (Validator::validateImageFile($file)) {
            $this->picture = Validator::getFileName();
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif (is_array($filename) && isset($filename['picture_car'])) {
            $this->picture = $filename['picture_car'];
            return true;
        } elseif ($filename) {
            $this->picture = $filename;
            return true;
        } else {
            $this->picture = '404Picture.png';
            return true;
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
