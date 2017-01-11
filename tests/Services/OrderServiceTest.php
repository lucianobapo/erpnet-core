<?php
namespace ErpNET\Tests\Services;

use ErpNET\App\Interfaces\OrderServiceInterface;
use ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\CostAllocateRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface;
use ErpNET\App\Models\RepositoryLayer\OrderSharedStatRepositoryInterface;

class OrderServiceTest extends ServiceTestCase
{
    protected $testServiceClass = OrderServiceInterface::class;
//    protected $testClass = OrderServiceInterface::class;

    protected $mock = array (
        "mandante"=>"ilhanet",
        "pagamento"=>"vistad",
        "matches"=>[],
        "addresses"=>[],
        "address_id"=>false,
        "emailChanged"=>false,
        "cep"=>"28893280",
        "origem"=>"site",
        "showNameInput"=>true,
        "showDateInput"=>true,
        "showEmailInput"=>true,
        "showTelefoneInput"=>true,
        "showWhatsappInput"=>true,
        "nome"=>"teste",
        "telefone"=>"22999964314",
        "whatsapp"=>"22999964314",
        "endereco"=>"Avenida Brasil",
        "bairro"=>"Extensão do Bosque",
        "numero"=>"123",
        "complemento"=>"teste complemento",
        "observacao"=>"teste",
        "data_nascimento"=>null,
        "itens"=>
            array (
                0 =>
                    array (
                        'id' => '1',
                        'nome' => 'Água S/Gás 510ml',
                        'quantidade' => '1',
                        'valor' => '3',
                        '$$hashKey' => 'object:585',
                    ),
            ),
    );

    protected $mock3 = array (
        'mandante' => 'ilhanet',
        'pagamento' => 'vistad',
        'address_id' => '13',
        'emailChanged' => 'false',
        'cep' => '',
        'origem' => 'site',
        'showNameInput' => 'false',
        'showDateInput' => 'false',
        'showEmailInput' => 'false',
        'showTelefoneInput' => 'true',
        'showWhatsappInput' => 'false',
        'user_id' => '8',
        'partner_id' => '12',
        'showAddressList' => 'true',
        'observacao' => 'teste',
        'itens' =>
            array (
                0 =>
                    array (
                        'id' => '52',
                        'nome' => 'Água S/Gás 510ml',
                        'quantidade' => '1',
                        'valor' => '3',
                        '$$hashKey' => 'object:757',
                    ),
            ),
    );

    protected $mock2 = array (
        'pagamento' => 'debito',
        'address_id' => 'false',
        'emailChanged' => 'false',
        'cep' => '28893304',
        'origem' => 'site',
        'mandante' => 'ilhanet',
        'user_provider_id' => '17639880138174120',
        'name' => 'Luchiano Knaip',
        'picture' => 'http://graph.facebook.com/1763988013817412/picture?type=large',
        'userEmail' => 'luciano.pics2@gmail.com',
        'nome' => 'Luchiano Knaip',
        'data_nascimento' => '03/01/1987',
        'endereco' => 'Avenida Brasil',
        'bairro' => 'Extensão do Bosque',
        'numero' => '123',
        'itens' =>
            array (
                0 =>
                    array (
                        'id' => '1',
                        'nome' => 'Água S/Gás 510ml',
                        'quantidade' => '1',
                        'valor' => '3',
                        '$$hashKey' => 'object:585',
                    ),
            ),
    );

//    protected $mock = array (
//        'pagamento' => 'credito',
//        'address_id' => 'false',
//        'emailChanged' => 'false',
//        'cep' => '28893304',
//        'mandante' => 'ilhanet',
//        'user_provider_id' => '1375004702814068',
//        'picture' => 'http://graph.facebook.com/1375004702814068/picture?type=large',
//        'nome' => 'Audorgil Samoa',
//        'email' => 'ilhanet.lan@gmail.com',
//        'endereco' => 'Avenida Brasil',
//        'bairro' => 'Extensão do Bosque',
//        'numero' => '1',
//        'itens' =>
//            array (
//                0 =>
//                    array (
//                        'id' => '1',
//                        'nome' => 'Água S/Gás 510ml',
//                        'quantidade' => '1',
//                        'valor' => '3',
//                        '$$hashKey' => 'object:585',
//                    ),
//            ),
//    );

//    protected $mock = array (
//        'mandante' => 'teste',
//        'observacao' => 'obs',
//        'pagamento' => 'debito',
//        'address_id' => false,
//        'cep' => '28893280',
//        'itens' =>
//            array (
//                0 =>
//                    array (
//                        'id' => '1',
//                        'nome' => 'Água Com Gás Schin 500ml',
//                        'quantidade' => '2',
//                        'valor' => '4.00',
//                        '$$hashKey' => 'object:527',
//                    ),
//                1 =>
//                    array (
//                        'id' => '1',
//                        'nome' => 'Água Com Gás Schin 500ml',
//                        'quantidade' => '2',
//                        'valor' => '5.00',
//                        '$$hashKey' => 'object:527',
//                    ),
//            ),
//        'nome' => 'Angie',
//        'email' => 'angiemarianne@outlook.com',
//        'telefone' => '22-999999999',
//        'whatsapp' => '22-999999999',
//        'endereco' => 'Avenida Brasil',
//        'bairro' => 'Extensão do Bosque',
//        'numero' => '123',
//    );

    public function loadSignatures(){
        $this->testFieldsSignature = [
//            'mandante' => 'teste',
//            'nome' => 'produto 1',
//            'icone' => 'icon',
//            'imagem' => 'produto.jpg',
//            'promocao' => false,
//            'estoque' => false,
//            'valorUnitVenda' => 11,
        ];
    }

    public function testCreateOrderWithJsonIsJson(){
        //Create Product
        $repoProduct = $this->app->make(ProductRepositoryInterface::class);
        $recordProduct = $repoProduct->create([
            'nome' => 'produto 1',
            'icone' => 'icon',
            'imagem' => 'produto.jpg',
            'promocao' => false,
            'estoque' => false,
            'valorUnitVenda' => 11,
        ]);
        $productRecord = $repoProduct->findOneOrFail([
            'id' => $recordProduct->id,
        ]);
        $this->assertNotNull($productRecord);
        $instance = $repoProduct->model;
        if (!is_string($instance)) $instance = get_class($instance);
        $this->assertInstanceOf($instance, $productRecord);

        //Create CostAllocate
        $repoCostAllocate = $this->app->make(CostAllocateRepositoryInterface::class);
        $recordCostAllocate = $repoCostAllocate->create([
            'numero' => '01-01',
            'nome' => 'custo 1',
            'descricao' => 'desc 1',
        ]);
        $recordCostAllocate = $repoCostAllocate->findOneOrFail([
            'id' => $recordCostAllocate->id,
        ]);
        $this->assertNotNull($recordCostAllocate);
        $instance = $repoCostAllocate->model;
        if (!is_string($instance)) $instance = get_class($repoCostAllocate->model);
        $this->assertInstanceOf($instance, $recordCostAllocate);
        $repoProduct->addCostAllocateToProduct($recordCostAllocate, $productRecord);

        $orderJson = $this->service->createDeliverySalesOrderWithJson(json_encode($this->mock));
        $this->assertJson($orderJson);
        $orderObj = json_decode($orderJson);
        $this->assertAttributeInternalType('boolean','error',$orderObj);
        $this->assertAttributeInternalType('string','message',$orderObj);

        var_dump($orderObj);
        if ($orderObj->error){
            var_dump($orderObj);
        }
        else {
            $this->assertAttributeInternalType('int','id',$orderObj);
            $this->assertAttributeInternalType('object','posted_at',$orderObj);
            $this->assertAttributeNotEmpty('valor_total',$orderObj);

            $repoOrder = $this->app->make(OrderRepositoryInterface::class);
            $recordOrder = $repoOrder->find($orderObj->id);

//            $this->assertObjectHasAttribute('partner', $recordOrder);
            $this->assertEquals($recordOrder->partner->nome, $this->mock['nome']);
            $this->assertEquals($recordOrder->address->cep, $this->mock['cep']);
            $this->assertEquals($recordOrder->address->partner->nome, $this->mock['nome']);

            $this->assertEquals($recordOrder->sharedOrderPayment->pagamento, $this->mock['pagamento']);
            $this->assertEquals($recordOrder->sharedOrderType->tipo, 'ordemVenda');

            // Assertions for Email
            if (array_key_exists('email', $this->mock)){
                $repoContact = $this->app->make(ContactRepositoryInterface::class);
                $recordContact = $repoContact->findOneBy([
                    'contact_type'=>'email',
                    'contact_data'=>$this->mock['email']
                ]);
                $this->assertNotNull($recordContact);
                $this->assertEquals($recordContact->partner->nome, $this->mock['name']);
            }

            // Assertions for telefone
            if (array_key_exists('telefone', $this->mock)){
                $repoContact = $this->app->make(ContactRepositoryInterface::class);
                $recordContact = $repoContact->findOneBy([
                    'contact_type'=>'telefone',
                    'contact_data'=>$this->mock['telefone']
                ]);
                $this->assertNotNull($recordContact);
                $this->assertEquals($recordContact->partner->nome, $this->mock['nome']);
            }

            // Assertions for whatsapp
            if (array_key_exists('whatsapp', $this->mock)){
                $repoContact = $this->app->make(ContactRepositoryInterface::class);
                $recordContact = $repoContact->findOneBy([
                    'contact_type'=>'whatsapp',
                    'contact_data'=>$this->mock['whatsapp']
                ]);
                $this->assertNotNull($recordContact);
                $this->assertEquals($recordContact->partner->nome, $this->mock['nome']);
            }

            // Assertions for Status
            $repoSharedStat = $this->app->make(SharedStatRepositoryInterface::class);
            $recordSharedStat = $repoSharedStat->findOneBy(['status'=>'aberto']);
            $this->assertNotNull($recordSharedStat);

            $repoOrderSharedStat = $this->app->make(OrderSharedStatRepositoryInterface::class);
            $recordOrderSharedStat = $repoOrderSharedStat->findOneBy([
                'order_id'=>$recordOrder->id,
                'shared_stat_id'=>$recordSharedStat->id
            ]);
            $this->assertNotNull($recordOrderSharedStat);

            $this->assertEquals($recordOrderSharedStat->order->id, $recordOrder->id);
            $this->assertEquals($recordOrderSharedStat->sharedStat->id, $recordSharedStat->id);
        }
    }

    public function testResumoDasOrdens(){
//        $resumoDasOrdens = $this->service->itemStock;
//        var_dump($resumoDasOrdens);
    }
}
