<?php namespace App\Modules\Backend\User\Resources;

use App\Models\User;
use Backend\Laravel\Builders\DataTableHeader;
use Backend\Laravel\Builders\DataTableSearchField;
use Backend\Laravel\Resources\DataTableResource;
use Spatie\QueryBuilder\QueryBuilder;

class UserDataTable extends DataTableResource
{
    public string $collects = UserListResource::class;
    public string $path = "/backend/users";
    public string $defaultSort = "-created_at";

    private array $sorts = [
        'created_at',
        'updated_at',
    ];

    public function __construct()
    {
        $items = QueryBuilder::for(User::class)
            ->allowedFilters(['name', 'username'])
            ->defaultSort($this->defaultSort)
            ->allowedSorts($this->sorts)
            ->latest()
            ->paginate();

        parent::__construct($items);
    }

    public function headers(): array
    {
        return [
            DataTableHeader::make("id")
                ->width(60)
                ->label('#'),
            DataTableHeader::make("name")
                ->minWidth(300)
                ->label('نام و نام خانوادگی')
                ->isRightAlign(),
            DataTableHeader::make("type")
                ->width(120)
                ->label('نوع'),
            DataTableHeader::make("created_at")
                ->width(130)
                ->label('ایجاد')
                ->sortable(),
            DataTableHeader::make("updated_at")
                ->width(130)
                ->label('ویرایش')
                ->sortable(),
            DataTableHeader::make("actions")
                ->width(100)
                ->label('عملیات'),
        ];
    }

    public function searchFields(): array
    {
        return [
            DataTableSearchField::make("name")
                ->label('نام و نام خانوادگی')
                ->input(),
            DataTableSearchField::make("username")
                ->label('نام کاربری')
                ->input(),
        ];
    }
}
