<?php

namespace App\Entity;

use App\Repository\CurrenciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurrenciesRepository::class)
 */
class Currencies
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=Rates::class, mappedBy="currency_id", orphanRemoval=true)
     */
    private $rates;

    /**
     * Currencies constructor.
     */
    public function __construct()
    {
        $this->rates = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Rates[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    /**
     * @param Rates $rate
     * @return $this
     */
    public function addRate(Rates $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setCurrencyId($this);
        }

        return $this;
    }

    /**
     * @param Rates $rate
     * @return $this
     */
    public function removeRate(Rates $rate): self
    {
        if ($this->rates->contains($rate)) {
            $this->rates->removeElement($rate);
            // set the owning side to null (unless already changed)
            if ($rate->getCurrencyId() === $this) {
                $rate->setCurrencyId(null);
            }
        }

        return $this;
    }
}
