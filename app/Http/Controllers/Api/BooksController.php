<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\BookRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\ApiResponse;

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
    public function index()
    {
        try {
            $bookStore = $this->bookRepository->getBooks();

            if($bookStore->count() == 0)  {
                $responsable = new ApiResponse(Response::HTTP_BAD_REQUEST, 'Nenhum registro encontrado');
                $responsable->toResponse($bookStore);
            }

            if($bookStore->count() > 0) {
                $responsable = new ApiResponse(Response::HTTP_OK, 'Registro(s) encontrados', true);
                return $responsable->toResponse($bookStore);
            }
        } catch(\Exception $e) {
            $responsable = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $responsable->toResponse($e);
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
            $arrBookStore['user_id'] = 2;

            $bookStore = $this->bookRepository->save($arrBookStore);

            $responsable = new ApiResponse(Response::HTTP_OK, 'Registro Incluido');
            return $responsable->toResponse($bookStore);

        } catch (\Throwable $th) {
            $responsable = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $th->getMessage());
            return $responsable->toResponse($th);
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
            $code = Response::HTTP_OK;
            $message = 'Registro encontrado';
            if($bookStore == null) {
                $code = Response::HTTP_UNPROCESSABLE_ENTITY;
                $message = 'Registro não encontrado';
            }

            $responsable = new ApiResponse($code, $message);
            return $responsable->toResponse($bookStore);

        } catch(\Throwable $th) {
            $responsable = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $th->getMessage());
            return $responsable->toResponse($th);
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
            $responsable = new ApiResponse(Response::HTTP_OK, 'Livro alterado com sucesso');
            $bookStore = $this->bookRepository->find($id);
            return $responsable->toResponse($bookStore);

        } catch(\Exception $e) {
            $responsable = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $responsable->toResponse($e);
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
            $responsable = new  ApiResponse(Response::HTTP_OK, 'Livro excluido com sucesso');
            return $responsable->toResponse($id);
        } catch(\Exception $e) {
            $responsable = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $responsable->toResponse($e);
        }
    }

}
