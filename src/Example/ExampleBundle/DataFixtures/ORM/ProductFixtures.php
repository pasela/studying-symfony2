<?php

namespace Example\ExampleBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Example\ExampleBundle\Entity\Product;


class ProductFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $list = array(
            array(
                'name'        => 'Symfony2 Cookbook (1)',
                'price'       => '1500',
                'description' => 'You will find specific solutions for specific needs.',
                'category'    => 'books',
            ),
            array(
                'name'        => 'Symfony2 Cookbook (2)',
                'price'       => '1600',
                'description' => 'Second recipe book.',
                'category'    => 'books',
            ),
            array(
                'name'        => 'シンフォニー',
                'price'       => '500',
                'description' => '待望のSymfony2コミックス！',
                'category'    => 'comics',
            ),
            array(
                'name'        => 'Healing Symfony',
                'price'       => '1200',
                'description' => '癒しミュージック',
                'category'    => 'cds',
            ),
            array(
                'name'        => 'Symfony the Movie',
                'price'       => '4600',
                'description' => '映画SymfonyがついにDVD化！',
                'category'    => 'dvds',
            ),
        );

        foreach ($list as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setDescription($data['description']);
            $product->setCategory($manager->merge($this->getReference($data['category'])));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
