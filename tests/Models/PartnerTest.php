<?php
namespace ErpNET\Tests\Models;

use ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface;

class PartnerTest extends ModelsTestCase
{
    protected $testClass = PartnerRepositoryInterface::class;

//    protected $testDateFields = ['data_nascimento'];
    protected $testCarbonFields = ['data_nascimento'];

}
