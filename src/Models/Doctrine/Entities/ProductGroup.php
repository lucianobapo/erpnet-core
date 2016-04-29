<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-02-25 22:56:30.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErpNET\App\Models\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ErpNET\App\Models\Doctrine\Entities\ProductGroup
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="ProductGroupRepository")
 * @ORM\Table(name="product_groups", indexes={@ORM\Index(name="product_groups_mandante_index", columns={"mandante"})}) *
 */
class ProductGroup extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $mandante;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $grupo;

    /**
     * @ORM\OneToMany(targetEntity="ProductProductGroup", mappedBy="productGroup")
     * @ORM\JoinColumn(name="id", referencedColumnName="product_group_id", nullable=false)
     */
    protected $productProductGroups;

    public function __construct()
    {
        $this->productProductGroups = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductGroup
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
     * Set the value of mandante.
     *
     * @param string $mandante
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductGroup
     */
    public function setMandante($mandante)
    {
        $this->mandante = $mandante;

        return $this;
    }

    /**
     * Get the value of mandante.
     *
     * @return string
     */
    public function getMandante()
    {
        return $this->mandante;
    }

    /**
     * Set the value of grupo.
     *
     * @param string $grupo
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductGroup
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get the value of grupo.
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Add ProductProductGroup entity to collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\ProductProductGroup $productProductGroup
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductGroup
     */
    public function addProductProductGroup(ProductProductGroup $productProductGroup)
    {
        $this->productProductGroups[] = $productProductGroup;

        return $this;
    }

    /**
     * Remove ProductProductGroup entity from collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\ProductProductGroup $productProductGroup
     * @return \ErpNET\App\Models\Doctrine\Entities\ProductGroup
     */
    public function removeProductProductGroup(ProductProductGroup $productProductGroup)
    {
        $this->productProductGroups->removeElement($productProductGroup);

        return $this;
    }

    /**
     * Get ProductProductGroup entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductProductGroups()
    {
        return $this->productProductGroups;
    }

    public function __sleep()
    {
        return array('id', 'created_at', 'updated_at', 'deleted_at', 'mandante', 'grupo');
    }
}