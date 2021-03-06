<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MerchantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"user:read"}},
 *      denormalizationContext={"groups"={"user:write"}}
 * )
 * @ORM\Entity(repositoryClass=MerchantRepository::class)
 */
class Merchant implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * 
     * @Groups("user:read")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * 
     * @Groups("user:write")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity=MerchantInfo::class, mappedBy="merchant", cascade={"persist", "remove"})
     */
    private $merchantInfo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMerchantInfo(): ?MerchantInfo
    {
        return $this->merchantInfo;
    }

    public function setMerchantInfo(?MerchantInfo $merchantInfo): self
    {
        // unset the owning side of the relation if necessary
        if ($merchantInfo === null && $this->merchantInfo !== null) {
            $this->merchantInfo->setMerchant(null);
        }

        // set the owning side of the relation if necessary
        if ($merchantInfo !== null && $merchantInfo->getMerchant() !== $this) {
            $merchantInfo->setMerchant($this);
        }

        $this->merchantInfo = $merchantInfo;

        return $this;
    }
}
