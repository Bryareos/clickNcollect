<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"option:read"}},
 *      denormalizationContext={"groups"={"option:write"}}
 * )
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"option:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"option:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"option:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups({"option:read"})
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=MerchantInfo::class, mappedBy="option")
     */
    private $merchantInfos;

    public function __construct()
    {
        $this->merchantInfos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|MerchantInfo[]
     */
    public function getMerchantInfos(): Collection
    {
        return $this->merchantInfos;
    }

    public function addMerchantInfo(MerchantInfo $merchantInfo): self
    {
        if (!$this->merchantInfos->contains($merchantInfo)) {
            $this->merchantInfos[] = $merchantInfo;
            $merchantInfo->setOption($this);
        }

        return $this;
    }

    public function removeMerchantInfo(MerchantInfo $merchantInfo): self
    {
        if ($this->merchantInfos->removeElement($merchantInfo)) {
            // set the owning side to null (unless already changed)
            if ($merchantInfo->getOption() === $this) {
                $merchantInfo->setOption(null);
            }
        }

        return $this;
    }
}
