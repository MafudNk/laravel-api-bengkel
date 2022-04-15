<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TDetailPerbaikanCreateRequest;
use App\Http\Requests\TDetailPerbaikanUpdateRequest;
use App\Repositories\TDetailPerbaikanRepository;
use App\Validators\TDetailPerbaikanValidator;

/**
 * Class TDetailPerbaikansController.
 *
 * @package namespace App\Http\Controllers;
 */
class TDetailPerbaikansController extends Controller
{
    /**
     * @var TDetailPerbaikanRepository
     */
    protected $repository;

    /**
     * @var TDetailPerbaikanValidator
     */
    protected $validator;

    /**
     * TDetailPerbaikansController constructor.
     *
     * @param TDetailPerbaikanRepository $repository
     * @param TDetailPerbaikanValidator $validator
     */
    public function __construct(TDetailPerbaikanRepository $repository, TDetailPerbaikanValidator $validator)
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
        $tDetailPerbaikans = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tDetailPerbaikans,
            ]);
        }

        return view('tDetailPerbaikans.index', compact('tDetailPerbaikans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TDetailPerbaikanCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TDetailPerbaikanCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tDetailPerbaikan = $this->repository->create($request->all());

            $response = [
                'message' => 'TDetailPerbaikan created.',
                'data'    => $tDetailPerbaikan->toArray(),
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
        $tDetailPerbaikan = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tDetailPerbaikan,
            ]);
        }

        return view('tDetailPerbaikans.show', compact('tDetailPerbaikan'));
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
        $tDetailPerbaikan = $this->repository->find($id);

        return view('tDetailPerbaikans.edit', compact('tDetailPerbaikan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TDetailPerbaikanUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TDetailPerbaikanUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tDetailPerbaikan = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TDetailPerbaikan updated.',
                'data'    => $tDetailPerbaikan->toArray(),
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
                'message' => 'TDetailPerbaikan deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TDetailPerbaikan deleted.');
    }
}
