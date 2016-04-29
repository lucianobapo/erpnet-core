<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 23/04/16
 * Time: 15:46
 */

namespace ErpNET\App\Models\Doctrine\Entities;

use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

class EntityBase
{
    use Timestamps;
    use SoftDeletes;

    public function __get($name)
    {
        if(property_exists($this, $name)){
            return $this->$name;
        } elseif(property_exists($this, camel_case($name))){
            $name = camel_case($name);
            return $this->$name;
        } else var_dump('Propety fail: '.$name);
    }

}