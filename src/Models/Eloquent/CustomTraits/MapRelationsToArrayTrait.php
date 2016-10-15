<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 15/10/16
 * Time: 02:42
 */

namespace ErpNET\App\Models\Eloquent\CustomTraits;


trait MapRelationsToArrayTrait
{
    public function mapToArray($entity, $field, $subField, $interField = null)
    {
        $result = [];

        if (!is_null($entity) && isset($entity[$field]) && count($entity[$field])>0){
            foreach ($entity[$field] as $item) {
                if ($item instanceof \Illuminate\Database\Eloquent\Model)
                    array_push($result, $item[$subField]);
                else
                    array_push($result, $item[$interField][$subField]);
            }
        }

        return $result;
    }
}