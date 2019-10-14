<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MenuRestaurantCreateRequest;
use App\Http\Requests\MenuRestaurantUpdateRequest;
use App\Repositories\MenuRestaurantRepository;
use App\Validators\MenuRestaurantValidator;

/**
 * Class MenuRestaurantsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MenuRestaurantsController extends Controller
{
    /**
     * @var MenuRestaurantRepository
     */
    protected $repository;

    /**
     * @var MenuRestaurantValidator
     */
    protected $validator;

    /**
     * MenuRestaurantsController constructor.
     *
     * @param MenuRestaurantRepository $repository
     * @param MenuRestaurantValidator $validator
     */
    public function __construct(MenuRestaurantRepository $repository, MenuRestaurantValidator $validator)
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
        $menuRestaurants = $this->repository->getMenu(Auth('restaurant')->user()->id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $menuRestaurants,
            ]);
        }

        return view('menuRestaurants.index', compact('menuRestaurants'));
    }

    public function indexResto($id)
    {
        $menuRestaurants = $this->repository->getMenu($id);
        return view('users.orderResto', compact('menuRestaurants','id'));
    }

    public function new()
    {
        return view('menuRestaurants.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuRestaurantCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(MenuRestaurantCreateRequest $request)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $uploadedFile = $request->file('foto');

            $path = $uploadedFile->store('foto/'.$request['restaurant_id'],'public');

            $cropped= $request['new_image'];

            list($type, $cropped) = explode(';', $cropped);
            list(, $cropped)      = explode(',', $cropped);
            $cropped = base64_decode($cropped);

            Storage::put('/public/'.$path, $cropped);

            $menuRestaurant = $this->repository->create([
                'restaurant_id' => $request['restaurant_id'],
                'nama_makanan' => $request['nama_makanan'],
                'deskripsi' => $request['deskripsi'],
                'kategori' => strtolower($request['kategori']),
                'harga' => $request['harga'],
                'foto' => $path,
                'stok' => $request['stok'],
            ]);

            $response = [
                'message' => 'MenuRestaurant created.',
                'data'    => $menuRestaurant->toArray(),
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
        $menuRestaurant = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $menuRestaurant,
            ]);
        }

        return view('menuRestaurants.show', compact('menuRestaurant'));
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
        $menuRestaurant = $this->repository->find($id);

        return view('menuRestaurants.edit', compact('menuRestaurant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MenuRestaurantUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MenuRestaurantUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $uploadedFile = $request->file('foto');

            $path = $uploadedFile->store('foto/'.$request['restaurant_id'],'public');

            $cropped= $request['new_image'];

            list($type, $cropped) = explode(';', $cropped);
            list(, $cropped)      = explode(',', $cropped);
            $cropped = base64_decode($cropped);

            Storage::put('/public/'.$path, $cropped);

            $menuRestaurant = $this->repository->update([
                'restaurant_id' => $request['restaurant_id'],
                'nama_makanan' => $request['nama_makanan'],
                'deskripsi' => $request['deskripsi'],
                'kategori' => strtolower($request['kategori']),
                'harga' => $request['harga'],
                'foto' => $path,
                'stok' => $request['stok'],
            ], $id);

            $response = [
                'message' => 'MenuRestaurant updated.',
                'data'    => $menuRestaurant->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->route('restaurant.menu.index');
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
                'message' => 'MenuRestaurant deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MenuRestaurant deleted.');
    }
}
