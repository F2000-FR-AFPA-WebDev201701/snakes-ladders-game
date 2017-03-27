<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type as FormType;

class UserType extends \Symfony\Component\Form\AbstractType {

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
        $builder->add('emailLogin', FormType\TextType::class)
                ->add('password', FormType\TextType::class)
                ->add('icone', FormType\FileType::class)
                ->add('pseudo', FormType\TextType::class)
                ->add('firstname', FormType\TextType::class)
                ->add('lastname', FormType\TextType::class)
                ->add('save', FormType\SubmitType::class, array('attr' => array('class' => 'save')));
    }

}
