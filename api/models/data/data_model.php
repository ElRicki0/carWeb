<?php
require_once('../../helpers/validator.php');
require_once('../../models/handler/handler_model.php');

class DataModel extends ModelHandler
{
    private $data_error = null;

    /*
     *  Métodos para validar y asignar valores de los atributos.
     */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'The car model ID is incorrect';
            return false;
        }
    }

    public function setName($value, $max = 50, $min = 3)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'The model name must be an aphanumeric value';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->name = $value;
            return true;
        } else {
            $this->data_error = 'The name length must be between ' . $min . ' and ' . $max;
            return false;
        }
    }

    public function setBrand($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->brand = $value;
            return true;
        } else {
            $this->data_error = 'The brand ID is incorrect';
            return false;
        }
    }

    public function setCategory($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->category = $value;
            return true;
        } else {
            $this->data_error = 'The category ID is incorrect';
            return false;
        }
    }

    // Método para obtener el error de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }
}
