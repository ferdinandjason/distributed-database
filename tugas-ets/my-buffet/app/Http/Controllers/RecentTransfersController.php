<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RecentTransferCreateRequest;
use App\Http\Requests\RecentTransferUpdateRequest;
use App\Repositories\RecentTransferRepository;
use App\Validators\RecentTransferValidator;

/**
 * Class RecentTransfersController.
 *
 * @package namespace App\Http\Controllers;
 */
class RecentTransfersController extends Controller
{
    /**
     * @var RecentTransferRepository
     */
    protected $repository;

    /**
     * @var RecentTransferValidator
     */
    protected $validator;

    /**
     * RecentTransfersController constructor.
     *
     * @param RecentTransferRepository $repository
     * @param RecentTransferValidator $validator
     */
    public function __construct(RecentTransferRepository $repository, RecentTransferValidator $validator)
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
        $recentTransfers = $this->repository->all();
        //dd($recentTransfers->get());
        //$recentTransfers = array_reverse($recentTransfers);

        return response()->json([
            'data' => $recentTransfers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RecentTransferCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RecentTransferCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $recentTransfer = $this->repository->create($request->all());

            $response = [
                'message' => 'RecentTransfer created.',
                'data'    => $recentTransfer->toArray(),
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
        $recentTransfer = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $recentTransfer,
            ]);
        }

        return view('recentTransfers.show', compact('recentTransfer'));
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
        $recentTransfer = $this->repository->find($id);

        return view('recentTransfers.edit', compact('recentTransfer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RecentTransferUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RecentTransferUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $recentTransfer = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RecentTransfer updated.',
                'data'    => $recentTransfer->toArray(),
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
                'message' => 'RecentTransfer deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RecentTransfer deleted.');
    }
}
