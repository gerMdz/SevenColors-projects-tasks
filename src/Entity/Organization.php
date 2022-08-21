<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Hashids\Hashids;

/**
 * @ORM\Entity(repositoryClass=OrganizationRepository::class)
 */
class Organization
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private ?Uuid $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private ?string $hashkey;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private ?string $identificador;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isOwnerSite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $tax_identification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $legal_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $contact_email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $contact_phone;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="organization")
     */
    private ArrayCollection $organization_user;

    public function __construct()
    {
        $hashids = new Hashids($this->identificador, 12);
        $this->hashkey = $hashids->encode(1, 2, 3);
        $this->organization_user = new ArrayCollection();

    }

    public function getId(): ?Uuid
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

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getHashkey(): ?string
    {
        return $this->hashkey;
    }

    public function setHashkey(?string $hashkey): self
    {
        $this->hashkey = $hashkey;

        return $this;
    }

    public function getIdentificador(): ?string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador): self
    {
        $this->identificador = $identificador;

        return $this;
    }

    public function isIsOwnerSite(): ?bool
    {
        return $this->isOwnerSite;
    }

    public function setIsOwnerSite(?bool $isOwnerSite): self
    {
        $this->isOwnerSite = $isOwnerSite;

        return $this;
    }

    public function getTaxIdentification(): ?string
    {
        return $this->tax_identification;
    }

    public function setTaxIdentification(?string $tax_identification): self
    {
        $this->tax_identification = $tax_identification;

        return $this;
    }

    public function getLegalName(): ?string
    {
        return $this->legal_name;
    }

    public function setLegalName(?string $legal_name): self
    {
        $this->legal_name = $legal_name;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contact_email;
    }

    public function setContactEmail(?string $contact_email): self
    {
        $this->contact_email = $contact_email;

        return $this;
    }

    public function getContactPhone(): ?string
    {
        return $this->contact_phone;
    }

    public function setContactPhone(?string $contact_phone): self
    {
        $this->contact_phone = $contact_phone;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getOrganizationUser(): Collection
    {
        return $this->organization_user;
    }

    public function addOrganizationUser(User $organizationUser): self
    {
        if (!$this->organization_user->contains($organizationUser)) {
            $this->organization_user[] = $organizationUser;
            $organizationUser->setOrganization($this);
        }

        return $this;
    }

    public function removeOrganizationUser(User $organizationUser): self
    {
        if ($this->organization_user->removeElement($organizationUser)) {
            // set the owning side to null (unless already changed)
            if ($organizationUser->getOrganization() === $this) {
                $organizationUser->setOrganization(null);
            }
        }

        return $this;
    }
}
