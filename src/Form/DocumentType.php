<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DocumentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('name', TextType::class, array(
				'label' => 'Название документа',
				'required' => true,
				'attr' => array('class' => 'form-control'),
				'label_attr' => array('class' => 'required'))
			)
            ->add('description', TextAreaType::class,
                array(
					'label' => 'Описание документа',
                    'attr' => array('class' => 'form-control'),
                    'required' => false                    
                )
            )
			->add('attachment', CollectionType::class, array(
				'entry_type' => AttachmentType::class,
				'entry_options' => array('label' => false),
				'allow_delete' => true,
				'prototype' => true,
				'attr' => array(
					'class' => 'collection',
				),
			));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Document'
        ));
    }

    public function getName() {
        return 'Document';
    }

}
