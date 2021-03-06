<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-02-25 22:56:30.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErpNET\App\Models\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ErpNET\App\Models\Doctrine\Entities\ProductProductGroup
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="ProductProductGroupRepository")
 * @ORM\Table(name="product_product_group", indexes={@ORM\Index(name="product_product_group_product_id_index", columns={"product_id"}), @ORM\Index(name="product_product_group_product_group_id_index", columns={"product_group_id"})})
 */
class ProductProductGroup extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    protected $product_id;

    /**
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    protected $product_group_id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productProductGroups")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="ProductGroup", inversedBy="productProductGroups")
     * @ORM\JoinColumn(name="product_group_id", referencedColumnName="id", nullable=false)
     */
    protected $productGroup;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductProductGroup
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of product_id.
     *
     * @param integer $product_id
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductProductGroup
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of product_id.
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_group_id.
     *
     * @param integer $product_group_id
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductProductGroup
     */
    public function setProductGroupId($product_group_id)
    {
        $this->product_group_id = $product_group_id;

        return $this;
    }

    /**
     * Get the value of product_group_id.
     *
     * @return integer
     */
    public function getProductGroupId()
    {
        return $this->product_group_id;
    }

    /**
     * Set Product entity (many to one).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\Product $product
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductProductGroup
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get Product entity (many to one).
     *
     * @return \ErpNET\App\Models\Doctrine\Entities\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set ProductGroup entity (many to one).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\ProductGroup $productGroup
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductProductGroup
     */
    public function setProductGroup(ProductGroup $productGroup = null)
    {
        $this->productGroup = $productGroup;

        return $this;
    }

    /**
     * Get ProductGroup entity (many to one).
     *
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductGroup
     */
    public function getProductGroup()
    {
        return $this->productGroup;
    }

    public function __sleep()
    {
        return array('id', 'created_at', 'updated_at', 'product_id', 'product_group_id');
    }
}