<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 02/05/16
 * Time: 00:27
 */

namespace ErpNET\App\Models\Doctrine\CustomTraits;

use Doctrine\ORM\Mapping as ORM;

trait MandanteTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $mandante;

    /**
     * Set the value of mandante.
     *
     * @param string $mandante
     * @return \ErpNET\App\Models\Doctrine\Entities\Partner
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
}