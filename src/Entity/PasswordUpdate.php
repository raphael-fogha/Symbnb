<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;


class PasswordUpdate
{

    private $oldPassword;

     /**
     * @Assert\NotEqualTo(propertyPath="oldPassword", message="Votre nouveau mot de passe doit être different du précédent")
     * @Assert\Length(min=8,minMessage="Votre mot de passe doit faire au moins 8 caractères")
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(propertyPath="newPassword", message="La confirmation doit être identique au mot de passe")
     */
    private $confirmPassword;

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
