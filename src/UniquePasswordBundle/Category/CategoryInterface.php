<?php

namespace UniquePasswordBundle\Category;

/**
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */
interface CategoryInterface
{

    public function encode();

    public function decode();
}
