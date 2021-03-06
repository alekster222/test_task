<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AttachmentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
        ->add('name', HiddenType::class, array())
        ->add('is_image', HiddenType::class, array('attr' => array('class' => 'is-image')))
        ->add('orig_name', TextType::class, array(
				'label' => 'Название',
				'required' => true,
				)
			);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Attachment'
        ));
    }

    public function getName() {
        return 'Attachment';
    }

}
