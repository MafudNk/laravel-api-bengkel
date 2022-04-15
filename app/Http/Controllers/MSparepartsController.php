<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MSparepartCreateRequest;
use App\Http\Requests\MSparepartUpdateRequest;
use App\Repositories\MSparepartRepository;
use App\Validators\MSparepartValidator;

/**
 * Class MSparepartsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MSparepartsController extends Controller
{
    /**
     * @var MSparepartRepository
     */
    protected $repository;

    /**
     * @var MSparepartValidator
     */
    protected $validator;

    /**
     * MSparepartsController constructor.
     *
     * @param MSparepartRepository $repository
     * @param MSparepartValidator $validator
     */
    public function __construct(MSparepartRepository $repository, MSparepartValidator $validator)
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
        $mSpareparts = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mSpareparts,
            ]);
        }

        return view('mSpareparts.index', compact('mSpareparts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MSparepartCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MSparepartCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mSparepart = $this->repository->create($request->all());

            $response = [
                'message' => 'MSparepart created.',
                'data'    => $mSparepart->toArray(),
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
        $mSparepart = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mSparepart,
            ]);
        }

        return view('mSpareparts.show', compact('mSparepart'));
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
        $mSparepart = $this->repository->find($id);

        return view('mSpareparts.edit', compact('mSparepart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MSparepartUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MSparepartUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mSparepart = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MSparepart updated.',
                'data'    => $mSparepart->toArray(),
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
                'message' => 'MSparepart deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MSparepart deleted.');
    }
}
