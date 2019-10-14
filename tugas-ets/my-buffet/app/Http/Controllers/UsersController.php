<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use App\Entities\User;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * UsersController constructor.
     *
     * @param UserRepository $repository
     * @param UserValidator $validator
     */
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->middleware('guest:user')->except('logout','adminHome','show','edit','update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $users = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $users,
            ]);
        }

        return view('users.index', compact('users'));
    }

    public function adminHome()
    {
        $menu = DB::table('menu_restaurants')->count();
        $user = DB::table('users')->count();
        $restaurant = DB::table('restaurants')->count();
        $order = DB::table('orders')->count();
        $data = [
            'menu' => $menu,
            'user' => $user,
            'restaurant' => $restaurant,
            'order' => $order,
        ];
        return view('admin.home', compact('data'));
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

        if(Auth::guard('user')->attempt($credentials, $remember)){
            if(Auth::user()->role == User::ROLE_NON_ADMIN){
                return redirect()->route('user.home');
            } elseif (Auth::user()->role == User::ROLE_ADMIN){
                return redirect()->route('admin.home');
            }
        } else {
            return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors(['password'=>'Username atau Password yang dimasukan salah','username'=>'.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        Auth('restaurant')->logout();
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UserCreateRequest $request)
    {
        try {
            //dd($this->validator->with($request->all())->passesOrFail());
            $this->validator->with($request->all())->passesOrFail();

            $user = $this->repository->create([
                'nama' => $request['nama'],
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'alamat' => $request['alamat'],
                'nomor_telepon' => $request['nomor_telepon'],
            ]);

            $response = [
                'message' => 'User created.',
                'data'    => $user->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            dd($e);
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
    public function show()
    {
        $user = $this->repository->find(Auth::user()->id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $user,
            ]);
        }

        return view('users.profile', compact('user'));
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
        $user = $this->repository->find(Auth::user()->id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UserUpdateRequest $request)
    {
        $id = Auth::user()->id;

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $user_now = $this->repository->find(Auth::user()->id);

            $update = [
                'nama' => $request['nama'],
                'username' => $request['username'],
                'alamat' => $request['alamat'],
                'nomor_telepon' => $request['nomor_telepon'],
                'email' => $request['email'],
            ];

            if(Hash::check($request['passwd'], $user_now->password) && $request['password'] == $request['password_confirmation']) {
                $update = array_merge($update, [
                    'password' => Hash::make($request['password']),
                ]);
            }

            $uploadedFile = $request->file('foto');
            if ($uploadedFile != null){
                $path = $uploadedFile->store('user/'.$id,'public');
                $cropped= $request['new_image'];

                list($type, $cropped) = explode(';', $cropped);
                list(, $cropped)      = explode(',', $cropped);
                $cropped = base64_decode($cropped);
                Storage::put('/public/'.$path, $cropped);
                $update = array_merge($update, [
                    'avatar' => $path,
                ]);
            }

            $user = $this->repository->update($update, $id);

            $response = [
                'message' => 'User updated.',
                'data'    => $user->toArray(),
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
                'message' => 'User deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'User deleted.');
    }
}
