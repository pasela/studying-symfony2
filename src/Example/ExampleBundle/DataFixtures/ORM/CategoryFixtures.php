<?php

namespace Example\ExampleBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Example\ExampleBundle\Entity\Category;


class CategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $list = array(
            'books'  => '文庫',
            'comics' => 'コミック',
            'cds'    => 'CD',
            'dvds'   => 'DVD',
        );

        foreach ($list as $key => $value) {
            $category = new Category();
            $category->setName($value);
            $manager->persist($category);
            $this->addReference($key, $category);
        }

        $manager->flush();
    }
}
