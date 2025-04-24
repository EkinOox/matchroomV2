<?php

namespace App\Dto\User\Admin;

use App\Entity\User;
use App\Validator\ValidRoles;
use App\Validator\UniqueField;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class AdminPatchDTO
{

    #[Groups(['patch:admin'])]
    #[Assert\Email(message: 'L\'adresse email n\'est pas valide.')]
    #[Assert\Length(
        max: 180,
        maxMessage: 'L\'adresse email ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[UniqueField(
        entityClass: User::class,
        field: 'email',
        message: 'Il existe déjà un compte avec cet email.'
    )]
    public ?string $email = null;

    #[Groups(['patch:admin'])]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9_]{2,20}$/',
        message: 'Le pseudonyme doit comporter entre 2 et 20 caractères et ne peut contenir que des lettres, des chiffres et des underscores (_).'
    )]
    #[UniqueField(
        entityClass: User::class,
        field: 'pseudo',
        message: 'Ce pseudo est déjà utilisé.'
    )]
    public ?string $pseudo = null;

    #[Groups(['patch:admin'])]
    #[Assert\Regex(
        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{16,100}$/',
        message: 'Le mot de passe doit comporter au moins 16 caractères et contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial.'
    )]
    #[Assert\NotCompromisedPassword(message: 'Ce mot de passe a été compromis dans une violation de données. Veuillez en choisir un autre.')]
    public ?string $password = null;

    #[Groups(['patch:admin'])]
    #[ValidRoles]
    public array $roles = [];

    #[Groups(['patch:admin'])]
    #[Assert\Range(
        min: 0,
        max: 1000000000,
        notInRangeMessage: 'Le solde doit être compris entre {{ min }} et {{ max }}.'
    )]
    public ?float $balance = null;
}
