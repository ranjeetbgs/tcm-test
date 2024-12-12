<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_label = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentLabel(): ?string
    {
        return $this->payment_label;
    }

    public function setPaymentLabel(string $payment_label): static
    {
        $this->payment_label = $payment_label;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        
        return [
            'id' => $this->getId(),
            'payment_label' => $this->getPaymentLabel(),
            'amount' => $this->getAmount(),
            'location'=>$this->getLocation(),
            'created_at'=>$this->getCreatedAt()
        ];
    }

    public function getLocations()
    {
        return array(
            "48.8666645,2.3159525",
            "48.8666645,2.3159525",
            "48.8694753,2.3104226",
            "48.8685859,2.2928473",
            "48.864118,2.3442282",
            "48.8593442,2.3392999",
            "48.8557324,2.3822849",
            "48.8450602,2.3340677",
            "48.8463339,2.3297925",
            "48.8821775,2.3166563"

        );
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
