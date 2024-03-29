<?php

namespace Src\Controllers;

use Core\Controller;
use Core\Request;
use Core\Response;
use Exception;
use Src\Contracts\ItemRepositoryInterface;
use Src\Repositories\ItemRepository;

/**
 * Class ItemController
 */
class ItemController extends Controller
{
    /**
     * @var ItemRepositoryInterface The repository to access items.
     */
    private ItemRepositoryInterface $itemRepository;

    /**
     * ItemController constructor.
     *
     * @param ItemRepositoryInterface $itemRepository The repository to access items.
     */
    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Get all items.
     *
     * @return string A JSON string containing all items.
     */
    public function index(): string
    {
        return Response::toJson(['data' => $this->itemRepository->all()]);
    }

    /**
     * Get one item by id.
     *
     * @param Request $request The HTTP request.
     * @return string A JSON string containing the item.
     * @throws Exception If the item is not found.
     */
    public function show(Request $request): string
    {
        $item = $this->itemRepository->find($request->getParam());
        if (!$item) {
            throw new Exception('Item not found', Response::HTTP_NOT_FOUND);
        }

        return Response::toJson($item->toArray());
    }
}