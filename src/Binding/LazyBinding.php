<?php

/*
 * This file is part of the puli/discovery package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Puli\Discovery\Binding;

use Puli\Repository\Resource\Collection\ResourceCollection;
use Puli\Repository\Resource\Collection\ResourceCollectionInterface;
use Puli\Repository\Resource\ResourceInterface;
use Puli\Repository\ResourceRepositoryInterface;

/**
 * Binds lazily resources loaded to a type.
 *
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class LazyBinding extends AbstractBinding
{
    /**
     * @var ResourceCollectionInterface
     */
    private $resources;

    /**
     * @var ResourceRepositoryInterface
     */
    private $repo;

    /**
     * Creates a new binding.
     *
     * @param string                      $path       The path of the binding.
     * @param ResourceRepositoryInterface $repo       The repository to load the
     *                                                resources from.
     * @param BindingType                 $type       The type to bind against.
     * @param array                       $parameters Additional parameters.
     *
     * @throws BindingException If the binding fails.
     */
    public function __construct($path, ResourceRepositoryInterface $repo, BindingType $type, array $parameters = array())
    {
        parent::__construct($path, $type, $parameters);

        $this->repo = $repo;
    }

    /**
     * {@inheritdoc}
     */
    public function getResources()
    {
        if (null === $this->resources) {
            $this->resources = $this->repo->find($this->getPath());
        }

        return $this->resources;
    }
}
