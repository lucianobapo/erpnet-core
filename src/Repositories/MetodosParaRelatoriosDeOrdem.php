<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 05/01/16
 * Time: 14:20
 */

namespace App\Repositories;

use App\Models\RepositoryLayer\CostAllocateRepositoryInterface;
use App\Models\RepositoryLayer\OrderRepositoryInterface;
use Carbon\Carbon;
//use Symfony\Component\DomCrawler\Form;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class MetodosParaRelatoriosDeOrdem
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var CostAllocateRepositoryInterface
     */
    private $costAllocateRepository;

    /**
     * @var Carbon
     */
    private $carbon;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CostAllocateRepositoryInterface $costAllocateRepository,
        Carbon $carbon)
    {
        $this->orderRepository = $orderRepository;
        $this->costAllocateRepository = $costAllocateRepository;
        $this->carbon = $carbon;
    }

    private function arrayDosCustos($collection)
    {
        $result = [];
        foreach($collection as $cost){
            $result[$cost->nome]= $cost->numero . ' - ' . $cost->descricao;
        }
        return $result;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|\Doctrine\Common\Collections\ArrayCollection $Orders
     * @return array
     */
    private function arrayDeSomaDosItens($Orders)
    {
        $sum2 = [];
        foreach ($Orders as $order) {
            foreach ($order->itemOrders as $orderItem) {
                isset($sum2[$orderItem->costAllocate->nome][$order->type_id])?
                    $sum2[$orderItem->costAllocate->nome][$order->type_id] = ($orderItem->valor_unitario*$orderItem->quantidade)+
                        $sum2[$orderItem->costAllocate->nome][$order->type_id]:
                    $sum2[$orderItem->costAllocate->nome][$order->type_id] = ($orderItem->valor_unitario*$orderItem->quantidade);//
            }
        }
        return $sum2;
    }

    private function geraMatrizDeValores(array $valores=[], array $titulos=[])
    {
        $somaMatriz = [];
        foreach ($titulos as $nome => $descricao) {
            $matriz[$nome]['nomes'] = $descricao;
        }
        foreach ($valores as $nomeDoCusto => $arrayDeOrdensEValores) {
            foreach ($arrayDeOrdensEValores as $keyTipoOrdem => $valor) {
                $matriz[$nomeDoCusto][$keyTipoOrdem] = $valor;
                $somaMatriz[$keyTipoOrdem] =  (isset($somaMatriz[$keyTipoOrdem]))?$somaMatriz[$keyTipoOrdem]+$valor:$valor;
            }
        }
        return ([
            'matriz'=>$matriz,
            'somaMatriz'=>$somaMatriz,
        ]);
    }

    /**
     * @param $arr
     * @return mixed
     */
    private function preparaArrayNavegacao($arr)
    {
        $antes = 0;
        foreach ($arr as $key => $value) {
            $arr[$key]['id'] = $key;
            if ($antes == 0) $antes = $key;
            else {
                $arr[$antes]['depois'] = $key;
                $arr[$key]['antes'] = $antes;
                $antes = $key;
            }
        }

        reset($arr);
        return $arr;
    }

    /**
     * @return array
     */
    private function separaOrdensPorPeriodo()
    {
        $countMes = 0;
        $arr = [];
        do {
            // Periodo mensal
            $comecoDoMes = $this->carbon->now()->subMonths($countMes)->firstOfMonth();
            $fimDoMes = $this->carbon->now()->subMonths($countMes)->endOfMonth();

            $OrdersFiltred = $this
                ->orderRepository
                ->collectionOrdersItemsCosts()
                ->filter(function ($item) use ($comecoDoMes, $fimDoMes) {
                    if ($item->posted_at >= $comecoDoMes && $item->posted_at <= $fimDoMes) {
                        return $item;
                    }
                });

            if (count($OrdersFiltred) > 0) {
                $arr[$comecoDoMes->timestamp] = array_merge(
                    ['titulo' => $comecoDoMes->format('F Y')],
                    $this->geraMatrizDeValores(
                        $this->arrayDeSomaDosItens($OrdersFiltred),
                        $this->arrayDosCustos($this->costAllocateRepository->collectionCostAllocate())
                    ));
            }
            $countMes++;
        } while ((count($OrdersFiltred) > 0) || ($countMes < 3));
        return $arr;
    }

    public function arrayDosPeriodos()
    {
        $arr = $this->separaOrdensPorPeriodo();

//        dd($arr);
        $result = $this->preparaArrayNavegacao($arr);

//        dd($result);

        $fractal = new Manager();
        $resource = new Collection([$result], function(array $item) {
//            dd($item);
            return $item;
        });
//        dd($resource);
//        dd($fractal->createData($resource)->toJson());
        return $fractal->createData($resource)->toJson();
    }
}