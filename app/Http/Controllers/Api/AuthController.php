<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{

    private $userRepository;

    public function __construct(UserRepository $userRepository ) {
        $this->userRepository = $userRepository;

    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(AuthRequest $request)
    {
        try {

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email / Senha Invalido.',
                ], Response::HTTP_UNAUTHORIZED);
            }

            $user = $this->userRepository->findByColumn('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Login Efetuado com sucesso',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me() {
         try {
            return response()->json([
                'status' => true,
                'data' => Auth::user()
            ], Response::HTTP_OK);

        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request) {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Logout efetuado com sucesso'
            ], Response::HTTP_OK);
        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
