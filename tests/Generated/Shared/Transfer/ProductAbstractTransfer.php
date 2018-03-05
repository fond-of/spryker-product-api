<?php

namespace Generated\Shared\Transfer;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class ProductAbstractTransfer extends AbstractTransfer
{
    const ID_PRODUCT_ABSTRACT = 'idProductAbstract';

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var int
     */
    protected $idProductAbstract;

    /**
     * @param int $idProductAbstract
     *
     * @return $this
     */
    public function setIdProductAbstract($idProductAbstract)
    {
        $this->idProductAbstract = $idProductAbstract;
        $this->modifiedProperties[self::ID_PRODUCT_ABSTRACT] = true;

        return $this;
    }

    /**
     * @module ProductApi
     *
     * @return int
     */
    public function getIdProductAbstract()
    {
        return $this->idProductAbstract;
    }
}
