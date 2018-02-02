<?php

namespace Pixelant\PxaProductManager\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use Pixelant\PxaProductManager\Utility\AttributeHolderUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 *
 *
 * @package pxa_product_manager
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Product extends AbstractEntity
{

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Category>
     */
    protected $categories;

    /**
     * name
     *
     * @var \string
     * @validate NotEmpty
     */
    protected $name;

    /**
     * sku
     *
     * @var \string
     */
    protected $sku;

    /**
     * description
     *
     * @var \string
     */
    protected $description;

    /**
     * importId
     *
     * @var \string
     */
    protected $importId;

    /**
     * importName
     *
     * @var \string
     */
    protected $importName;

    /**
     * disableSingleView
     *
     * @var boolean
     */
    protected $disableSingleView = false;

    /**
     * @var \string
     */
    protected $alternativeTitle = '';

    /**
     * @var \string
     */
    protected $pathSegment = '';

    /**
     * @var \string
     */
    protected $keywords = '';

    /**
     * @var \string
     */
    protected $metaDescription = '';

    /**
     * relatedProducts
     *
     * @lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Product>
     */
    protected $relatedProducts;

    /**
     * Images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Image>
     * @lazy
     */
    protected $images;

    /**
     * Images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Image>
     * @lazy
     */
    protected $attributeImages;

    /**
     * links
     *
     * @lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Link>
     */
    protected $links;

    /**
     * subProducts
     *
     * @lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Product>
     */
    protected $subProducts;

    /**
     * Fal links
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     */
    protected $falLinks;

    /**
     * Attributes
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Attribute>
     */
    protected $attributes;

    /**
     * Attributes grouped by sets
     *
     * @var ObjectStorage
     */
    protected $attributesGroupedBySets;

    /**
     * attributeValues
     *
     * @lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\AttributeValue>
     */
    protected $attributeValues;

    /**
     * @var int
     */
    protected $crdate;

    /**
     * @var int
     */
    protected $tstamp;

    /**
     * @var boolean
     */
    protected $hidden;

    /**
     * @var boolean
     */
    protected $deleted;

    /**
     * Attribute values
     *
     * @var string
     */
    protected $serializedAttributesValues = '';

    /**
     * Product main image
     *
     * @var Image
     */
    protected $mainImage;

    /**
     * Product listing image
     * @var Image
     */
    protected $thumbnailImage;

    /**
     * Save result for __call method
     *
     * @var array
     */
    protected $magicCallMethodCache = [];

    /**
     * attributesDescription
     *
     * @var \string
     */
    protected $attributesDescription;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->relatedProducts = new ObjectStorage();

        $this->images = new ObjectStorage();

        $this->attributeImages = new ObjectStorage();

        $this->links = new ObjectStorage();

        $this->subProducts = new ObjectStorage();

        $this->falLinks = new ObjectStorage();

        $this->categories = new ObjectStorage();

        $this->attributeValues = new ObjectStorage();
    }

    /**
     * Returns the name
     *
     * @return \string $name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param \string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns the sku
     *
     * @return \string $sku
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * Sets the sku
     *
     * @param \string $sku
     * @return void
     */
    public function setSku(string $sku)
    {
        $this->sku = $sku;
    }

    /**
     * Adds a Product
     *
     * @param \Pixelant\PxaProductManager\Domain\Model\Product $relatedProduct
     * @return void
     */
    public function addRelatedProduct(Product $relatedProduct)
    {
        $this->relatedProducts->attach($relatedProduct);
    }

    /**
     * Removes a Product
     *
     * @param \Pixelant\PxaProductManager\Domain\Model\Product $relatedProductToRemove The Product to be removed
     * @return void
     */
    public function removeRelatedProduct(Product $relatedProductToRemove)
    {
        $this->relatedProducts->detach($relatedProductToRemove);
    }

    /**
     * Returns the relatedProducts
     *
     * @return ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Product> $relatedProducts
     */
    public function getRelatedProducts(): ObjectStorage
    {
        return $this->relatedProducts;
    }

    /**
     * Sets the relatedProducts
     *
     * @param ObjectStorage <\Pixelant\PxaProductManager\Domain\Model\Product> $relatedProducts
     * @return void
     */
    public function setRelatedProducts(ObjectStorage $relatedProducts)
    {
        $this->relatedProducts = $relatedProducts;
    }

    /**
     * Returns the description
     *
     * @return \string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param \string $description
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Adds a Image
     *
     * @param Image $image
     * @return void
     */
    public function addImage(Image $image)
    {
        $this->images->attach($image);
    }

    /**
     * Removes a Image
     *
     * @param Image $image The Image to be removed
     * @return void
     */
    public function removeImage(Image $image)
    {
        $this->images->detach($image);
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Image> $images
     */
    public function getImages(): ObjectStorage
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Image> $images
     * @return void
     */
    public function setImages(ObjectStorage $images)
    {
        $this->images = $images;
    }

    /**
     * Adds a AttributeImage
     *
     * @param Image $image
     * @return void
     */
    public function addAttributeImage(Image $image)
    {
        $this->attributeImages->attach($image);
    }

    /**
     * Removes a AttributeImage
     *
     * @param Image $image The Image to be removed
     * @return void
     */
    public function removeAttributeImage(Image $image)
    {
        $this->attributeImages->detach($image);
    }

    /**
     * Returns the AttributeImage
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Image> $images
     */
    public function getAttributeImages(): ObjectStorage
    {
        return $this->attributeImages;
    }

    /**
     * Sets the AttributeImage
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Image> $images
     * @return void
     */
    public function setAttributeImages(ObjectStorage $images)
    {
        $this->attributeImages = $images;
    }

    /**
     * Adds a Category
     *
     * @param Category $category
     * @return void
     */
    public function addCategory(Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Category> $categories
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Returns the categories
     *
     * @return \Pixelant\PxaProductManager\Domain\Model\Category
     */
    public function getFirstCategory()
    {
        $this->categories->rewind();
        return $this->categories->current();
    }

    /**
     * Sets the categories
     *
     * @param ObjectStorage <\Pixelant\PxaProductManager\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Attribute> $attributes
     */
    public function getAttributes(): ObjectStorage
    {
        if ($this->attributes === null) {
            if (!(int)$this->getUid()) {
                return (new ObjectStorage());
            }
            $this->initializeAttributes();
        }

        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getAttributesGroupedBySets(): ObjectStorage
    {
        if ($this->attributesGroupedBySets === null) {
            if (!(int)$this->getUid()) {
                return (new ObjectStorage());
            }
            $this->initializeAttributes();
        }

        return $this->attributesGroupedBySets;
    }

    /**
     * @param ObjectStorage <\Pixelant\PxaProductManager\Domain\Model\Attribute> $attributes
     */
    public function setAttributes(ObjectStorage $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Adds a attribute
     *
     * @param Attribute $attribute
     * @return void
     */
    public function addAttribute(Attribute $attribute)
    {
        if ($this->attributes === null) {
            $this->attributes = new ObjectStorage();
        }
        $this->attributes->attach($attribute);
    }

    /**
     * Removes a attribute
     *
     * @param Attribute $attribute
     * @return void
     */
    public function removeAttribute(Attribute $attribute)
    {
        if ($this->attributes !== null) {
            $this->attributes->detach($attribute);
        }
    }


    /**
     * Adds a AttributeValue
     *
     * @param AttributeValue $attributeValue
     * @return void
     */
    public function addAttributeValue(AttributeValue $attributeValue)
    {
        $this->attributeValues->attach($attributeValue);
    }

    /**
     * Removes a AttributeValue
     *
     * @param AttributeValue $attributeValueToRemove The AttributeValue to be removed
     * @return void
     */
    public function removeAttributeValue(AttributeValue $attributeValueToRemove)
    {
        $this->attributeValues->detach($attributeValueToRemove);
    }

    /**
     * Returns the attributeValues
     *
     * @return ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\AttributeValue> $attributeValues
     */
    public function getAttributeValues(): ObjectStorage
    {
        return $this->attributeValues;
    }

    /**
     * Sets the attributeValues
     *
     * @param ObjectStorage <\Pixelant\PxaProductManager\Domain\Model\AttributeValue> $attributeValues
     * @return void
     */
    public function setAttributeValues(ObjectStorage $attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }

    /**
     * getMainProductImage
     *
     * @return Image
     */
    public function getMainImage()
    {
        if ($this->mainImage === null) {
            $this->mainImage = $this->getImageFor('mainImage');
        }
        return $this->mainImage;
    }

    /**
     * getThumbnail
     *
     * @return Image
     */
    public function getThumbnail()
    {
        if ($this->thumbnailImage === null) {
            $this->thumbnailImage = $this->getImageFor('useInListing');
        }
        return $this->thumbnailImage;
    }

    /**
     * Returns the importId
     *
     * @return \string $importId
     */
    public function getImportId(): string
    {
        return $this->importId;
    }

    /**
     * Sets the importId
     *
     * @param \string $importId
     * @return void
     */
    public function setImportId(string $importId)
    {
        $this->importId = $importId;
    }

    /**
     * Returns the importName
     *
     * @return \string $importName
     */
    public function getImportName(): string
    {
        return $this->importName;
    }

    /**
     * Sets the importName
     *
     * @param \string $importName
     * @return void
     */
    public function setImportName(string $importName)
    {
        $this->importName = $importName;
    }

    /**
     * Adds a File
     *
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        $this->links->attach($link);
    }

    /**
     * Removes a File
     *
     * @param Link $linkToRemove The Link to be removed
     */
    public function removeLink(Link $linkToRemove)
    {
        $this->links->detach($linkToRemove);
    }

    /**
     * Returns the links
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Link> links
     */
    public function getLinks(): ObjectStorage
    {
        return $this->links;
    }

    /**
     * Sets the links
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Link> $links
     */
    public function setLinks(ObjectStorage $links)
    {
        $this->links = $links;
    }

    /**
     * Sets the disableSingleView
     *
     * @param boolean $disableSingleView
     * @return void
     */
    public function setDisableSingleView(bool $disableSingleView)
    {
        $this->disableSingleView = $disableSingleView;
    }

    /**
     * Returns the boolean state of disableSingleView
     *
     * @return boolean
     */
    public function isDisableSingleView()
    {
        return $this->disableSingleView;
    }

    /**
     * Returns the boolean state of disableSingleView
     *
     * @return boolean
     */
    public function getDisableSingleView()
    {
        return $this->disableSingleView;
    }

    /**
     * Adds a Product
     *
     * @param Product $subProduct
     * @return void
     */
    public function addSubProduct(Product $subProduct)
    {
        $this->subProducts->attach($subProduct);
    }

    /**
     * Removes a Product
     *
     * @param Product $subProductToRemove The Product to be removed
     * @return void
     */
    public function removeSubProduct(Product $subProductToRemove)
    {
        $this->subProducts->detach($subProductToRemove);
    }

    /**
     * Returns the subProducts
     *
     * @return ObjectStorage<\Pixelant\PxaProductManager\Domain\Model\Product> $subProducts
     */
    public function getSubProducts(): ObjectStorage
    {
        return $this->subProducts;
    }

    /**
     * Sets the subProducts
     *
     * @param ObjectStorage <\Pixelant\PxaProductManager\Domain\Model\Product> $subProducts
     * @return void
     */
    public function setSubProducts(ObjectStorage $subProducts)
    {
        $this->subProducts = $subProducts;
    }


    /**
     * Get alternative title
     *
     * @return \string
     */
    public function getAlternativeTitle(): string
    {
        return $this->alternativeTitle;
    }

    /**
     * Set alternative title
     *
     * @param \string $alternativeTitle
     * @return void
     */
    public function setAlternativeTitle(string $alternativeTitle)
    {
        $this->alternativeTitle = $alternativeTitle;
    }

    /**
     * Get path segment
     *
     * @return \string
     */
    public function getPathSegment(): string
    {
        return $this->pathSegment;
    }

    /**
     * Set path segment
     *
     * @param \string $pathSegment
     * @return void
     */
    public function setPathSegment(string $pathSegment)
    {
        $this->pathSegment = $pathSegment;
    }

    /**
     * Get keywords
     *
     * @return \string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }

    /**
     * Set keywords
     *
     * @param \string $keywords keywords
     * @return void
     */
    public function setKeywords(string $keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription metaDescription
     * @return void
     */
    public function setMetaDescription(string $metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * Sorted images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getImagesSorted(): ObjectStorage
    {
        $images = $this->getImages();

        if ($images->count() > 1 && ($mainImage = $this->getMainImage())) {
            $sortedImages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

            /** @var Image $image */
            foreach ($images as $image) {
                if ($image->getOriginalResource()->getUid() === $mainImage->getUid()) {
                    $sortedImages->attach($image);
                    $images->detach($image);
                }
            }

            $sortedImages->addAll($images);

            return $sortedImages;
        }

        return $images;
    }

    /**
     * Adds a FalLink
     *
     * @param FileReference $falLink
     * @return void
     */
    public function addFalLink(FileReference $falLink)
    {
        $this->falLinks->attach($falLink);
    }

    /**
     * Removes a FalLinks
     *
     * @param FileReference $falLink The FalLink to be removed
     * @return void
     */
    public function removeFalLink(FileReference $falLink)
    {
        $this->falLinks->detach($falLink);
    }

    /**
     * Returns the falLinks
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $falLinks
     */
    public function getFalLinks(): ObjectStorage
    {
        return $this->falLinks;
    }

    /**
     * Sets the falLinks
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $falLinks
     * @return void
     */
    public function setFalLinks(ObjectStorage $falLinks)
    {
        $this->falLinks = $falLinks;
    }

    /**
     * @return string
     */
    public function getSerializedAttributesValues(): string
    {
        return $this->serializedAttributesValues;
    }

    /**
     * @param string $serializedAttributesValues
     */
    public function setSerializedAttributesValues(string $serializedAttributesValues)
    {
        $this->serializedAttributesValues = $serializedAttributesValues;
    }


    /**
     * Get creation date
     *
     * @return int
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }

    /**
     * Set Creation Date
     *
     * @param int $crdate crdate
     * @return void
     */
    public function setCrdate(int $crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Get Tstamp
     *
     * @return int
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    /**
     * Set tstamp
     *
     * @param int $tstamp tstamp
     * @return void
     */
    public function setTstamp(int $tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Get Hidden
     *
     * @return boolean
     */
    public function getHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * Set Hidden
     *
     * @param boolean $hidden
     * @return void
     */
    public function setHidden(bool $hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Get Deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set Deleted
     *
     * @param boolean $deleted
     * @return void
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * Get attributesDescription
     *
     * @return string
     */
    public function getAttributesDescription(): string
    {
        return $this->attributesDescription;
    }

    /**
     * Set attributesDescription
     *
     * @param string $attributesDescription attributesDescription
     * @return void
     */
    public function setAttributesDescription(string $attributesDescription)
    {
        $this->attributesDescription = $attributesDescription;
    }

    /**
     * Get image for different views
     *
     * @param string $propertyName
     * @return null|object|Image
     */
    protected function getImageFor($propertyName)
    {
        if ($this->images->count()) {
            /** @var Image $image */
            foreach ($this->images as $image) {
                if (ObjectAccess::isPropertyGettable($image, $propertyName)
                    && ObjectAccess::getProperty($image, $propertyName) === true
                ) {
                    return $image;
                }
            }

            // use any if no result
            $this->images->rewind();
            return $this->images->current();
        }

        return null;
    }

    /**
     * __call
     *
     * @param $methodName
     * @param $arguments
     * @return object
     */
    public function __call($methodName, $arguments)
    {
        if (array_key_exists($methodName, $this->magicCallMethodCache)) {
            return $this->magicCallMethodCache[$methodName];
        }
        // Getting custom attributes
        if (strpos($methodName, 'get') === 0) {
            $identifier = lcfirst(substr($methodName, 3));

            // Check identifier
            /** @var Attribute $attribute */
            foreach ($this->getAttributes() as $attribute) {
                if (lcfirst($attribute->getIdentifier()) === $identifier) {
                    $this->magicCallMethodCache[$methodName] = $attribute;
                    return $attribute;
                }
            }

            // If no identifier found, then check name
            /** @var Attribute $attribute */
            foreach ($this->getAttributes() as $attribute) {
                if (lcfirst($attribute->getName()) === $identifier) {
                    $this->magicCallMethodCache[$methodName] = $attribute;
                    return $attribute;
                }
            }
        }

        return null;
    }

    /**
     * Initialize attributes
     */
    protected function initializeAttributes()
    {
        $this->attributes = new ObjectStorage();

        $categories = [];
        /** @var Category $category */
        foreach ($this->getCategories() as $category) {
            $categories[] = $category->getUid();
        }

        /** @var AttributeHolderUtility $attributeHolder */
        $attributeHolder = GeneralUtility::makeInstance(AttributeHolderUtility::class);
        $attributeHolder->start($categories);

        $this->attributesGroupedBySets = $attributeHolder->getAttributeSets();

        $attributesValues = (array)unserialize($this->getSerializedAttributesValues());

        /** @var Attribute $attribute */
        foreach ($attributeHolder->getAttributes() as $attribute) {
            $id = $attribute->getUid();

            if ($attribute->getType() === Attribute::ATTRIBUTE_TYPE_IMAGE) {
                $attribute->setValue(array_filter(
                    $this->attributeImages->toArray(),
                    function ($item) use ($id) {
                        return $item->getPxaAttribute() === $id;
                    }
                ));
            } elseif (array_key_exists($id, $attributesValues)) {
                $value = $attributesValues[$id];

                switch ($attribute->getType()) {
                    case Attribute::ATTRIBUTE_TYPE_DROPDOWN:
                    case Attribute::ATTRIBUTE_TYPE_MULTISELECT:
                        $options = [];

                        /** @var Option $option */
                        foreach ($attribute->getOptions() as $option) {
                            if (GeneralUtility::inList($value, $option->getUid())) {
                                $options[] = $option;
                            }
                        }

                        $attribute->setValue($options);
                        break;
                    case Attribute::ATTRIBUTE_TYPE_DATETIME:
                        if ($value) {
                            try {
                                $value = new \DateTime($value);
                            } catch (\Exception $exception) {
                                $value = '';
                            }
                        }
                        $attribute->setValue($value);
                        break;
                    default:
                        $attribute->setValue($value);
                }
            }

            $this->attributes->attach($attribute);
        }
    }
}