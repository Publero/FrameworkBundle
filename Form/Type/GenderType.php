<?php
namespace Publero\FrameworkBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
class GenderType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'male' => 'form.gender.male',
                'female' => 'form.gender.female',
            ),
            'expanded' => true,
            'label' => 'form.gender.label',
            'translation_domain' => 'PubleroFrameworkBundle',
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'gender';
    }
}
