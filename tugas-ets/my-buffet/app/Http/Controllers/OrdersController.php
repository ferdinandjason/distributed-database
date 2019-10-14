<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Repositories\OrderRepository;
use App\Repositories\OrderDetailRepository;
use App\Validators\OrderValidator;
use Illuminate\Support\Facades\Session;

/**
 * Class OrdersController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    protected $repository;

    /**
     * @var OrderValidator
     */
    protected $validator;

    /**
     * OrdersController constructor.
     *
     * @param OrderRepository $repository
     * @param OrderValidator $validator
     */

    protected $detailRepository;

    public function __construct(OrderRepository $repository, OrderValidator $validator, OrderDetailRepository $orderDetailRepos)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->detailRepository = $orderDetailRepos;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orders = $this->repository->allReversed();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $orders,
            ]);
        }

        return view('admin.order', compact('orders'));
    }

    public function indexRestaurant()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orders = $this->repository->findOrderWithRestaurantId(Auth('restaurant')->user()->id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $orders,
            ]);
        }

        return view('restaurant.order.index', compact('orders'));
    }

    public function history()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orders = $this->repository->findOrderHistory(Auth('restaurant')->user()->id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $orders,
            ]);
        }

        return view('restaurant.order.history', compact('orders'));
    }

    public function bestResto()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $bestResto = $this->repository->getBestResto();
        $recentResto = $this->repository->recentResto(Auth('user')->user()->id);
        $data = array(
            "bestResto" => $bestResto,
            "recentResto" => $recentResto,
        );

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $data,
            ]);
        }

        return view('users.home', compact('data'));
    }

    public function done($id)
    {
        $this->repository->changeStatusToDone($id);

        $response = [
            'message' => 'Order updated.',
        ];

        return redirect()->back()->with('message', $response['message']);
    }

    public function confirmed($id)
    {
        $this->repository->changeStatusToConfirmed($id);

        $response = [
            'message' => 'Order updated.',
        ];

        return redirect()->back()->with('message', $response['message']);
    }

    public function placed($id)
    {
        $this->repository->changeStatusToPlaced($id);

        $response = [
            'message' => 'Order updated.',
        ];

        return redirect()->back()->with('message', $response['message']);
    }

    public function getLastOrder()
    {
        $order = $this->repository->getLastOrder();
        return view('recentTransfers.trf',compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OrderCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $order = $this->repository->create([
                'user_id' => $request['user_id'],
                'restaurant_id' => $request['restaurant_id'],
                'comments' => $request['comments'],
                'total'=> $request['total'],
                'delivery'=> $request['delivery'],
            ]);

            //$orderDetailRepos = new OrderDetailRepository();
            for($i=0; $i < sizeof($request['menu_restaurant_id']); $i++){
                $this->detailRepository->create([
                    'order_id' => $order->id,
                    'menu_restaurant_id' => $request['menu_restaurant_id'][$i],
                    'amount' => $request['amount'][$i],
                    'sub_total' => $request['sub_total'][$i],
                ]);
                $this->detailRepository->decrementMenu($request['menu_restaurant_id'][$i],$request['amount'][$i]);
            }

            $response = [
                'message' => 'Order created.',
                'data'    => $order->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->route('user.order.bayar', $order['id'])->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function bayar($id)
    {
        //$order = Session::get('message')['data'];
        $order = $this->repository->find($id);
        return view('users.orderBayar', compact('order'));
    }

    public function placedd($id)
    {
        $order = $this->repository->find($id);
        return view('users.orderPlaced', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $order,
            ]);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->repository->find($id);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OrderUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $order = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Order updated.',
                'data'    => $order->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->route('user.order.placed', $order->id);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Order deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Order deleted.');
    }
}
