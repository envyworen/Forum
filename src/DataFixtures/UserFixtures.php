<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture {

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {
        // Exemples de données à insérer dans la base de données
        $exemples = [
            ['pseudo' => 'admin', 'passwd' => 'admin', 'roles' => ['ROLE_USER', 'ROLE_ADMIN']],
            ['pseudo' => 'david', 'passwd' => 'dc', 'roles' => ['ROLE_USER']],
        ];
        // Boucle pour chaque ligne
        foreach ($exemples as $exemple) {
            // Crée une nouvelle entité
            $user = new User();
            // Donne des valeurs à ses attributs
            $user->setPseudo($exemple['pseudo']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $exemple['passwd']));
            $user->setRoles($exemple['roles']);
            // Enregistre dans la BDD (INSERT)
            $manager->persist($user);
        }
        $manager->flush();
    }
}
