<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService extends Service
{
    protected OrderRepository $repository;

    public function __construct()
    {
        $this->repository = new OrderRepositoryEloquent(app());
    }

    public function orders(array $params): LengthAwarePaginator
    {
        /** @var Order $query */
        $query = $this->repository;
        $page = $params['page'];
        $perPage = $params['perPage'];
        return $query->query()
            ->select([
                'orders.id',
                'samples.id AS sample_id',
                'samples.name AS sample',
                'order_statuses.id AS status_id',
                'order_statuses.name AS status',
                DB::raw("CONCAT('[', GROUP_CONCAT(JSON_OBJECT('number', order_quantities.number,'quantity', order_quantities.quantity)), ']') AS quantities"),
                DB::raw('SUM(order_quantities.quantity) AS quantity'),
                'samples.value AS unity',
                DB::raw('SUM(order_quantities.quantity) * samples.value AS value'),
                'orders.observation',
                DB::raw("DATE_FORMAT(IFNULL(orders.finished_at, orders.created_at),'%d/%m/%Y') AS date"),
            ])
            ->join('samples', 'samples.id', 'orders.sample_id')
            ->join('order_statuses', 'order_statuses.id', 'orders.order_status_id')
            ->join('order_quantities', 'order_quantities.order_id', 'orders.id')
            ->groupBy('orders.id')
            ->orderByDesc('orders.id')
            ->paginate($perPage, ['*'], "orders - $page", $page);
    }

    public function chartMonth(): array
    {
        /** @var Order $query */
        $query = $this->repository;
        return $query->query()
            ->select([
                DB::raw('MONTH(IFNULL(orders.finished_at, orders.created_at)) AS month'),
                DB::raw('SUM(order_quantities.quantity * samples.value) AS value'),
            ])
            ->join('samples', 'samples.id', 'orders.sample_id')
            ->join('order_quantities', 'order_quantities.order_id', 'orders.id')
            ->groupByRaw('MONTH(IFNULL(orders.finished_at, orders.created_at))')
            ->get()
            ->toArray();
    }

    public function status(): array
    {
        return OrderStatus::query()
            ->select([
                'id as value',
                'name as title',
            ])
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }

    public function numbers(): array
    {
        return Order::numbers;
    }

    public function create(array $attributes, array $numbers): bool
    {
        $attributes['finished_at'] = $attributes['order_status_id'] === 3 ? Carbon::now() : null;
        /** @var Order $order */
        $order = $this->repository->create($attributes);

        $order->addQuantities($numbers);

        return $order->exists();
    }

    public function update(int $id, array $attributes, array $numbers = []): bool
    {
        $attributes['finished_at'] = $attributes['order_status_id'] === 3 ? Carbon::now() : null;
        /** @var Order $order */
        $order = $this->repository->update($attributes, $id);

        if (count($numbers)) {
            $order->updateQuantities($numbers);
        }
        return $order->wasChanged() || count($numbers);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
