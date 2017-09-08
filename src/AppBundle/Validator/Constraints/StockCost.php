<?php
// src/AppBundle/Validator/Constraints/ContainsAlphanumeric.php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class StockCost extends Constraint
{

    /**
     * @var string
     */
    public $message = 'Any stock item which costs less that {{ cost }} and has less than {{ stock }} stock will not imported.';

    /**
     * @var
     */
    public $field;

    /**
     * @var
     */
    public $minCost;

    /**
     * @var
     */
    public $minStock;

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'constraint.stock.validator';
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'minCost';
    }

    /**
     * Any stock item which costs less that $5 and
     * has less than 10 stock will not be imported.
     *
     * {@inheritDoc}
     */
    public function getRequiredOptions()
    {
        return array('minCost');
    }


    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}