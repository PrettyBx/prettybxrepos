<?php

declare(strict_types=1);

namespace PrettyBx\Repositories\Repositories;

use Prozorov\Repositories\AbstractRepository;
use PrettyBx\Support\Traits\LoadsModules;
use Prozorov\Repositories\Query;
use PrettyBx\Repositories\Facades\IblockElement;

class IblockRepository extends AbstractRepository
{
    use LoadsModules;

    protected $modules = ['iblock'];

    /**
     * @var int $iblockId
     */
    protected $iblockId;

    public function __construct(int $iblockId = null)
    {
        $this->loadModules();

        if (! empty($iblockId)) {
            $this->iblockId = $iblockId;
        }
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
    protected function doGet(Query $query)
    {
        $where = $query->getWhere();

        if (! empty($this->iblockId)) {
            $where = array_merge($where, ['IBLOCK_ID' => $this->iblockId]);
        }

        $iblockQuery = IblockElement::GetList(
            $query->getOrderBy() ?? false,
            $where,
            false,
            $this->getPagination($query),
            array_merge(['ID'], $query->getSelect())
        );

        $data = [];

        while ($row = $iblockQuery->GetNext()) {
            $data[$row['ID']] = $row;
        }

        return $data;
    }

    /**
     * getPagination.
     *
     * @access	protected
     * @param	Query $query
     * @return	array|false
     */
    protected function getPagination(Query $query)
    {
        $pageNum = (int) $query->getOffset() / $query->getLimit();

        return [
            'iNumPage' => $pageNum,
            'nPageSize' => $query->getLimit(),
        ];
    }

    /**
     * getIblockId.
     *
     * @access	public
     * @return	int|null
     */
    public function getIblockId(): ?int
    {
        return $this->iblockId;
    }
}
