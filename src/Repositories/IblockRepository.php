<?php

declare(strict_types=1);

namespace PrettyBx\Repositories\Repositories;

use Prozorov\Repositories\AbstractRepository;
use PrettyBx\Support\Traits\LoadsModules;
use Prozorov\Repositories\Parameters;
use PrettyBx\Repositories\Facades\IblockElement;

class IblockRepository extends AbstractRepository
{
    use LoadsModules;

    protected $modules = ['iblock'];

    public function __construct()
    {
        $this->loadModules();
    }

    /**
     * @inheritDoc
     */
    protected function doCreate(array $data)
    {
        return IblockElement::Add($data);
    }

    /**
     * @inheritDoc
     */
    protected function doUpdate($model, array $data): void
    {
        if (! is_int($model)) {
            throw new \InvalidArgumentException('Model must be an integer');
        }

        if (! IblockElement::Update($model, $data)) {
            throw new \RuntimeException('Unable to save data');
        }
    }

    /**
     * @inheritDoc
     */
    protected function doDelete(int $id): void
    {
        if (! IblockElement::Delete($id)) {
            throw new \RuntimeException('Unable to delete data');
        }
    }

    /**
     * @inheritDoc
     */
    protected function doCount(array $filter = []): int
    {
        return 1;
    }

    /**
     * @inheritDoc
     */
    protected function doExists(array $filter): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function doGet(array $filter, Parameters $params = null)
    {
        $select = array_merge(['ID'], $params ? $params->getSelect() ?? [] : []);
        $orderBy = $params ? $params->getOrderBy() ?? false : false;
        $pagination = $this->getPagination($params);

        $query = IblockElement::GetList(
            $orderBy,
            $filter,
            false,
            $this->getPagination($params),
            $select
        );

        $data = [];

        while ($row = $query->GetNext()) {
            $data[$row['ID']] = $row;
        }

        return $data;
    }

    /**
     * getPagination.
     *
     * @access	protected
     * @param	Parameters	$params	Default: null
     * @return	array|false
     */
    protected function getPagination(Parameters $params = null)
    {
        if (empty($params)) {
            return false;
        }

        $pageNum = (int) $params->getOffset() / $params->getLimit();

        return [
            'iNumPage' => $pageNum,
            'nPageSize' => $params->getLimit(),
        ];
    }
}
