<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try {
            $users = $this->userRepository->getUsers();
            return response()->json(['success' => true, 'message' => true, 'data' => $users], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json(['error' => true, 'message' => false, 'data' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function store(UserRequest $request)
    {
        try {
            $user = $this->userRepository->save($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Usuario incluido com sucesso',
                'data' => $user
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        try {
            $user = $this->userRepository->find($id);
            return response()->json([
                'status' => true,
                'message' => 'Usuario encontrado',
                'data' => $user
            ], Response::HTTP_OK);
        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $id)
    {
        try {
            if($request->password === null) {

                $this->userRepository->update($request->id, $request->except([$request->password]));
            }
            if($request->password !== null) {

                $this->userRepository->update($id, $request->all());
            }

            return response()->json([
                'status' => true,
                'message' => 'Usuario alterado com sucesso',
                'data' => $id
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($id)
    {
        try {
            $user = $this->userRepository->find($id);
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Usuario excluido com sucesso',
                'data' => $id
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getWithTrashed(Request $request)
    {
        try {

            $users = $this->userRepository->withTrashed()->where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Usuario encontrado',
                'data' => $users
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateWithTrashed(Request $request)
    {
        try {
            $user = $this->userRepository->withTrashed()->where('email', $request->email);
            $user->update(array('deleted_at' => null));

            return response()->json([
                'status' => true,
                'message' => 'Usuario Recuperado',
                'data' => $user->first()
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
