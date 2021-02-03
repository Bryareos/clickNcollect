<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"store:read"}},
 *     denormalizationContext={"groups"={"store:write"}}
 * )
 * @ORM\Entity(repositoryClass=StoreRepository::class)
 */
class Store
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"store:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"store:read", "store:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"store:read", "store:write"})
     */
    private $adress;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @Groups({"store:read", "store:write"})
     */
    private $isOpen;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="store_id")
     * 
     * @Groups({"store:read"})
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=MerchantInfo::class, inversedBy="stores")
     */
    private $merchant_info_id;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setStoreId($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getStoreId() === $this) {
                $product->setStoreId(null);
            }
        }

        return $this;
    }

    public function getMerchantInfoId(): ?MerchantInfo
    {
        return $this->merchant_info_id;
    }

    public function setMerchantInfoId(?MerchantInfo $merchant_info_id): self
    {
        $this->merchant_info_id = $merchant_info_id;

        return $this;
    }
}
