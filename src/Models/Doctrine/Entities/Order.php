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
 * ErpNET\App\Models\Doctrine\Entities\Order
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="OrderRepository")
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="orders_mandante_index", columns={"mandante"}), @ORM\Index(name="orders_partner_id_index", columns={"partner_id"}), @ORM\Index(name="orders_address_id_index", columns={"address_id"}), @ORM\Index(name="orders_currency_id_index", columns={"currency_id"}), @ORM\Index(name="orders_type_id_index", columns={"type_id"}), @ORM\Index(name="orders_payment_id_index", columns={"payment_id"}), @ORM\Index(name="orders_old_id_index", columns={"old_id"}), @ORM\Index(name="orders_deleted_at_index", columns={"deleted_at"})})
 */
class Order extends EntityBase
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
     * @ORM\Column(type="integer", nullable=true, options={"unsigned":true})
     */
    protected $partner_id;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned":true})
     */
    protected $address_id;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned":true})
     */
    protected $currency_id;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned":true})
     */
    protected $type_id;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned":true})
     */
    protected $payment_id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $posted_at;

    /**
     * @ORM\Column(type="float", precision=8, scale=2, nullable=true)
     */
    protected $valor_total;

    /**
     * @ORM\Column(type="float", precision=8, scale=2, nullable=true)
     */
    protected $desconto_total;

    /**
     * @ORM\Column(type="float", precision=8, scale=2, nullable=true)
     */
    protected $troco;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $referencia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $obsevacao;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $old_id;

    /**
     * @ORM\OneToMany(targetEntity="Attachment", mappedBy="order")
     * @ORM\JoinColumn(name="id", referencedColumnName="order_id", nullable=false)
     */
    protected $attachments;

    /**
     * @ORM\OneToMany(targetEntity="ItemOrder", mappedBy="order")
     * @ORM\JoinColumn(name="id", referencedColumnName="order_id", nullable=false)
     */
    protected $itemOrders;

    /**
     * @ORM\OneToMany(targetEntity="OrderConfirmation", mappedBy="order")
     * @ORM\JoinColumn(name="id", referencedColumnName="order_id", nullable=false)
     */
    protected $orderConfirmations;

    /**
     * @ORM\OneToMany(targetEntity="OrderSharedStat", mappedBy="order")
     * @ORM\JoinColumn(name="id", referencedColumnName="order_id", nullable=false)
     */
    protected $orderSharedStats;

    /**
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="orders")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     */
    protected $partner;

    /**
     * @ORM\ManyToOne(targetEntity="Address", inversedBy="orders")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="SharedCurrency", inversedBy="orders")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     */
    protected $sharedCurrency;

    /**
     * @ORM\ManyToOne(targetEntity="SharedOrderType", inversedBy="orders")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $sharedOrderType;

    /**
     * @ORM\ManyToOne(targetEntity="SharedOrderPayment", inversedBy="orders")
     * @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     */
    protected $sharedOrderPayment;

    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->itemOrders = new ArrayCollection();
        $this->orderConfirmations = new ArrayCollection();
        $this->orderSharedStats = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
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
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
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
     * Set the value of partner_id.
     *
     * @param integer $partner_id
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setPartnerId($partner_id)
    {
        $this->partner_id = $partner_id;

        return $this;
    }

    /**
     * Get the value of partner_id.
     *
     * @return integer
     */
    public function getPartnerId()
    {
        return $this->partner_id;
    }

    /**
     * Set the value of address_id.
     *
     * @param integer $address_id
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setAddressId($address_id)
    {
        $this->address_id = $address_id;

        return $this;
    }

    /**
     * Get the value of address_id.
     *
     * @return integer
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * Set the value of currency_id.
     *
     * @param integer $currency_id
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setCurrencyId($currency_id)
    {
        $this->currency_id = $currency_id;

        return $this;
    }

    /**
     * Get the value of currency_id.
     *
     * @return integer
     */
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     * Set the value of type_id.
     *
     * @param integer $type_id
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Get the value of type_id.
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of payment_id.
     *
     * @param integer $payment_id
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;

        return $this;
    }

    /**
     * Get the value of payment_id.
     *
     * @return integer
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * Set the value of posted_at.
     *
     * @param \DateTime $posted_at
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setPostedAt($posted_at)
    {
        $this->posted_at = $posted_at;

        return $this;
    }

    /**
     * Get the value of posted_at.
     *
     * @return \DateTime
     */
    public function getPostedAt()
    {
        return $this->posted_at;
    }

    /**
     * Set the value of valor_total.
     *
     * @param float $valor_total
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setValorTotal($valor_total)
    {
        $this->valor_total = $valor_total;

        return $this;
    }

    /**
     * Get the value of valor_total.
     *
     * @return float
     */
    public function getValorTotal()
    {
        return $this->valor_total;
    }

    /**
     * Set the value of desconto_total.
     *
     * @param float $desconto_total
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setDescontoTotal($desconto_total)
    {
        $this->desconto_total = $desconto_total;

        return $this;
    }

    /**
     * Get the value of desconto_total.
     *
     * @return float
     */
    public function getDescontoTotal()
    {
        return $this->desconto_total;
    }

    /**
     * Set the value of troco.
     *
     * @param float $troco
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setTroco($troco)
    {
        $this->troco = $troco;

        return $this;
    }

    /**
     * Get the value of troco.
     *
     * @return float
     */
    public function getTroco()
    {
        return $this->troco;
    }

    /**
     * Set the value of descricao.
     *
     * @param string $descricao
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of descricao.
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of referencia.
     *
     * @param string $referencia
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get the value of referencia.
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set the value of obsevacao.
     *
     * @param string $obsevacao
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setObsevacao($obsevacao)
    {
        $this->obsevacao = $obsevacao;

        return $this;
    }

    /**
     * Get the value of obsevacao.
     *
     * @return string
     */
    public function getObsevacao()
    {
        return $this->obsevacao;
    }

    /**
     * Set the value of old_id.
     *
     * @param integer $old_id
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setOldId($old_id)
    {
        $this->old_id = $old_id;

        return $this;
    }

    /**
     * Get the value of old_id.
     *
     * @return integer
     */
    public function getOldId()
    {
        return $this->old_id;
    }

    /**
     * Add Attachment entity to collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\Attachment $attachment
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function addAttachment(Attachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Remove Attachment entity from collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\Attachment $attachment
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function removeAttachment(Attachment $attachment)
    {
        $this->attachments->removeElement($attachment);

        return $this;
    }

    /**
     * Get Attachment entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Add ItemOrder entity to collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function addItemOrder(ItemOrder $itemOrder)
    {
        $this->itemOrders[] = $itemOrder;

        return $this;
    }

    /**
     * Remove ItemOrder entity from collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\ItemOrder $itemOrder
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function removeItemOrder(ItemOrder $itemOrder)
    {
        $this->itemOrders->removeElement($itemOrder);

        return $this;
    }

    /**
     * Get ItemOrder entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemOrders()
    {
        return $this->itemOrders;
    }

    /**
     * Add OrderConfirmation entity to collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\OrderConfirmation $orderConfirmation
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function addOrderConfirmation(OrderConfirmation $orderConfirmation)
    {
        $this->orderConfirmations[] = $orderConfirmation;

        return $this;
    }

    /**
     * Remove OrderConfirmation entity from collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\OrderConfirmation $orderConfirmation
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function removeOrderConfirmation(OrderConfirmation $orderConfirmation)
    {
        $this->orderConfirmations->removeElement($orderConfirmation);

        return $this;
    }

    /**
     * Get OrderConfirmation entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderConfirmations()
    {
        return $this->orderConfirmations;
    }

    /**
     * Add OrderSharedStat entity to collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\OrderSharedStat $orderSharedStat
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function addOrderSharedStat(OrderSharedStat $orderSharedStat)
    {
        $this->orderSharedStats[] = $orderSharedStat;

        return $this;
    }

    /**
     * Remove OrderSharedStat entity from collection (one to many).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\OrderSharedStat $orderSharedStat
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function removeOrderSharedStat(OrderSharedStat $orderSharedStat)
    {
        $this->orderSharedStats->removeElement($orderSharedStat);

        return $this;
    }

    /**
     * Get OrderSharedStat entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderSharedStats()
    {
        return $this->orderSharedStats;
    }

    /**
     * Set Partner entity (many to one).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\Partner $partner
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setPartner(Partner $partner = null)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * Get Partner entity (many to one).
     *
     * @return \ErpNET\App\Models\Doctrine\Entities\Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * Set Address entity (many to one).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\Address $address
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setAddress(Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get Address entity (many to one).
     *
     * @return \ErpNET\App\Models\Doctrine\Entities\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set SharedCurrency entity (many to one).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\SharedCurrency $sharedCurrency
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setSharedCurrency(SharedCurrency $sharedCurrency = null)
    {
        $this->sharedCurrency = $sharedCurrency;

        return $this;
    }

    /**
     * Get SharedCurrency entity (many to one).
     *
     * @return \ErpNET\App\Models\Doctrine\Entities\SharedCurrency
     */
    public function getSharedCurrency()
    {
        return $this->sharedCurrency;
    }

    /**
     * Set SharedOrderType entity (many to one).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\SharedOrderType $sharedOrderType
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setSharedOrderType(SharedOrderType $sharedOrderType = null)
    {
        $this->sharedOrderType = $sharedOrderType;

        return $this;
    }

    /**
     * Get SharedOrderType entity (many to one).
     *
     * @return \ErpNET\App\Models\Doctrine\Entities\SharedOrderType
     */
    public function getSharedOrderType()
    {
        return $this->sharedOrderType;
    }

    /**
     * Set SharedOrderPayment entity (many to one).
     *
     * @param \ErpNET\App\Models\Doctrine\Entities\SharedOrderPayment $sharedOrderPayment
     * @return \ErpNET\App\Models\Doctrine\Entities\Order
     */
    public function setSharedOrderPayment(SharedOrderPayment $sharedOrderPayment = null)
    {
        $this->sharedOrderPayment = $sharedOrderPayment;

        return $this;
    }

    /**
     * Get SharedOrderPayment entity (many to one).
     *
     * @return \ErpNET\App\Models\Doctrine\Entities\SharedOrderPayment
     */
    public function getSharedOrderPayment()
    {
        return $this->sharedOrderPayment;
    }

    public function __sleep()
    {
        return array('id', 'created_at', 'updated_at', 'deleted_at', 'mandante', 'partner_id', 'address_id', 'currency_id', 'type_id', 'payment_id', 'posted_at', 'valor_total', 'desconto_total', 'troco', 'descricao', 'referencia', 'obsevacao', 'old_id');
    }
}