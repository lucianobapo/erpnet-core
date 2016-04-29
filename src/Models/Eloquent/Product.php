<?php
namespace ErpNET\App\Models\Eloquent;

use ErpNET\App\Models\Eloquent\CustomTraits\GridSortingTrait;
use ErpNET\App\Models\Eloquent\CustomTraits\ProductRelationsTrait;
//use ErpNET\App\Models\Eloquent\CustomTraits\SyncItemsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ErpNET\App\Models\Eloquent\CustomTraits\MandanteTrait;
use Illuminate\Support\Facades\Auth;

class Product extends Model {

    use SoftDeletes;
    use MandanteTrait;
    use GridSortingTrait;
//    use SyncItemsTrait;
    use ProductRelationsTrait;

    /**
     * Fillable fields for a Product.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
//        'cost_id',
        'nome',
        'icone',
        'imagem',
//        'cod_fiscal',
//        'cod_barra',
        'promocao',
        'estoque',
//        'estoque_minimo',
        'valorUnitVenda',
//        'valorUnitVendaPromocao',
//        'valorUnitCompra',
    ];

    /**
     * @var String
     */
//    private $filtro;

//    public function toArray()
//    {
////        $array = parent::toArray();
////        $array['categoria_list'] = $this->categoria_list;
////        return $array;
//    }



    public function groupsWhere() {
//        return $this->belongsToMany('ErpNET\App\Models\ProductGroup')
//            ->wherePivot('grupo', '');
    }

    public function getGroupListAttribute(){
//        $groups = $this->groups->toArray();
//        $lista = '';
//        foreach($groups as $group){
//            $lista = $lista . $group['grupo'].', ';
//        }
//        return substr($lista, 0, -2);
    }

    public function getCategoriaListAttribute(){
//        $groups = $this->groups->toArray();
//        $lista = '';
//        foreach($groups as $group){
////            dd(strpos($group['grupo'],'Categoria:'));
//            if (strpos($group['grupo'],'Categoria:')!==false)
//            $lista = $lista . substr($group['grupo'],11).', ';
//        }
//        return $lista == ''?'Outros':substr($lista, 0, -2);
    }

    public function filtraGroup($filtro) {
//        $this->filtro=$filtro;
//        return $this->all()->filter(function($item) {
//            $found = false;
//            foreach ($item->groups->toArray() as $group) {
//                if (array_search($this->filtro,$group)) $found = true;
//            }
//            if ($found) return $item;
//        });
    }

    public function filtraStatus($filtro) {
//        $this->filtro=$filtro;
//        return $this->all()->filter(function($item) {
//            $found = false;
//            foreach ($item->status->toArray() as $group) {
//                if (array_search($this->filtro,$group)) $found = true;
//            }
//            if ($found) return $item;
//        });
    }

    public function statusWhere() {
//        return $this->belongsToMany('ErpNET\App\Models\SharedStat');
//            ->getQuery();
//            ->belongsToMany('ErpNET\App\Models\SharedStat')
//            ->wherePivot('status', 'ativado');
    }

    public function getStatusListAttribute(){
//        $status = $this->status->toArray();
//        $lista = '';
//        foreach($status as $stat){
//            $lista = $lista . $stat['descricao'].', ';
//        }
//        return substr($lista, 0, -2);
    }

    public function checkStatus(array $lista, $status){
//        foreach($lista as $item) if ($item['status']==$status) return true;
//        return false;
    }

    public function checkGroup(array $lista, $group){
//        foreach($lista as $item) if ($item['grupo']==$group) return true;
//        return false;
    }

    public function getProductListAttribute(){
//        return $this->with('status')
//            ->orderBy('nome', 'asc')
//            ->get()
//            ->filter(function($item) {
//                if ( (strpos($item->status_list,'Ativado')!==false) || (Auth::user()->role->name==config('delivery.rootRole')) )
//                    return $item;
//            });
    }
    public function getProductSelectListAttribute(){
//        return [''=>''] + $this->product_list
//            ->lists('nome','id')
//            ->toArray();
    }

}
