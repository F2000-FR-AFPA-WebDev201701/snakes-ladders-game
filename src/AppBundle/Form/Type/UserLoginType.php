<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type as FormType;

class UserLoginType extends \Symfony\Component\Form\AbstractType {

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
        $builder->add('emailLogin', FormType\EmailType::class)
                ->add('password', FormType\TextType::class)
                ->add('save', FormType\SubmitType::class, array('attr' => array('class' => 'save')));
    }

}
