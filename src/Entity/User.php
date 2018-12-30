<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *@UniqueEntity(fields= {"email"}, message="Votre Email est déja utilisé")
 */
 class User implements UserInterface {
             /**
              * @ORM\Id()
              * @ORM\GeneratedValue()
              * @ORM\Column(type="integer")
              */
             private $id;
         
             /**
              * @ORM\Column(type="string", length=255)
              */
             private $name;
         
             /**
              * @ORM\Column(type="string", length=255)
              * @Assert\Email()
              */
             private $email;
         
             /**
              * @ORM\Column(type="string", length=255)
              * @Assert\Length(min="6",minMessage="Le mot de passe doit faire minimum 6 caractères")
              */
             private $password;
                
            /**
            * @Assert\EqualTo(propertyPath="password", message="verifier le mot de passe")
            */
            public $confirm_password;
             
         
             
         
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
         
             public function getEmail(): ?string
             {
                 return $this->email;
             }
         
             public function setEmail(string $email): self
             {
                 $this->email = $email;
         
                 return $this;
             }
         
             public function getPassword(): ?string
             {
                 return $this->password;
             }
         
             public function setPassword(string $password): self
             {
                 $this->password = $password;
         
                 return $this;
             }
         
             /**
              * @return Collection|Annonces[]
              */
             public function getAnnonces(): Collection
             {
                 return $this->annonces;
             }
         
             public function addAnnonce(Annonces $annonce): self
             {
                 if (!$this->annonces->contains($annonce)) {
                     $this->annonces[] = $annonce;
                     $annonce->setUser($this);
                 }
         
                 return $this;
             }
         
             public function removeAnnonce(Annonces $annonce): self
             {
                 if ($this->annonces->contains($annonce)) {
                     $this->annonces->removeElement($annonce);
                     // set the owning side to null (unless already changed)
                     if ($annonce->getUser() === $this) {
                         $annonce->setUser(null);
                     }
                 }
         
                 return $this;
             }
   
            

             public function getUsername(){}

             public function eraseCredentials(){}

             public function getSalt(){}

             public function getRoles(){
                return ['ROLE_USERS'];
                     }
         }
