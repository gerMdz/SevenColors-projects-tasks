<?php

namespace App\Factory;

use App\Entity\AndesUser;
use App\Repository\AndesUserRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<AndesUser>
 *
 * @method static AndesUser|Proxy createOne(array $attributes = [])
 * @method static AndesUser[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AndesUser|Proxy find(object|array|mixed $criteria)
 * @method static AndesUser|Proxy findOrCreate(array $attributes)
 * @method static AndesUser|Proxy first(string $sortedField = 'id')
 * @method static AndesUser|Proxy last(string $sortedField = 'id')
 * @method static AndesUser|Proxy random(array $attributes = [])
 * @method static AndesUser|Proxy randomOrCreate(array $attributes = [])
 * @method static AndesUser[]|Proxy[] all()
 * @method static AndesUser[]|Proxy[] findBy(array $attributes)
 * @method static AndesUser[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static AndesUser[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AndesUserRepository|RepositoryProxy repository()
 * @method AndesUser|Proxy create(array|callable $attributes = [])
 */
final class AndesUserFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'email' => self::faker()->email(),
            'roles' => [],
            'primerNombre' => self::faker()->name,
            'password' => self::faker()->password()

        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(AndesUser $andesUser) {})
        ;
    }

    protected static function getClass(): string
    {
        return AndesUser::class;
    }
}
