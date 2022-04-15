<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TPerbaikanCreateRequest;
use App\Http\Requests\TPerbaikanUpdateRequest;
use App\Repositories\TPerbaikanRepository;
use App\Validators\TPerbaikanValidator;

/**
 * Class TPerbaikansController.
 *
 * @package namespace App\Http\Controllers;
 */
class TPerbaikansController extends Controller
{
    /**
     * @var TPerbaikanRepository
     */
    protected $repository;

    /**
     * @var TPerbaikanValidator
     */
    protected $validator;

    /**
     * TPerbaikansController constructor.
     *
     * @param TPerbaikanRepository $repository
     * @param TPerbaikanValidator $validator
     */
    public function __construct(TPerbaikanRepository $repository, TPerbaikanValidator $validator)
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
        $tPerbaikans = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPerbaikans,
            ]);
        }

        return view('tPerbaikans.index', compact('tPerbaikans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TPerbaikanCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TPerbaikanCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tPerbaikan = $this->repository->create($request->all());

            $response = [
                'message' => 'TPerbaikan created.',
                'data'    => $tPerbaikan->toArray(),
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
        $tPerbaikan = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tPerbaikan,
            ]);
        }

        return view('tPerbaikans.show', compact('tPerbaikan'));
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
        $tPerbaikan = $this->repository->find($id);

        return view('tPerbaikans.edit', compact('tPerbaikan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TPerbaikanUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TPerbaikanUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tPerbaikan = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TPerbaikan updated.',
                'data'    => $tPerbaikan->toArray(),
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
                'message' => 'TPerbaikan deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TPerbaikan deleted.');
    }
}
