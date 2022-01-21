<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;


#[\Attribute]
class AgeConstraint extends Constraint
{
    public $message = 'Cette date de naissance indique une personne de 150 ans ou plus : seules les personnes de moins de 150 ans peuvent être enregistrées.';
    public $mode = 'strict';
}