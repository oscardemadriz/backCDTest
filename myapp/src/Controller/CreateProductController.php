<?php
// api/src/Controller/CreateProductPublication.php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;

class CreateProductController
{
    private $ProductPublishingHandler;

    public function __construct(ProductRepository $ProductPublishingHandler)
    {
        $this->ProductPublishingHandler = $ProductPublishingHandler;
    }

    public function __invoke(Product $data): Product
    {
        $data->setBasePrice(100);
        $this->ProductPublishingHandler->handle($data);

        return $data;
    }
}
