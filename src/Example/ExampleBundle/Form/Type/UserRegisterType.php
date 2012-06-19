<?php

namespace Example\ExampleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('email', 'email', array(
            'label' => 'メールアドレス',
            'required' => true,
        ));

        $builder->add('password', 'password', array(
            'label' => 'パスワード',
            'required' => true,
        ));

        $builder->add('password_confirm', 'password', array(
            'label' => 'パスワード(確認)',
            'required' => true,
        ));

        $builder->add('name', 'text', array(
            'label' => '名前',
            'required' => true,
        ));

        $builder->add('sex', 'choice', array(
            'label' => '性別',
            'choices' => array('1' => '男性', '2' => '女性', '0' => '登録しない'),
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
