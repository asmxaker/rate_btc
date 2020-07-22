<?php

namespace App\Entity;

use App\Repository\RatesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatesRepository::class)
 */
class Rates
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Currencies::class, inversedBy="rates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;

    /**
     * @ORM\Column(type="float")
     * @ORM\Column(columnDefinition="")
     */
    private $rate_value;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    public $created_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyId(): ?Currencies
    {
        return $this->currency;
    }

    public function setCurrencyId(?Currencies $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getRateValue(): ?float
    {
        return $this->rate_value;
    }

    public function setRateValue(float $rate_value): self
    {
        $this->rate_value = $rate_value;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
}
