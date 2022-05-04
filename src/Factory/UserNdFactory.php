<?php

namespace App\Factory;

use App\Entity\UserNd;
use App\Repository\UserNdRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<UserNd>
 *
 * @method static UserNd|Proxy createOne(array $attributes = [])
 * @method static UserNd[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static UserNd|Proxy find(object|array|mixed $criteria)
 * @method static UserNd|Proxy findOrCreate(array $attributes)
 * @method static UserNd|Proxy first(string $sortedField = 'id')
 * @method static UserNd|Proxy last(string $sortedField = 'id')
 * @method static UserNd|Proxy random(array $attributes = [])
 * @method static UserNd|Proxy randomOrCreate(array $attributes = [])
 * @method static UserNd[]|Proxy[] all()
 * @method static UserNd[]|Proxy[] findBy(array $attributes)
 * @method static UserNd[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static UserNd[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserNdRepository|RepositoryProxy repository()
 * @method UserNd|Proxy create(array|callable $attributes = [])
 */
final class UserNdFactory extends ModelFactory
{
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();


        $this->passwordHasher = $passwordHasher;
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'email' => self::faker()->email(),
            'firstName' => self::faker()->firstName(),
//            'password' => $this->passwordHasher->hashPassword()
            'plainPassword' => 'tada',
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            ->afterInstantiate(function(UserNd $userNd) {
                if($userNd->getPlainPassword()){
                    $userNd->setPassword(
                      $this->passwordHasher->hashPassword($userNd, $userNd->getPlainPassword())
                    );
                }
            })
        ;
    }

    protected static function getClass(): string
    {
        return UserNd::class;
    }
}
