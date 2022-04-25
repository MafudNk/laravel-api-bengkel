<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TPenerimaanBarangDetailCreateRequest;
use App\Http\Requests\TPenerimaanBarangDetailUpdateRequest;
use App\Repositories\TPenerimaanBarangDetailRepository;
use App\Validators\TPenerimaanBarangDetailValidator;

/**
 * Class TPenerimaanBarangDetailsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TPenerimaanBarangDetailsController extends Controller
{
    /**
     * @var TPenerimaanBarangDetailRepository
     */
    protected $repository;

    /**
     * @var TPenerimaanBarangDetailValidator
     */
    protected $validator;

    /**
     * TPenerimaanBarangDetailsController constructor.
     *
     * @param TPenerimaanBarangDetailRepository $repository
     * @param TPenerimaanBarangDetailValidator $validator
     */
    public function __construct(TPenerimaanBarangDetailRepository $repository, TPenerimaanBarangDetailValidator $validator)
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
        $tPenerimaanBarangDetails = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPenerimaanBarangDetails,
            ]);
        }

        return view('tPenerimaanBarangDetails.index', compact('tPenerimaanBarangDetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TPenerimaanBarangDetailCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TPenerimaanBarangDetailCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tPenerimaanBarangDetail = $this->repository->create($request->all());

            $response = [
                'message' => 'TPenerimaanBarangDetail created.',
                'data'    => $tPenerimaanBarangDetail->toArray(),
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
        $tPenerimaanBarangDetail = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPenerimaanBarangDetail,
            ]);
        }

        return view('tPenerimaanBarangDetails.show', compact('tPenerimaanBarangDetail'));
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
        $tPenerimaanBarangDetail = $this->repository->find($id);

        return view('tPenerimaanBarangDetails.edit', compact('tPenerimaanBarangDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TPenerimaanBarangDetailUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TPenerimaanBarangDetailUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tPenerimaanBarangDetail = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TPenerimaanBarangDetail updated.',
                'data'    => $tPenerimaanBarangDetail->toArray(),
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
                'message' => 'TPenerimaanBarangDetail deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TPenerimaanBarangDetail deleted.');
    }
}
