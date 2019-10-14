<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RestaurantCreateRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Repositories\RestaurantRepository;
use App\Validators\RestaurantValidator;
Use App\Entities\Restaurant;

/**
 * Class RestaurantsController.
 *
 * @package namespace App\Http\Controllers;
 */
class RestaurantsController extends Controller
{
    /**
     * @var RestaurantRepository
     */
    protected $repository;

    /**
     * @var RestaurantValidator
     */
    protected $validator;

    /**
     * RestaurantsController constructor.
     *
     * @param RestaurantRepository $repository
     * @param RestaurantValidator $validator
     */
    public function __construct(RestaurantRepository $repository, RestaurantValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        //$this->middleware('guest:restaurant')->except('store','show','indexUser','formLogin','formRegister');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $restaurants = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $restaurants,
            ]);
        }

        return view('restaurants.index', compact('restaurants'));
    }

    public function indexUser()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $restaurants = $this->repository->restaurantWithMenu();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $restaurants,
            ]);
        }

        return view('users.order', compact('restaurants'));
    }

    public function formLogin()
    {
        return view('auth.login');
    }

    public function formRegister()
    {
        return view('auth.register');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $remember = $request['remember'];

        if(Auth::guard('restaurant')->attempt($credentials, $remember)){
            return redirect()->route('restaurant.home');
        } else {
            return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors(['password'=>'Username atau Password yang dimasukan salah','username'=>'.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RestaurantCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RestaurantCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $restaurant = $this->repository->create([
                'nama' => $request['nama'],
                'username' => $request['username'],
                'password' => Hash::make($request['password']),
                'alamat' => $request['alamat'],
                'nomor_telepon' => $request['nomor_telepon'],
            ]);

            $response = [
                'message' => 'Restaurant created.',
                'data'    => $restaurant->toArray(),
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
        $restaurant = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $restaurant,
            ]);
        }

        return view('restaurant.profile', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $restaurant = $this->repository->find(Auth('restaurant')->user()->id);
        return view('restaurant.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RestaurantUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RestaurantUpdateRequest $request)
    {
        $id = Auth('restaurant')->user()->id;

        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $restaurant_now = $this->repository->find(Auth('restaurant')->user()->id);

            $update = [
                'nama' => $request['nama'],
                'username' => $request['username'],
                'alamat' => $request['alamat'],
                'nomor_telepon' => $request['nomor_telepon'],
            ];
            
            if(Hash::check($request['passwd'], $restaurant_now->password) && $request['password'] == $request['password_confirmation']) {
                $update = array_merge($update, [
                    'password' => Hash::make($request['password']),
                ]);
            }

            $uploadedFile = $request->file('foto');
            if ($uploadedFile != null){
                $path = $uploadedFile->store('hotel/'.$id,'public');
                $cropped= $request['new_image'];

                list($type, $cropped) = explode(';', $cropped);
                list(, $cropped)      = explode(',', $cropped);
                $cropped = base64_decode($cropped);
                Storage::put('/public/'.$path, $cropped);
                $update = array_merge($update, [
                    'avatar' => $path,
                ]);
            }

            $restaurant = $this->repository->update($update,$id);

            $response = [
                'message' => 'Restaurant updated.',
                'data'    => $restaurant->toArray(),
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
                'message' => 'Restaurant deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Restaurant deleted.');
    }
}
