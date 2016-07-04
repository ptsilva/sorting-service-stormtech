<?php

namespace App\Service\Comparator;

use App\Service\Comparator\Contracts\StringComparatorInterface;

class StringComparator implements StringComparatorInterface
{
    /**
     * Function used to compare the arguments.
     * @var string
     */
    protected $comparatorMethod;

    /**
     * Set the comparator has insensitive.
     * 
     * @return $this
     */
    public function withInsensitive()
    {
        $this->comparatorMethod = 'strcasecmp';

        return $this;
    }

    /**
     * Set the comparator has sensitive.
     * 
     * @return $this
     */
    public function withSensitive()
    {
        $this->comparatorMethod = 'strcmp';

        return $this;
    }

    /**
     * Compares two arguments.
     * 
     * @param  string $firstItem
     * @param  string $secondItem
     * @return int
     */
    public function compare($firstItem, $secondItem)
    {
        if (! $this->comparatorMethod) {
            $this->withSensitive();
        }

        $method = $this->comparatorMethod;

        $result = $method($firstItem, $secondItem);

        if($result == 0) {
            $result =  0;
        } else if ($result >= 1) {
            $result = 1;
        } else if($result <= -1) {
            $result = -1;
        }

        return $result;
    }
}
