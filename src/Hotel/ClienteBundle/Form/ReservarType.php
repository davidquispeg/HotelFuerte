<?php
namespace Hotel\ClienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReservarType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		    ->add('nombre')
		    ->add('email')
		    ->add('telefono')
		    ->add('habitacion','choice',array('choices'=>array('simple'=>'Simple','matrimonial'=>'Matrimonial'),'required'=>true));
	}
	public function getName()
	{
		return 'HotelCliente_reservar';
	}
}