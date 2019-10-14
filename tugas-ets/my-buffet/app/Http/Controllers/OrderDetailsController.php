<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OrderDetailCreateRequest;
use App\Http\Requests\OrderDetailUpdateRequest;
use App\Repositories\OrderDetailRepository;
use App\Validators\OrderDetailValidator;

/**
 * Class OrderDetailsController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrderDetailsController extends Controller
{
    /**
     * @var OrderDetailRepository
     */
    protected $repository;

    /**
     * @var OrderDetailValidator
     */
    protected $validator;

    /**
     * OrderDetailsController constructor.
     *
     * @param OrderDetailRepository $repository
     * @param OrderDetailValidator $validator
     */
    public function __construct(OrderDetailRepository $repository, OrderDetailValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderDetails = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $orderDetails,
            ]);
        }

        return view('orderDetails.index', compact('orderDetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderDetailCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OrderDetailCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $orderDetail = $this->repository->create($request->all());

            $response = [
                'message' => 'OrderDetail created.',
                'data'    => $orderDetail->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderDetail = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $orderDetail,
            ]);
        }

        return view('orderDetails.show', compact('orderDetail'));
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
        $orderDetail = $this->repository->find($id);

        return view('orderDetails.edit', compact('orderDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderDetailUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OrderDetailUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $orderDetail = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'OrderDetail updated.',
                'data'    => $orderDetail->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
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
                'message' => 'OrderDetail deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OrderDetail deleted.');
    }
}
