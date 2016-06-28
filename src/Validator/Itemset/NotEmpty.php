<?php

namespace Chiquitto\Soul\Validator\Itemset;

use Chiquitto\Soul\Model\Vo\Itemset;

/**
 * Valid if itemset isn't empty
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class NotEmpty extends AbstractValidator
{

    const IS_EMPTY = 'isEmpty';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = [
        self::IS_EMPTY => "The input is an empty itemset",
    ];

    public function isValid($value)
    {
        return $this->isValidIsempty($value);
    }

    protected function isValidIsempty($value)
    {
        /* @var $value Itemset */

        $count = $value->count();
        // $this->setValue($count);

        if ($count == 0) {
            $this->error(self::IS_EMPTY);
            return false;
        }

        return true;
    }

}
