<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue as TrueConstraint;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class RegistrationType extends AbstractType
{

    /**
    * @var AuthorizationChecker
    */
    private $authorizationChecker=null;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
      $this->authorizationChecker=$authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class,["label"=>"register.name","required"=>true,'translation_domain' => 'FOSUserBundle'])
                ->add('surname',TextType::class,["label"=>"register.surname","required"=>true,'translation_domain' => 'FOSUserBundle'])
                ->add('phone',PhoneNumberType::class,["label"=>"register.phonenum",'translation_domain' => 'FOSUserBundle'])
                ->add('organization',TextType::class,["label"=>"register.organization","required"=>false,'translation_domain' => 'FOSUserBundle'])
                ->add('occupation',TextType::class,["label"=>"register.position","required"=>false,'translation_domain' => 'FOSUserBundle']);
        $builder->add('accept_terms',CheckboxType::class,["label"=>"register.acceptTerms","required"=>true,'translation_domain' => 'FOSUserBundle',
                                                            'mapped' => false,'constraints' => new TrueConstraint(array('message' => 'Your Confirmation Message','groups' => 'Registration'))]);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
