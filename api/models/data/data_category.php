<?php
// clase para validación de datos
require_once("../../helpers/validator.php");
// clase padre
require_once("../../models/handler/handler_category.php");

class CategoriesData extends CategoriesHandler
{
    // atributo genérico para manejo de errores
    private $data_error = null;
    private $filename = null;

    /*
     *  Métodos para validar y asignar valores de los atributos.
     */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'The administrator ID is incorrect';
            return false;
        }
    }

    // ? se valida el nombre como tipo alfabético
    public function setName($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'The category name must be an alphabetical value';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->name = $value;
            return true;
        } else {
            $this->data_error = 'The name length must be between ' . $min . ' and ' . $max;
            return false;
        }
    }

    public function setDescription($value, $min = 2, $max = 200)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'The category description must be an alphabetical value';
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->description = $value;
            return true;
        } else {
            $this->data_error = 'The description length must be between ' . $min . ' and ' . $max;
            return false;
        }
    }

    public function setType($value, $min =4, $max =50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'The type category must be an alphabetical value';
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->type = $value;
            return true;
        } else {
            $this->data_error = 'The type category length must be between ' . $min . ' and ' . $max;
            return false;
        }
    }

    // se valida el estado de el administrador
    public function setStatus($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->status = $value;
            return true;
        } else {
            $this->data_error = 'Category status is invalid';
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
        } elseif ($filename) {
            $this->picture = $filename;
            return true;
        } else {
            $this->picture = '404Category.png';
            return true;
        }
    }


    // ? se obtiene el tipo de archivo en la base de datos
    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['picture_category'];
            return true;
        } else {
            $this->data_error = 'Category picture not found';
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