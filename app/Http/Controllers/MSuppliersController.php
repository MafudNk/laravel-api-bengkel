<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MSupplierCreateRequest;
use App\Http\Requests\MSupplierUpdateRequest;
use App\Repositories\MSupplierRepository;
use App\Validators\MSupplierValidator;

/**
 * Class MSuppliersController.
 *
 * @package namespace App\Http\Controllers;
 */
class MSuppliersController extends Controller
{
    /**
     * @var MSupplierRepository
     */
    protected $repository;

    /**
     * @var MSupplierValidator
     */
    protected $validator;

    /**
     * MSuppliersController constructor.
     *
     * @param MSupplierRepository $repository
     * @param MSupplierValidator $validator
     */
    public function __construct(MSupplierRepository $repository, MSupplierValidator $validator)
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
        $mSuppliers = $this->repository->all();

        if (request()->wantsJson()) {

            return ResponseFormatter::success($mSuppliers, 'data master supplier');
        }

        return view('mSuppliers.index', compact('mSuppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MSupplierCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mSupplier = $this->repository->create($request->all());

            $response = [
                'message' => 'MSupplier created.',
                'data'    => $mSupplier->toArray(),
            ];

            if ($request->wantsJson()) {

                return ResponseFormatter::success($mSupplier, 'data berhasil ditambahkan');
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
        $mSupplier = $this->repository->find($id);

        if (request()->wantsJson()) {

            return ResponseFormatter::success($mSupplier, 'data detail supplier');
        }

        return view('mSuppliers.show', compact('mSupplier'));
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
        $mSupplier = $this->repository->find($id);

        return view('mSuppliers.edit', compact('mSupplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MSupplierUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MSupplierUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mSupplier = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MSupplier updated.',
                'data'    => $mSupplier->toArray(),
            ];

            if ($request->wantsJson()) {

                return ResponseFormatter::success($mSupplier, 'data berhasil di update');
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
                'message' => 'MSupplier deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MSupplier deleted.');
    }
}
