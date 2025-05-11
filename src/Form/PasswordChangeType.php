<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'autocomplete' => 'current-password',
                    'class' => 'form-control'
                ],
            ])
            ->add('newPassword', PasswordType::class, [
                'label'       => 'Nouveau mot de passe',
                'mapped'      => false,
                'constraints' => [
                    new NotBlank(['message'    => 'Veuillez entrer un mot de passe']),
                    new Length([
                        'min'        => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max'        => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+]).{8,}$/u',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule (A-Z), une lettre minuscule (a-z), un chiffre (0-9) et un caractère spécial',
                    ]),
                ],
                'attr' => [
                    'class'      => 'form-control',
                    'required'   => true,   // empêche la soumission vide
                    'minlength'  => 8,      // empêche la soumission < 8 caractères
                    'autocomplete' => 'new-password',
                    'title'      => '8 caractères minimum',
                ],
                'help' => 'Minimum 8 caractères (maj, min, chiffre, spécial)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        'data_class'      => null,
        'csrf_protection' => true,
        'csrf_field_name' => '_token',          // nom du champ hidden
        'csrf_token_id'   => 'password_change', // identifiant unique pour ce formulaire
    ]);
    }
}