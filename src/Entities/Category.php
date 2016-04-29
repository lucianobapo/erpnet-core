<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 22/04/16
 * Time: 18:22
 */

namespace ErpNET\App\Entities;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'code_categories';
    protected $fillable = [
        'name',
        'active',
        'parent_id',
    ];
}