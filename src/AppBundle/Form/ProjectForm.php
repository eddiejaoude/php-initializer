<?php
namespace AppBundle\Form;

use AppBundle\Domain\Package;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProjectForm
 * @package AppBundle\Form
 */
class ProjectForm extends AbstractType
{

    /**
     * @var array
     */
    private $packages;

    /**
     * @param array $packages
     */
    public function __construct(array $packages)
    {
        $this->packages = $packages;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('owner', TextType::class,
                array(
                    'label' => 'Project Name (GitHub User/Organisation e.g. eddiejaoude)',
                )
            )
            ->add('name', TextType::class,
                array(
                    'label' => 'Project Name (e.g. php-initializer)',
                )
            )
            ->add('licensing', ChoiceType::class,
                array(
                    'choices' => array(
                        'MIT' => 'MIT',
                        'Apache' => 'Apache',
                        'GPL' => 'GPL',
                    ),
                )
            )
            ->add('framework', ChoiceType::class,
                array(
                    'choices' => array(
                        'Symfony' => 'Symfony',
                    ),
                )
            )
            ->add('version', ChoiceType::class,
                array(
                    'choices' => array(
                        'v2.8 Long term support (LTS)' => '2.8',
                        'v3.1 Latest' => '3.1',
                    ),
                )
            )
            ->add('prodPackages', ChoiceType::class,
                array(
                    'expanded' => true,
                    'multiple' => true,
                    'choices' => $this->packages['prod']
                )
            )
            ->add('devPackages', ChoiceType::class,
                array(
                    'expanded' => true,
                    'multiple' => true,
                    'choices' => $this->packages['dev']
                )
            )
            ->add('build', SubmitType::class,
                array(
                    'label' => 'Build project & download',
                    'attr' => array(
                        'class' => 'btn-success btn-block'
                    )
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Domain\Project',
            )
        );
    }
}
