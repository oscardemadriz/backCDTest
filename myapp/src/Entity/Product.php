<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ConferenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use App\Controller\ProductController;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ApiResource(
 *     order={"price"="DESC"},
 *     paginationEnabled=true,
 * itemOperations={
 *     "get"
 * }
 * )
 *  
 *  @ApiFilter(SearchFilter::class, properties={"id": "exact", "price": "exact", "description": "partial", "name": "partial", "taxRate" : "exact"})

 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     * @ApiFilter(SearchFilter::class, properties={"product": "exact"})
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $basePrice;

    /**
     * @ORM\ManyToOne(targetEntity=Taxonomy::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
     * 
     */
    private $taxRate;

    /**
     * @ORM\Column(type="blob")
     */
    private $imageBlob;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBasePrice(): ?int
    {
        return $this->basePrice;
    }

    public function setBasePrice(int $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getTaxRate(): ?Taxonomy
    {
        return $this->taxRate;
    }

    public function setTaxRate(?Taxonomy $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'imageBlob' => $this->getImageBlob(),
            'basePrice' => $this->getBasePrice(),
            'taxRate' => $this->getTaxRate(),
        ];
    }

    public function getImageBlob()
    {
        //TODO: is_resource($this->imageBlob) ?  utf8_encode(stream_get_contents($this->imageBlob)) 
        return  (string)$this->imageBlob;
    }

    public function setImageBlob($imageBlob): self
    {
        $this->imageBlob = $imageBlob;

        return $this;
    }
}
