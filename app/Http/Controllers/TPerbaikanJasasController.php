<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TPerbaikanJasaCreateRequest;
use App\Http\Requests\TPerbaikanJasaUpdateRequest;
use App\Repositories\TPerbaikanJasaRepository;
use App\Validators\TPerbaikanJasaValidator;

/**
 * Class TPerbaikanJasasController.
 *
 * @package namespace App\Http\Controllers;
 */
class TPerbaikanJasasController extends Controller
{
    /**
     * @var TPerbaikanJasaRepository
     */
    protected $repository;

    /**
     * @var TPerbaikanJasaValidator
     */
    protected $validator;

    /**
     * TPerbaikanJasasController constructor.
     *
     * @param TPerbaikanJasaRepository $repository
     * @param TPerbaikanJasaValidator $validator
     */
    public function __construct(TPerbaikanJasaRepository $repository, TPerbaikanJasaValidator $validator)
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
        $tPerbaikanJasas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPerbaikanJasas,
            ]);
        }

        return view('tPerbaikanJasas.index', compact('tPerbaikanJasas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TPerbaikanJasaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TPerbaikanJasaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tPerbaikanJasa = $this->repository->create($request->all());

            $response = [
                'message' => 'TPerbaikanJasa created.',
                'data'    => $tPerbaikanJasa->toArray(),
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
        $tPerbaikanJasa = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPerbaikanJasa,
            ]);
        }

        return view('tPerbaikanJasas.show', compact('tPerbaikanJasa'));
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
        $tPerbaikanJasa = $this->repository->find($id);

        return view('tPerbaikanJasas.edit', compact('tPerbaikanJasa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TPerbaikanJasaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TPerbaikanJasaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tPerbaikanJasa = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TPerbaikanJasa updated.',
                'data'    => $tPerbaikanJasa->toArray(),
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
                'message' => 'TPerbaikanJasa deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TPerbaikanJasa deleted.');
    }
}
