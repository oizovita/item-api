<?php

namespace Src\Controllers;

use Core\App;
use Core\Repository;
use Core\Request;
use Core\Response;
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
    public function __construct()
    {
        $this->itemRepository = App::getInstance()->getContainer()->get(ItemRepositoryInterface::class);
    }

    /**
     * Get all items
     *
     * @return false|string
     * @throws Exception
     */
    public function index(): false|string
    {
        return Response::toJson(['data' => $this->itemRepository->all()]);
    }

    /**
     * Get one item by id
     *
     * @param $id
     * @return false|string
     * @throws Exception
     */
    public function show(Request $request): false|string
    {
        return Response::toJson($this->itemRepository->findById($request->getParam())->toArray());
    }
}