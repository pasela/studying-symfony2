<?php

namespace Example\ExampleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Example\ExampleBundle\Entity\User;


class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('email', 'email', array(
            'label' => 'メールアドレス',
            'required' => true,
        ));

        $builder->add('rawPassword', 'repeated', array(
            'type' => 'password',
            'invalid_message' => '同じ値を入力してください',
            'options' => array(
                'label' => 'パスワード',
                'required' => true,
            ),
        ));

        $builder->add('name', 'text', array(
            'label' => '名前',
            'required' => true,
        ));

        $builder->add('sex', 'choice', array(
            'label' => '性別',
            'choices' => User::$sexTypes,
            'expanded' => true,
            // 'empty_value' => '性別を選んでください',
            // 'empty_data' => null,
            'required' => false,
        ));

        $builder->add('birthday', 'birthday', array(
            'label' => '生年月日',
            'widget' => 'choice',
            'empty_value' => array('year' => '年', 'month' => '月', 'day' => '日'),
            'required' => false,
        ));
    }

    public function getName()
    {
        return 'user';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'validation_groups' => 'register',
        );
    }
}
