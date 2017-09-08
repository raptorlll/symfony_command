<?php
namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\ProductData;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StockCostValidator extends ConstraintValidator
{
    public function validate($product, Constraint $constraint)
    {
        $constraint->getTargets();

        /** @var $product ProductData */
        if ($product->getStock() < $constraint->minStock && $product->getCost() < $constraint->minCost) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ cost }}', $constraint->minCost)
                ->setParameter('{{ stock }}', $constraint->minStock)
                ->addViolation();
        }
    }
}