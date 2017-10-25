<?php
/**
 * Created by PhpStorm.
 * User: Karim
 * Date: 25-10-17
 * Time: 14:04
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname');
    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }


}
