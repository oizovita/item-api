<?php

namespace Src\Controllers;

use Core\Request;
use Core\JsonResponse;
use Exception;
use Src\Contracts\ItemRepositoryInterface;
use Src\Repositories\ItemRepository;

/**
 * Class ItemController
 */
class ItemController
{
    /**
     * @var itemRepository
     */
    private ItemRepositoryInterface $itemRepository;

    /**
     * ItemController constructor.
     */
    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Get all items
     *
     * @return string
     * @throws Exception
     */
    public function index(): string
    {
        return JsonResponse::toJson(['data' => $this->itemRepository->all()]);
    }

    /**
     * Get one item by id
     *
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function show(Request $request): string
    {
        return JsonResponse::toJson($this->itemRepository->find($request->getParam())->toArray());
    }
}