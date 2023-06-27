<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\BookRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository) {
        $this->bookRepository = $bookRepository;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try {
            $bookStore = $this->bookRepository->getBooks();

            if($bookStore->count() == 0)
                return response()->json(['success' => true, 'message' => 'Nenhum registro encontrado', 'data' => []], Response::HTTP_OK);

            if($bookStore->count() > 0)
                return response()->json(['success' => true, 'message' => 'Registros encontrados', 'data' => $bookStore], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json(['error' => true, 'message' => false, 'data' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function store(BookRequest $request)
    {
        try {

            $arrBookStore = $request->all();
            $arrBookStore['user_id'] = Auth::id();

            $bookStore = $this->bookRepository->save($arrBookStore);

            return response()->json([
                'status' => true,
                'message' => 'Livro incluido com sucesso',
                'data' => $bookStore
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
            $bookStore = $this->bookRepository->find($id);
            return response()->json([
                'status' => true,
                'message' => 'Livro encontrado',
                'data' => $bookStore
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
    public function update(BookRequest $request, $id)
    {
        try {

            $this->bookRepository->update($id, $request->all());

            return response()->json([
                'status' => true,
                'message' => 'Livro alterado com sucesso',
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
            $bookStore = $this->bookRepository->find($id);
            $bookStore->delete();
            return response()->json([
                'status' => true,
                'message' => 'Livro excluido com sucesso',
                'data' => $id
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
