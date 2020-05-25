<?php

namespace App\Model;

class Person
{
    public $firstName;
    public $lastName;

    /**
     * Person constructor.
     * @param $firstName
     * @param $lastName
     */
    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function createList() {
        return [
            new Person('Steve', 'Jobs'),
            new Person('Bill', 'Gates'),
            new Person('Elon', 'Musk'),
        ];
    }

}