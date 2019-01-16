<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="AppUser")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="sender")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="receiver")
     */
    private $recievedMessage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="owner")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notation", mappedBy="giver")
     */
    private $giverNotations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notation", mappedBy="receiver")
     */
    private $reveiverNotations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Meal", mappedBy="proposedBy")
     */
    private $mealProposed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paypal;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="traveler")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Claim", mappedBy="claimer")
     */
    private $claims;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReferenceDocument", mappedBy="owner")
     */
    private $referenceDocuments;


    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->recievedMessage = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->notations = new ArrayCollection();
        $this->receiverNotations = new ArrayCollection();
        $this->giverNotations = new ArrayCollection();
        $this->reveiverNotations = new ArrayCollection();
        $this->mealProposed = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->claims = new ArrayCollection();
        $this->referenceDocuments = new ArrayCollection();
    }

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

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getRecievedMessage(): Collection
    {
        return $this->recievedMessage;
    }

    public function addRecievedMessage(Message $recievedMessage): self
    {
        if (!$this->recievedMessage->contains($recievedMessage)) {
            $this->recievedMessage[] = $recievedMessage;
            $recievedMessage->setReceiver($this);
        }

        return $this;
    }

    public function removeRecievedMessage(Message $recievedMessage): self
    {
        if ($this->recievedMessage->contains($recievedMessage)) {
            $this->recievedMessage->removeElement($recievedMessage);
            // set the owning side to null (unless already changed)
            if ($recievedMessage->getReceiver() === $this) {
                $recievedMessage->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setOwner($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getOwner() === $this) {
                $address->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notation[]
     */
    public function getGiverNotations(): Collection
    {
        return $this->giverNotations;
    }

    public function addGiverNotation(Notation $giverNotation): self
    {
        if (!$this->giverNotations->contains($giverNotation)) {
            $this->giverNotations[] = $giverNotation;
            $giverNotation->setGiver($this);
        }

        return $this;
    }

    public function removeGiverNotation(Notation $giverNotation): self
    {
        if ($this->giverNotations->contains($giverNotation)) {
            $this->giverNotations->removeElement($giverNotation);
            // set the owning side to null (unless already changed)
            if ($giverNotation->getGiver() === $this) {
                $giverNotation->setGiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notation[]
     */
    public function getReveiverNotations(): Collection
    {
        return $this->reveiverNotations;
    }

    public function addReveiverNotation(Notation $reveiverNotation): self
    {
        if (!$this->reveiverNotations->contains($reveiverNotation)) {
            $this->reveiverNotations[] = $reveiverNotation;
            $reveiverNotation->setReceiver($this);
        }

        return $this;
    }

    public function removeReveiverNotation(Notation $reveiverNotation): self
    {
        if ($this->reveiverNotations->contains($reveiverNotation)) {
            $this->reveiverNotations->removeElement($reveiverNotation);
            // set the owning side to null (unless already changed)
            if ($reveiverNotation->getReceiver() === $this) {
                $reveiverNotation->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Meal[]
     */
    public function getMealProposed(): Collection
    {
        return $this->mealProposed;
    }

    public function addMealProposed(Meal $mealProposed): self
    {
        if (!$this->mealProposed->contains($mealProposed)) {
            $this->mealProposed[] = $mealProposed;
            $mealProposed->setProposedBy($this);
        }

        return $this;
    }

    public function removeMealProposed(Meal $mealProposed): self
    {
        if ($this->mealProposed->contains($mealProposed)) {
            $this->mealProposed->removeElement($mealProposed);
            // set the owning side to null (unless already changed)
            if ($mealProposed->getProposedBy() === $this) {
                $mealProposed->setProposedBy(null);
            }
        }

        return $this;
    }

    public function getPaypal(): ?string
    {
        return $this->paypal;
    }

    public function setPaypal(?string $paypal): self
    {
        $this->paypal = $paypal;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(?bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setTraveler($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getTraveler() === $this) {
                $booking->setTraveler(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Claim[]
     */
    public function getClaims(): Collection
    {
        return $this->claims;
    }

    public function addClaim(Claim $claim): self
    {
        if (!$this->claims->contains($claim)) {
            $this->claims[] = $claim;
            $claim->setClaimer($this);
        }

        return $this;
    }

    public function removeClaim(Claim $claim): self
    {
        if ($this->claims->contains($claim)) {
            $this->claims->removeElement($claim);
            // set the owning side to null (unless already changed)
            if ($claim->getClaimer() === $this) {
                $claim->setClaimer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReferenceDocument[]
     */
    public function getReferenceDocuments(): Collection
    {
        return $this->referenceDocuments;
    }

    public function addReferenceDocument(ReferenceDocument $referenceDocument): self
    {
        if (!$this->referenceDocuments->contains($referenceDocument)) {
            $this->referenceDocuments[] = $referenceDocument;
            $referenceDocument->setOwner($this);
        }

        return $this;
    }

    public function removeReferenceDocument(ReferenceDocument $referenceDocument): self
    {
        if ($this->referenceDocuments->contains($referenceDocument)) {
            $this->referenceDocuments->removeElement($referenceDocument);
            // set the owning side to null (unless already changed)
            if ($referenceDocument->getOwner() === $this) {
                $referenceDocument->setOwner(null);
            }
        }

        return $this;
    }
}
