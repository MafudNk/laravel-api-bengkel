<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TPenerimaanBarangCreateRequest;
use App\Http\Requests\TPenerimaanBarangUpdateRequest;
use App\Repositories\TPenerimaanBarangRepository;
use App\Validators\TPenerimaanBarangValidator;

/**
 * Class TPenerimaanBarangsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TPenerimaanBarangsController extends Controller
{
    /**
     * @var TPenerimaanBarangRepository
     */
    protected $repository;

    /**
     * @var TPenerimaanBarangValidator
     */
    protected $validator;

    /**
     * TPenerimaanBarangsController constructor.
     *
     * @param TPenerimaanBarangRepository $repository
     * @param TPenerimaanBarangValidator $validator
     */
    public function __construct(TPenerimaanBarangRepository $repository, TPenerimaanBarangValidator $validator)
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
        $tPenerimaanBarangs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPenerimaanBarangs,
            ]);
        }

        return view('tPenerimaanBarangs.index', compact('tPenerimaanBarangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TPenerimaanBarangCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TPenerimaanBarangCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tPenerimaanBarang = $this->repository->create($request->all());

            $response = [
                'message' => 'TPenerimaanBarang created.',
                'data'    => $tPenerimaanBarang->toArray(),
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
        $tPenerimaanBarang = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPenerimaanBarang,
            ]);
        }

        return view('tPenerimaanBarangs.show', compact('tPenerimaanBarang'));
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
        $tPenerimaanBarang = $this->repository->find($id);

        return view('tPenerimaanBarangs.edit', compact('tPenerimaanBarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TPenerimaanBarangUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TPenerimaanBarangUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tPenerimaanBarang = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TPenerimaanBarang updated.',
                'data'    => $tPenerimaanBarang->toArray(),
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
                'message' => 'TPenerimaanBarang deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TPenerimaanBarang deleted.');
    }
}
